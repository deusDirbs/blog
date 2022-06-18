<?php

namespace App\Http\Controllers;

use App\Http\Helpers\DataStructureHelper;
use App\Http\Interfaces\XmlInterface;
use App\Http\Services\ParsingService;
use App\Http\Services\XmlService;

class XmlController extends Controller implements XmlInterface
{
    /**
     * @var ParsingService
     */
    private $parsingService;

    /**
     * @var XmlService
     */
    private $xmlService;

    /**
     * @param ParsingService $parsingService
     * @param XmlService $xmlService
     */
    public function __construct(ParsingService $parsingService, XmlService $xmlService)
    {
        $this->parsingService = $parsingService;
        $this->xmlService = $xmlService;
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $getCurl = $this->parsingService->getCurl('https://standards-oui.ieee.org/');
        $matches = $this->parsingService->pregMatchAll($getCurl);
        $result = $this->parsingService->getFormat($matches);

        $this->xmlService->save(DataStructureHelper::createManufactureStructure($result, $this->parsingService));
    }
}
