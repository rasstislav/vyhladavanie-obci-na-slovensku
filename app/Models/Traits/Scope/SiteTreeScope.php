<?php

namespace App\Models\Traits\Scope;

trait SiteTreeScope
{
    /**
     * Scope a query to only include root site trees.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRoot($query)
    {
        return $query->where('parent_id', 0);
    }

    /**
     * Scope a query to only include site trees of a given route key.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereRouteKey($query, string $slug)
    {
        return $query->where($this->getRouteKeyName(), $slug);
    }
}
