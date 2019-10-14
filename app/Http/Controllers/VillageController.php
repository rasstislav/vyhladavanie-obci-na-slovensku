<?php

namespace App\Http\Controllers;

use App\Models\Village;

class VillageController extends Controller
{
    /**
     * Show the detail.
     *
     * @return View
     */
    public function __invoke(Village $village)
    {
        return view('village')
            ->withVillage($village)
        ;
    }
}
