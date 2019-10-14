<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use App\Models\Village;
use Illuminate\Console\Command;
use App\Repositories\VillageRepository;

class GeocodeDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:geocode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geocode data';

    private $villageRepository;

    private $httpClient;
    private $requestParams;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(VillageRepository $villageRepository)
    {
        parent::__construct();

        $this->villageRepository = $villageRepository;

        $this->httpClient = new Client();

        $this->requestParams = [
            'app_id' => config('geocoder.app_id'),
            'app_code' => config('geocoder.app_code'),
        ] + config('geocoder.parameters');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->geocodeAndSaveData()) {
            $this->info('Data geocoding successful.');
        } else {
            $this->error('Data geocoding failed.');
        }
    }

    /**
     * Geocode data.
     *
     * @return bool
     */
    private function geocodeAndSaveData(): bool
    {
        $villages = $this->villageRepository->all();

        foreach ($villages as $village) {
            if (! $data = $this->retrieveData([
                'searchtext' => $village->address,
            ])) {
                return false;
            }

            $this->saveData($village, $data);
        }

        return true;
    }

    /**
     * Retrieve data from Geocoder.
     *
     * @param  array  additionaRequestlParams
     * @return bool
     */
    private function retrieveData(array $additionaRequestlParams): array
    {
        try {
            $request = $this->httpClient->get(config('geocoder.url') . '?' . http_build_query($this->requestParams + $additionaRequestlParams));
            $response = $request->getBody();

            return json_decode($response, true);
        } catch (\Throwable $th) {
            $this->error($th->getMessage());

            return [];
        }
    }

    /**
     * Save location data to the Village.
     *
     * @param  Village  village
     * @param  array  data
     * @return bool
     */
    private function saveData(Village $village, array $data): bool
    {
        ['latitude' => $lat, 'longitude' => $lng] = $data['response']['view'][0]['result'][0]['location']['displayPosition'] ?? null;

        if ($lat && $lng) {
            try {
                return (bool) $this->villageRepository->update($village, [
                    'lat' => $lat,
                    'lng' => $lng,
                ]);
            } catch (\Throwable $th) {
                $this->error($th->getMessage());

                return false;
            }
        }

        $this->error("Can't retrieve location data for address '{$village->address}'.");

        return false;
    }
}
