<?php

namespace App\Repositories;

use App\Models\Village;
use Illuminate\Support\Facades\DB;

class VillageRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Village::class;
    }

    /**
     * @param Village  $village
     * @param array $data
     * @return Village
     *
     * @throws \Exception
     */
    public function update(Village $village, array $data): Village
    {
        return DB::transaction(function () use ($village, $data) {
            if ($village->update([
                'lat' => $data['lat'],
                'lng' => $data['lng'],
            ])) {
                return $village;
            }

            throw new \Exception("There was a problem updating the Village '{$village->title}'.");
        });
    }

    /**
     * @param array $data
     * @return Village
     *
     * @throws \Exception
     */
    public function updateOrCreate(array $data): Village
    {
        return DB::transaction(function () use ($data) {
            $attributes = [
                'title' => $data['title'],
                'region_id' => $data['region_id'],
            ];

            $values = [
                'title' => $data['title'],
                'region_id' => $data['region_id'],
                'file_id' => $data['file_id'],
            ];

            if (isset($data['mayor_name']))
                $values['mayor_name'] = $data['mayor_name'];

            if (isset($data['address']))
                $values['address'] = $data['address'];

            if (isset($data['phone']))
                $values['phone'] = $data['phone'];

            if (isset($data['fax']))
                $values['fax'] = $data['fax'];

            if (isset($data['email']))
                $values['email'] = $data['email'];

            if (isset($data['web']))
                $values['web'] = $data['web'];

            if (isset($data['lat']))
                $values['lat'] = $data['lat'];

            if (isset($data['lng']))
                $values['lng'] = $data['lng'];

            if ($village = $this->model::updateOrCreate($attributes, $values)) {
                return $village;
            }

            throw new \Exception("There was a problem creating or updating the Village '{$village->title}'.");
        });
    }
}
