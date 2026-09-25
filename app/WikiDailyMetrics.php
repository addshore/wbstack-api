<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $wiki_id
 * @property int $pages
 * @property int $is_deleted
 * @property string $date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $daily_actions
 * @property int|null $weekly_actions
 * @property int|null $monthly_actions
 * @property int|null $quarterly_actions
 * @property int|null $number_of_triples
 * @property int|null $monthly_casual_users
 * @property int|null $monthly_active_users
 * @property int|null $item_count
 * @property int|null $property_count
 * @property int|null $lexeme_count
 * @property int|null $entity_schema_count
 * @property int|null $total_user_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereDailyActions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereEntitySchemaCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereItemCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereLexemeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereMonthlyActions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereMonthlyActiveUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereMonthlyCasualUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereNumberOfTriples($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics wherePages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics wherePropertyCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereQuarterlyActions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereTotalUserCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereWeeklyActions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiDailyMetrics whereWikiId($value)
 *
 * @mixin \Eloquent
 */
class WikiDailyMetrics extends Model {
    use HasFactory;

    protected $table = 'wiki_daily_metrics';

    protected $primaryKey = 'id';

    public $incrementing = false; // Disable auto-increment

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'wiki_id',
        'date',
        'pages',
        'is_deleted',
        'daily_actions',
        'weekly_actions',
        'monthly_actions',
        'quarterly_actions',
        'number_of_triples',
        'item_count',
        'property_count',
        'lexeme_count',
        'entity_schema_count',
        'monthly_casual_users',
        'monthly_active_users',
        'total_user_count',

    ];

    // list of properties which are actual wiki metrics
    public static $metricNames = [
        'pages',
        'is_deleted',
        'daily_actions',
        'weekly_actions',
        'monthly_actions',
        'quarterly_actions',
        'number_of_triples',
        'item_count',
        'property_count',
        'lexeme_count',
        'entity_schema_count',
        'monthly_casual_users',
        'monthly_active_users',
        'total_user_count',
    ];

    public function areMetricsEqual(WikiDailyMetrics $wikiDailyMetrics): bool {
        foreach (self::$metricNames as $field) {
            if ($this->$field != $wikiDailyMetrics->$field) {
                return false;
            }
        }

        return true;
    }
}
