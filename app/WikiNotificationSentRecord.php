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
 * @property int $user_id
 * @property string $notification_type
 *
 * @method static \Database\Factories\WikiNotificationSentRecordFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiNotificationSentRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiNotificationSentRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiNotificationSentRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiNotificationSentRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiNotificationSentRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiNotificationSentRecord whereNotificationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiNotificationSentRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiNotificationSentRecord whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiNotificationSentRecord whereWikiId($value)
 *
 * @mixin \Eloquent
 */
class WikiNotificationSentRecord extends Model {
    use HasFactory;

    const FIELDS = [
        'notification_type',
        'user_id',
    ];

    protected $fillable = self::FIELDS;

    protected $visible = self::FIELDS;

    protected function casts(): array {
        return [
            'notification_type' => 'string',
        ];
    }
}
