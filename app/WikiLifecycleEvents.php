<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

// This class is supposed to contain information about certain events
// in a wiki's lifecycle, e.g. the time of the last edit. Sources for these
// points in time can be chosen as needed.
/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $first_edited
 * @property Carbon|null $last_edited
 * @property int $wiki_id
 *
 * @method static \Database\Factories\WikiLifecycleEventsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiLifecycleEvents newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiLifecycleEvents newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiLifecycleEvents query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiLifecycleEvents whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiLifecycleEvents whereFirstEdited($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiLifecycleEvents whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiLifecycleEvents whereLastEdited($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiLifecycleEvents whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiLifecycleEvents whereWikiId($value)
 *
 * @mixin \Eloquent
 */
class WikiLifecycleEvents extends Model {
    use HasFactory;

    const FIELDS = [
        'first_edited',
        'last_edited',
    ];

    protected $fillable = self::FIELDS;

    protected $visible = self::FIELDS;

    protected function casts(): array {
        return [
            'first_edited' => 'datetime',
            'last_edited' => 'datetime',
        ];
    }
}
