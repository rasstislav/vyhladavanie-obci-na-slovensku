<?php

namespace App\Models\Traits\Scope;

use Illuminate\Database\Eloquent\Builder;

trait VillageScope
{
    /**
     * Scope a query to only include the villages of the search query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $q
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, string $q)
    {
        return $query
            ->whereHas('siteTree')
            ->whereHas('region.siteTree')
            ->where(function (Builder $query) use ($q) {
                $query
                    ->where('title', 'like', "%{$q}%")
                    ->orWhere('mayor_name', 'like', "%{$q}%")
                ;
            })
        ;
    }
}
