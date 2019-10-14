<?php

namespace App\Repositories;

use App\Models\SiteTree;
use Illuminate\Support\Facades\DB;

class SiteTreeRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return SiteTree::class;
    }

    /**
     * @param array $data
     * @return SiteTree
     *
     * @throws \Exception
     */
    public function updateOrCreate(array $data): SiteTree
    {
        return DB::transaction(function () use ($data) {
            $siteTree = $this->model::updateOrCreate([
                'page_id' => $data['page']->id,
                'page_type' => $data['page']::$custom_type_name,
                'parent_id' => $data['parent_id'] ?? 0,
            ], [
                'page_id' => $data['page']->id,
                'page_type' => $data['page']::$custom_type_name,
                'title' => $data['page']->title ?: $data['title'],
                'parent_id' => $data['parent_id'] ?? 0,
            ]);

            if ($siteTree) {
                return $siteTree;
            }

            throw new \Exception("There was a problem creating or updating the Site Tree '{$siteTree->title}'.");
        });
    }
}
