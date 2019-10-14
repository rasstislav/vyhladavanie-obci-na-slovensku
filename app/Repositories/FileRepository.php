<?php

namespace App\Repositories;

use App\Models\File;
use Illuminate\Support\Facades\DB;

class FileRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return File::class;
    }

    /**
     * @param array $data
     * @return File
     *
     * @throws \Exception
     */
    public function updateOrCreate(array $data): File
    {
        return DB::transaction(function () use ($data) {
            $file = $this->model::updateOrCreate([
                'filename' => $data['filename'],
            ], [
                'name' => $data['name'] ?? null,
                'filename' => $data['filename'],
            ]);

            if ($file) {
                return $file;
            }

            throw new \Exception("There was a problem creating or updating the File '{$file->name}'.");
        });
    }
}
