<?php

namespace App\Console\Commands;

use Closure;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use KubAT\PhpSimple\HtmlDomParser;
use App\Repositories\FileRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\RegionRepository;
use App\Repositories\VillageRepository;
use App\Repositories\SiteTreeRepository;

class ImportDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data';

    private $fileRepository;
    private $regionRepository;
    private $villageRepository;
    private $siteTreeRepository;

    private $path;
    private $publicPath;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FileRepository $fileRepository, RegionRepository $regionRepository, VillageRepository $villageRepository, SiteTreeRepository $siteTreeRepository)
    {
        parent::__construct();

        $this->fileRepository = $fileRepository;
        $this->regionRepository = $regionRepository;
        $this->villageRepository = $villageRepository;
        $this->siteTreeRepository = $siteTreeRepository;

        $this->path = 'uploads' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR . 'village' . DIRECTORY_SEPARATOR;
        $this->publicPath = public_path($this->path);
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->parseAndImportData()) {
            $this->info('Data import successful.');
        } else {
            $this->error('Data import failed.');
        }
    }

    /**
     * Parse and import data.
     *
     * @return bool
     */
    private function parseAndImportData(): bool
    {
        if ($villageLinks = $this->parseIndex(config('import.villages.web'))) {
            File::makeDirectory($this->publicPath, 0777, true, true);

            foreach ($villageLinks as $villageLink) {
                if ($detailData = $this->parseDetail($villageLink->href)) {
                    $detailData['village_name'] = $villageLink->plaintext;

                    if (! $this->saveData($detailData)) {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }

        return true;
    }

    /**
     * Parse Index and return.
     *
     * @param string  $url
     * @return array
     */
    private function parseIndex(string $url): array
    {
        if (! ($web = $this->parseHtmlFile($url))) {
            return [];
        }

        $villageLinks = [];
        $paginationLinks = $web->find('table[cellspacing="3"]', 0)->parent()->find('a.web');

        foreach ($paginationLinks as $paginationLink) {
            if ($index = $this->parseHtmlFile($paginationLink->href)) {
                $villages = $index->find('table[cellspacing="3"]', 0);

                $villageLinks = array_merge($villageLinks, $villages->find('a'));
            } else {
                return [];
            }
        }

        return $villageLinks;
    }

    /**
     * Parse Detail.
     *
     * @param string  $url
     * @return array
     */
    private function parseDetail(string $url): array
    {
        if (! ($detail = $this->parseHtmlFile($url))) {
            return [];
        }

        $info = $detail->find('table[cellspacing="3"]');
        $baseInfo = $info[0];
        $additionalInfo = $info[1];

        $image = $baseInfo->find('img[title]', 0)->src;
        $phone = ($child = $baseInfo->children(2)) ? trim($child->find('td', -1)->plaintext) ?: null : null;
        $fax = ($child = $baseInfo->children(3)) ? trim($child->find('td', -1)->plaintext) ?: null : null;
        $street = ($child = $baseInfo->children(4)) ? trim($child->find('td', 0)->plaintext) ?: null : null;
        $email = ($child = $baseInfo->children(4)) ? trim($child->find('td', -1)->plaintext) ?: null : null;
        $village = ($child = $baseInfo->children(5)) ? trim($child->find('td', 0)->plaintext) ?: null : null;
        $web = ($child = $baseInfo->children(5)) ? trim($child->find('td', -1)->plaintext) ?: null : null;

        $region = ($child = $additionalInfo->children(1)) ? trim($child->find('td', -1)->plaintext) ?: null : null;
        $mayor_name = ($child = $additionalInfo->children(7)) ? trim($child->find('td', -1)->plaintext) ?: null : null;

        return [
            'image_url' => $image,
            'region_name' => $region,
            'mayor_name' => $mayor_name,
            'phone' => $phone,
            'fax' => $fax,
            'email' => $email,
            'web' => $web,
            'address' => [
                $street,
                $village,
            ],
        ];
    }

    /**
     * Parse HTML file.
     *
     * @param string  $url
     * @return mixed
     */
    private function parseHtmlFile(string $url)
    {
        return $this->tryCatchRepeat(function () use ($url) {
            return HtmlDomParser::file_get_html($url);
        });
    }

    /**
     * Read file.
     *
     * @param string  $url
     * @return mixed
     */
    private function readFile(string $url)
    {
        return $this->tryCatchRepeat(function () use ($url) {
            return file_get_contents($url);
        });
    }

    /**
     * Try-catch and repeat function.
     *
     * @param Closure  $callback
     * @return mixed
     */
    private function tryCatchRepeat(Closure $callback)
    {
        $data = null;

        $NUM_OF_ATTEMPTS = 5;
        $attempts = 0;

        do {
            try {
                $data = $callback();
            } catch (\Throwable $th) {
                $this->error($th->getMessage());
                $this->line('Retrying ...');

                $attempts++;
                sleep(10);

                continue;
            }

            break;
        } while ($attempts < $NUM_OF_ATTEMPTS);

        return $data;
    }

    /**
     * Save data to database.
     *
     * @param array  $data
     * @return bool
     */
    private function saveData(array $data): bool
    {
        try {
            return DB::transaction(function () use ($data) {
                $villageTitle = $data['village_name'];

                if (! ($file = $this->downloadAndSaveImage($data['image_url'], $villageTitle))) {
                    return false;
                }

                $region = $this->regionRepository->updateOrCreate([
                    'title' => $data['region_name'],
                ]);

                $regionPage = $this->siteTreeRepository->updateOrCreate([
                    'page' => $region,
                ]);

                $village = $this->villageRepository->updateOrCreate($data + [
                    'title' => $villageTitle,
                    'region_id' => $region->id,
                    'file_id' => $file->id,
                ]);

                $villagePage = $this->siteTreeRepository->updateOrCreate([
                    'page' => $village,
                    'parent_id' => $regionPage->id,
                ]);

                if ($villagePage) {
                    return true;
                }

                throw new \Exception('There was a problem saving data.');
            });
        } catch (\Throwable $th) {
            $this->error($th->getMessage());

            return false;
        }
    }

    /**
     * Download and save Image to database.
     *
     * @param string  $url
     * @param string  $name
     * @return File
     *
     * @throws \Exception
     */
    private function downloadAndSaveImage(string $url, string $name)
    {
        try {
            $filename = pathinfo($url, PATHINFO_BASENAME);

            if (! file_exists($this->publicPath . $filename)) {
                if (! ($fileData = $this->readFile($url))) {
                    return false;
                }

                file_put_contents($this->publicPath . $filename, $fileData);
            }

            return $this->fileRepository->updateOrCreate([
                'name' => $name,
                'filename' => $this->path . $filename,
            ]);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
