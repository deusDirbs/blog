<?php

namespace App\Http\Controllers;


use App\Http\Helpers\DataStructureHelper;
use App\Http\Interfaces\ParsingInterface;
use App\Http\Services\ManufactureService;
use App\Http\Services\ParsingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    function createForm()
    {
        return view('parser/create');
    }

    /**
     * @param bool $success
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    private function return(bool $success)
    {
        if ($success) {
            session()->flash('success', 'File success create!');
            return view('xml/create');
        }

        Log::warning('This DATA is in the wrong format!');
        session()->flash('error', 'This DATA is in the wrong format!');

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        if ($this->manufactureService->validateCreateOrUpdateData()) {
            if ($isSuccess = is_string($data = $this->parsingService->getDataForCurl($request->http))) {
                $pregMatchAll = $this->parsingService->pregMatchAll($data);
                $result = $this->parsingService->getFormat($pregMatchAll);
                $isSuccess = $this->manufactureService->saveAll(DataStructureHelper::createManufactureStructure($result, $this->parsingService));
            }

            return $this->return($isSuccess);
        }

        return back();
    }
}
