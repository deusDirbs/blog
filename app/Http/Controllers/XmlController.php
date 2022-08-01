<?php

namespace App\Http\Controllers;

use App\Http\Helpers\DataStructureHelper;
use App\Http\Interfaces\XmlInterface;
use App\Http\Services\ManufactureService;
use App\Http\Services\ParsingService;
use App\Http\Services\XmlService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
     * @var ManufactureService
     */
    private $manufactureService;

    /**
     * @param ParsingService $parsingService
     * @param XmlService $xmlService
     * @param ManufactureService $manufactureService
     */
    public function __construct(ParsingService $parsingService, XmlService $xmlService, ManufactureService $manufactureService)
    {
        $this->parsingService = $parsingService;
        $this->xmlService = $xmlService;
        $this->manufactureService = $manufactureService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function createForm()
    {
        return view('xml/create');
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
     * $result this array
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        if ($this->manufactureService->validateCreateOrUpdateData()) {
            if ($isSuccess = is_string($data = $this->parsingService->getDataForCurl($request->http))) {
                $pregMatchAll = $this->parsingService->pregMatchAll($data);
                $result = $this->parsingService->getFormat($pregMatchAll);
                $isSuccess = $this->xmlService->save(DataStructureHelper::createManufactureStructure($result, $this->parsingService), Auth::user(), Carbon::now());
            }

            return $this->return($isSuccess);
        }

        return back();
    }
}
