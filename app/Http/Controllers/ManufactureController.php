<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ManufactureInterface;
use App\Http\Services\ManufactureService;
use App\Models\Manufacture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManufactureController extends Controller implements ManufactureInterface
{
    /**
     * @var Manufacture
     */
    private $manufacture;
    /**
     * @var ManufactureService
     */
    private $manufactureService;

    /**
     * @param Manufacture $manufacture
     * @param ManufactureService $manufactureService
     */
    public function __construct(Manufacture $manufacture, ManufactureService $manufactureService)
    {
        $this->manufacture = $manufacture;
        $this->manufactureService = $manufactureService;
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('manufacture/index', [
            'manufactures' =>  Manufacture::all()->sortDesc(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('manufacture/create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        if ($this->manufactureService->validateManufactureMac($request)) {
            $this->manufactureService->createOneManufacture($request);

            return redirect()->route('manufactures');
        }
    }
}
