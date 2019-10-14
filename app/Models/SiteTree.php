<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Scope\SiteTreeScope;
use App\Models\Traits\Relationship\SiteTreeRelationship;

class SiteTree extends Model
{
    use HasSlug,
        SiteTreeRelationship,
        SiteTreeScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'page_type',
        'title',
        'parent_id',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('url_segment')
            ->doNotGenerateSlugsOnUpdate()
        ;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'url_segment';
    }

    /**
     * Return the link for this Site Tree.
     *
     * @return string
     */
    public function Link()
    {
        if ($this->parent_id) {
            $base = ($parent = $this->Parent) ? $parent->Link() . '/' . $this->url_segment : null;
        } else {
            $base = $this->url_segment;
        }

        return $base;
    }

    protected function otherRecordExistsWithSlug(string $slug): bool
    {
        $key = $this->getKey();

        if ($this->incrementing) {
            $key = $key ?? '0';
        }

        $query = static::where($this->slugOptions->slugField, $slug)
            ->where('parent_id', '=', $this->parent_id)
            ->where($this->getKeyName(), '!=', $key)
            ->withoutGlobalScopes()
        ;

        if ($this->usesSoftDeletes()) {
            $query->withTrashed();
        }

        return $query->exists();
    }
}
