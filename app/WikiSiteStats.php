<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

// This class is supposed to be a 1:1 representation of the data returned
// by calling the MediaWiki API with parameters
// `?action=query&meta=siteinfo&siprop=statistics`
// When adding additional data about a wiki that comes from a different
// source, consider storing it elsewhere.
/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $pages
 * @property int $articles
 * @property int $edits
 * @property int $images
 * @property int $users
 * @property int $activeusers
 * @property int $admins
 * @property int $jobs
 * @property int $cirrussearch-article-words
 * @property int $wiki_id
 *
 * @method static \Database\Factories\WikiSiteStatsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats whereActiveusers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats whereAdmins($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats whereArticles($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats whereCirrussearchArticleWords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats whereEdits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats whereJobs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats wherePages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats whereUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WikiSiteStats whereWikiId($value)
 *
 * @mixin \Eloquent
 */
class WikiSiteStats extends Model {
    use HasFactory;

    const FIELDS = [
        'pages',
        'articles',
        'edits',
        'images',
        'users',
        'activeusers',
        'admins',
        'jobs',
        'cirrussearch-article-words',
    ];

    protected $fillable = self::FIELDS;

    protected $visible = self::FIELDS;
}
