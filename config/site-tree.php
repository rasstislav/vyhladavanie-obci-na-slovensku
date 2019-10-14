<?php

use App\Models\Region;
use App\Models\Village;
use App\Http\Controllers\VillageController;

return [

    'models' => [
        Region::$custom_type_name => Region::class,
        Village::$custom_type_name => Village::class,
    ],

    'controllers' => [
        Village::$custom_type_name => VillageController::class
    ],

];
