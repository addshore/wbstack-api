<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $wiki_id
 * @property string $purpose
 * @property string|null $purpose_other
 * @property string|null $audience
 * @property string|null $audience_other
 * @property string $temporality
 * @property string|null $temporality_other
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Wiki|null $wiki
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiProfile whereAudience($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiProfile whereAudienceOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiProfile wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiProfile wherePurposeOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiProfile whereTemporality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiProfile whereTemporalityOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiProfile whereWikiId($value)
 *
 * @mixin \Eloquent
 */
class WikiProfile extends Model {
    use HasFactory;

    protected $fillable = [
        'wiki_id',
        'purpose',
        'purpose_other',
        'audience',
        'audience_other',
        'temporality',
        'temporality_other',
    ];

    public function wiki(): BelongsTo {
        return $this->belongsTo(Wiki::class);
    }
}
