<?php

namespace App\Models\Traits\Relationship;

use App\Models\SiteTree;

trait SiteTreeRelationship
{
    /**
     * Get the parent that owns the Site Tree.
     */
    public function parent()
    {
        return $this->belongsTo(SiteTree::class, 'parent_id', 'id');
    }

    /**
     * Get the children for the Site Tree.
     */
    public function children()
    {
        return $this->hasMany(SiteTree::class, 'parent_id', 'id');
    }

    /**
     * Get the owning page model.
     */
    public function page()
    {
        return $this->morphTo();
    }
}
