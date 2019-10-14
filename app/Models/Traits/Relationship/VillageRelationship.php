<?php

namespace App\Models\Traits\Relationship;

use App\Models\File;
use App\Models\Region;
use App\Models\SiteTree;

trait VillageRelationship
{
    /**
     * Get the region that owns the village.
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the file that owns the village.
     */
    public function file()
    {
        return $this->belongsTo(File::class)->withDefault();
    }

    /**
     * Get the site tree that owns the village.
     */
    public function siteTree()
    {
        return $this->morphOne(SiteTree::class, 'page')->withDefault();
    }
}
