<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $wiki_id
 * @property string $selectedOption
 * @property string|null $freeTextResponse
 * @property-read Wiki|null $wiki
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeEquityResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeEquityResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeEquityResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeEquityResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeEquityResponse whereFreeTextResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeEquityResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeEquityResponse whereSelectedOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeEquityResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KnowledgeEquityResponse whereWikiId($value)
 *
 * @mixin \Eloquent
 */
class KnowledgeEquityResponse extends Model {
    use HasFactory;

    protected $fillable = [
        'wiki_id',
        'selectedOption',
        'freeTextResponse',
    ];

    public function wiki(): BelongsTo {
        return $this->belongsTo(Wiki::class);
    }
}
