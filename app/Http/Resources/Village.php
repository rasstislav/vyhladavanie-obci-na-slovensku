<?php

namespace App\Http\Resources;

use App\Http\Resources\Region as RegionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Village extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($request->village) {
            $resource['link'] = $this->siteTree->Link();
        } else {
            $resource = [
                'id' => $this->id,
                'title' => $this->title,
                'region' => new RegionResource($this->region),
            ];
        }

        return $resource;
    }
}
