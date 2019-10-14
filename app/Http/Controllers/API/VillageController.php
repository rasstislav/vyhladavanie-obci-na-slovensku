<?php

namespace App\Http\Controllers\API;

use App\Models\Village;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\VillageRepository;
use App\Http\Resources\VillageCollection;
use App\Http\Resources\Village as VillageResource;

class VillageController extends Controller
{
    /**
     * @var VillageRepository
     */
    private $userRepository;

    /**
     * VillageController constructor.
     *
     * @param VillageRepository $villageRepository
     */
    public function __construct(VillageRepository $villageRepository)
    {
        $this->villageRepository = $villageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $villages = ($q = strip_tags($request->q)) ?
            $this->villageRepository
                ->with(['region'])
                ->search($q)
                ->get()
        :
            collect([]);

        return new VillageCollection($villages);
    }

    /**
     * Display the specified resource.
     *
     * @param  Village  $village
     * @return \Illuminate\Http\Response
     */
    public function show(Village $village)
    {
        return new VillageResource($village);
    }
}
