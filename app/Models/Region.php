<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Relationship\RegionRelationship;

class Region extends Model
{
    use RegionRelationship;

    /**
     * Custom polymorph type name.
     *
     * @var string
     */
    public static $custom_type_name = 'region';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];
}
