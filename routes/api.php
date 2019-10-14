<?php

use App\Http\Controllers\API\VillageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'obec'], function () {
    Route::get('/', [VillageController::class, 'index']);
    Route::get('{village}', [VillageController::class, 'show']);
});
