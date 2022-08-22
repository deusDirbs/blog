<?php

namespace App\Console\Commands;

use App\Http\Helpers\DataStructureHelper;
use App\Http\Services\ManufactureService;
use App\Http\Services\ParsingService;
use App\Models\Manufacture;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateNewManufactures extends Command
{
    /**
     * The name and signature of the console command.
     * format http: https://standards-oui.ieee.org/
     * @var string
     */
    protected $signature = 'manufactures:create {--http=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creation of new manufactures';

    /**
     * @var ManufactureService
     */
    private $manufactureService;

    /**
     * @var ParsingService
     */
    private $parsingService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManufactureService $manufactureService, ParsingService $parsingService)
    {
        parent::__construct();
        $this->manufactureService = $manufactureService;
        $this->parsingService = $parsingService;
    }

    /**
     * Execute the console command.
     *
     * $$data = Data curl
     * $$pregMatchAll = parsing $data, return array
     * $result = split Data, return array
     */
    public function handle(): void
    {
        if (is_string($data = $this->parsingService->getDataForCurl($this->option('http')))) {
            $pregMatchAll = $this->parsingService->pregMatchAll($data);
            $result = $this->parsingService->getFormat($pregMatchAll);
            $this->manufactureService->saveAll(DataStructureHelper::createManufactureStructure($result, $this->parsingService));
            session()->flash('success', 'File success create!');
            $count = Manufacture::all();
            $this->info('Successfully created new Manufactures, count - '.count($count));
        }  else {
            Log::warning('This DATA is in the wrong format!');
            session()->flash('error', 'This DATA is in the wrong format!');
        }
    }
}
