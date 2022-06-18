<?php

namespace App\Http\Controllers;


use App\Http\Helpers\DataStructureHelper;
use App\Http\Interfaces\ParsingInterface;
use App\Http\Services\ManufactureService;
use App\Http\Services\ParsingService;

class ParsingController extends Controller implements ParsingInterface
{
    /**
     * @var ParsingService
     */
    private $parsingService;

    /**
     * @var ManufactureService
     */
    private $manufactureService;

    /**
     * @param ParsingService $parsingService
     * @param ManufactureService $manufactureService
     */
    public function __construct(ParsingService $parsingService, ManufactureService $manufactureService)
    {
        $this->parsingService = $parsingService;
        $this->manufactureService = $manufactureService;
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $getCurl = $this->parsingService->getCurl('https://standards-oui.ieee.org/');
        $matches = $this->parsingService->pregMatchAll($getCurl);
        $result = $this->parsingService->getFormat($matches);

        $this->manufactureService->saveAll(DataStructureHelper::createManufactureStructure($result, $this->parsingService));
    }
}
