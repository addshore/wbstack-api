<?php

namespace Tests\Routes\Wiki;

use App\QueryserviceNamespace;
use App\User;
use App\Wiki;
use App\WikiDb;
use App\WikiManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Tests\TestCase;
use Throwable;

class CreateConcurrencyTest extends TestCase {
    /**
     * No DatabaseTransactions: the worker connections must see committed fixtures.
     * Requires MariaDB's PROCESSLIST (and PROCESS permission) and pcntl.
     *
     * @dataProvider concurrentCreationProvider
     */
    public function testConcurrentCreation(int|false $limit, bool $differentUsers, int $expectedCreations): void {
        if (!extension_loaded('pcntl') || DB::connection()->getDriverName() !== 'mariadb') {
            $this->markTestSkipped('Requires MariaDB and pcntl for concurrent requests.');
        }

        $token = Str::lower(Str::random(10));
        $directory = sys_get_temp_dir() . '/wiki-quota-' . $token;
        mkdir($directory);
        $user = User::factory()->create(['verified' => true]);
        $otherUser = $differentUsers ? User::factory()->create(['verified' => true]) : $user;
        $existingWiki = Wiki::factory()->create();
        $deletedWiki = Wiki::factory()->create(['deleted_at' => now()]);
        foreach ([$existingWiki, $deletedWiki] as $wiki) {
            WikiManager::factory()->create(['user_id' => $user->id, 'wiki_id' => $wiki->id]);
        }

        // A dedicated DB version prevents unrelated free DBs from hiding allocation bugs.
        Config::set('wbstack.wiki_db_use_version', 'race-' . $token);
        Config::set('wbstack.wiki_max_per_user', $limit);
        Config::set('wbstack.elasticsearch_enabled_by_default', false);
        $dbIds = [];
        $namespaceIds = [];
        for ($i = 0; $i < 2; $i++) {
            $dbIds[] = WikiDb::factory()->create([
                'version' => config('wbstack.wiki_db_use_version'),
                'wiki_id' => null,
            ])->id;
            $namespaceIds[] = QueryserviceNamespace::create([
                'namespace' => $token . '-' . $i,
                'backend' => 'wdqs.svc',
            ])->id;
        }

        $children = [];
        $domains = [$token . '-first.example.com', $token . '-second.example.com'];
        try {
            $children[] = $this->startRequest($user->id, $domains[0], $directory, 0);
            $this->waitUntil(fn () => is_file($directory . '/holding'));
            $children[] = $this->startRequest($otherUser->id, $domains[1], $directory, 1);
            $this->waitUntil(fn () => is_file($directory . '/connection-1'));
            $secondConnection = (int) file_get_contents($directory . '/connection-1');

            // The first request holds its user/resources before inserting WikiManager.
            // Observe request two blocked in the database for at least a second,
            // rather than merely assuming overlap after a sleep. MariaDB can wait
            // during query optimization before exposing the transaction in INNODB_TRX.
            $this->waitUntil(fn () => DB::selectOne(
                'SELECT 1 FROM information_schema.PROCESSLIST
                 WHERE ID = ? AND TIME >= 1 AND INFO IS NOT NULL',
                [$secondConnection]
            ) !== null);
            touch($directory . '/release');
            $this->waitUntil(fn () => is_file($directory . '/result-0') && is_file($directory . '/result-1'));
            $results = [];
            for ($i = 0; $i < 2; $i++) {
                $results[] = json_decode(file_get_contents($directory . '/result-' . $i), true, 512, JSON_THROW_ON_ERROR);
            }
            $this->assertSame($expectedCreations === 1 ? [200, 403] : [200, 200], array_column($results, 'status'), json_encode($results));
            if ($expectedCreations === 1) {
                $this->assertSame('Too many wikis. Your new total of 3 would exceed the limit of 2 per user.', $results[1]['body']['message']);
            }

            $wikiIds = Wiki::whereIn('domain', $domains)->pluck('id');
            $this->assertCount($expectedCreations, $wikiIds);
            $this->assertSame($expectedCreations, WikiManager::whereIn('wiki_id', $wikiIds)->count());
            foreach (['wiki_dbs', 'queryservice_namespaces'] as $table) {
                $assignments = DB::table($table)->whereIn('wiki_id', $wikiIds)->pluck('wiki_id');
                $this->assertCount($expectedCreations, $assignments);
                $this->assertCount($expectedCreations, $assignments->unique());
            }
            $this->assertSame($differentUsers ? 2 : 1 + $expectedCreations, $user->managesWikis()->count());
        } finally {
            // Always unblock/terminate workers before cleaning up committed fixtures.
            touch($directory . '/release');
            foreach ($children as $pid) {
                if (pcntl_waitpid($pid, $status, WNOHANG) === 0) {
                    posix_kill($pid, SIGKILL);
                    pcntl_waitpid($pid, $status);
                }
            }
            DB::purge();
            $wikiIds = Wiki::withTrashed()->whereIn('domain', [...$domains, $existingWiki->domain, $deletedWiki->domain])->pluck('id');
            foreach (['wiki_dbs', 'queryservice_namespaces'] as $table) {
                DB::table($table)->whereIn('wiki_id', $wikiIds)->update(['wiki_id' => null]);
            }
            foreach (['wiki_managers', 'wiki_settings', 'wiki_domains', 'wiki_suspensions'] as $table) {
                DB::table($table)->whereIn('wiki_id', $wikiIds)->delete();
            }
            Wiki::withTrashed()->whereIn('id', $wikiIds)->forceDelete();
            WikiDb::whereIn('id', $dbIds)->delete();
            QueryserviceNamespace::whereIn('id', $namespaceIds)->delete();
            User::whereIn('id', [$user->id, $otherUser->id])->delete();
            foreach (glob($directory . '/*') as $file) {
                unlink($file);
            }
            rmdir($directory);
        }
    }

