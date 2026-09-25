<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\ComplaintRecord.
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $mail_address
 * @property string $reason
 * @property string $offending_urls
 * @property Carbon|null $dispatched_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Database\Factories\ComplaintRecordFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComplaintRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComplaintRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComplaintRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComplaintRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComplaintRecord whereDispatchedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComplaintRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComplaintRecord whereMailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComplaintRecord whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComplaintRecord whereOffendingUrls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComplaintRecord whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComplaintRecord whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ComplaintRecord extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'mail_address',
        'reason',
        'offending_urls',
    ];

    public function markAsDispatched() {
        $this->dispatched_at = Carbon::now();
    }
}
