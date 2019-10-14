<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Scope\VillageScope;
use App\Models\Traits\Attribute\VillageAttribute;
use App\Models\Traits\Relationship\VillageRelationship;

class Village extends Model
{
    use VillageAttribute,
        VillageRelationship,
        VillageScope;

    /**
     * Custom polymorph type name.
     *
     * @var string
     */
    public static $custom_type_name = 'village';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'mayor_name',
        'address',
        'phone',
        'fax',
        'email',
        'web',
        'lat',
        'lng',
        'region_id',
        'file_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'address',
    ];
}