    public static function concurrentCreationProvider(): array {
        return [
            'one quota slot remains' => [2, false, 1],
            'unlimited quota' => [false, false, 2],
            'different users share resource pools' => [false, true, 2],
        ];
    }

    private function startRequest(int $userId, string $domain, string $directory, int $index): int {
        // Never share PDO sockets across forked processes.
        DB::purge();
        $pid = pcntl_fork();
        if ($pid === -1) {
            $this->fail('Unable to fork a request worker.');
        }
        if ($pid !== 0) {
            return $pid;
        }

        try {
            Queue::fake();
            DB::statement('SET SESSION innodb_lock_wait_timeout = 15');
            $connection = DB::selectOne('SELECT CONNECTION_ID() AS id', [], false)->id;
            $this->writeWorkerFile($directory . '/connection-' . $index, (string) $connection);
            if ($index === 0) {
                WikiManager::creating(function () use ($directory): void {
                    touch($directory . '/holding');
                    $this->waitUntil(fn () => is_file($directory . '/release'));
                });
            }
            $response = $this->actingAs(User::findOrFail($userId), 'api')->postJson('wiki/create', [
                'domain' => $domain,
                'sitename' => 'Concurrent wiki',
                'username' => 'Admin',
            ]);
            $result = ['status' => $response->status(), 'body' => $response->json()];
        } catch (Throwable $exception) {
            $result = ['status' => 0, 'error' => (string) $exception];
        }
        DB::disconnect();
        $this->writeWorkerFile($directory . '/result-' . $index, json_encode($result, JSON_THROW_ON_ERROR));
        exit(0);
    }

    private function writeWorkerFile(string $path, string $contents): void {
        file_put_contents($path . '.tmp', $contents);
        rename($path . '.tmp', $path);
    }

    private function waitUntil(callable $condition): void {
        $deadline = microtime(true) + 10;
        do {
            clearstatcache();
            if ($condition()) {
                return;
            }
            usleep(10000);
        } while (microtime(true) < $deadline);

        $this->fail('Timed out waiting for concurrent requests to reach the expected database lock.');
    }
}
