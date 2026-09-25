<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $wiki_id
 * @property WikiEntityImportStatus $status
 * @property string|null $started_at
 * @property string|null $finished_at
 * @property array<array-key, mixed>|null $payload
 *
 * @method static \Database\Factories\WikiEntityImportFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiEntityImport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiEntityImport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiEntityImport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiEntityImport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiEntityImport whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiEntityImport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiEntityImport wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiEntityImport whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiEntityImport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiEntityImport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiEntityImport whereWikiId($value)
 *
 * @mixin \Eloquent
 */
class WikiEntityImport extends Model {
    use HasFactory;

    const FIELDS = [
        'status',
        'started_at',
        'finished_at',
        'payload',
    ];

    protected $fillable = self::FIELDS;

    protected $visible = self::FIELDS;

    protected function casts(): array {
        return [
            'status' => WikiEntityImportStatus::class,
            'payload' => 'array',
        ];
    }
}
