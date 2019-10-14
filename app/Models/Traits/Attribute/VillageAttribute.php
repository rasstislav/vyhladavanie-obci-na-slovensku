<?php

namespace App\Models\Traits\Attribute;

trait VillageAttribute
{
    /**
     * Get the address of the municipal office.
     *
     * @return string
     */
    public function getAddressAttribute()
    {
        return $this->attributes['municipal_office_address'];
    }

    /**
     * Set the address of the municipal office.
     *
     * @param  string  $value
     * @return void
     */
    public function setAddressAttribute(array $values)
    {
        $this->attributes['municipal_office_address'] = rtrim(implode(', ', $values), ', ');
    }

    /**
     * @return string
     */
    public function getGeographicalCoordinatesAttribute()
    {
        return rtrim(implode(', ', [rtrim($this->lat, 0), rtrim($this->lng, 0)]), ', ');
    }
}
