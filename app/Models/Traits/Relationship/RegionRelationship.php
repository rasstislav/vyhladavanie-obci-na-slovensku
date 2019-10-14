<?php

namespace App\Models\Traits\Relationship;

use App\Models\SiteTree;

trait RegionRelationship
{
    /**
     * Get the site tree that owns the region.
     */
    public function siteTree()
    {
        return $this->morphOne(SiteTree::class, 'page')->withDefault();
    }
}
