<?php

namespace App\Repositories;

use App\Models\Region;
use Illuminate\Support\Facades\DB;

class RegionRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Region::class;
    }

    /**
     * @param array $data
     * @return Region
     *
     * @throws \Exception
     */
    public function updateOrCreate(array $data): Region
    {
        return DB::transaction(function () use ($data) {
            $region = $this->model::updateOrCreate([
                'title' => $data['title'],
            ], [
                'title' => $data['title'],
            ]);

            if ($region) {
                return $region;
            }

            throw new \Exception("There was a problem creating or updating the Region '{$region->title}'.");
        });
    }
}
