<?php

namespace App\Http\Services;

use App\Http\Helpers\FIleDataManufactureStructureHelper;
use App\Models\File;
use Illuminate\Http\Request;


class UploadFileService
{
    /**
     * @var ManufactureService
     */
    private $manufactureService;

    /**
     * @param ManufactureService $manufactureService
     */
    public function __construct(ManufactureService $manufactureService)
    {
        $this->manufactureService = $manufactureService;
    }

    /**
     * @param Request $req
     * @return array
     */
    public function validate(Request $req): array
    {
        return $req->validate([
            'file' => 'required|file|mimes:xml|max:204800'
        ]);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function save(Request $request): void
    {
        $fileModel = new File;
        $uploadFile = $this->create($request, $fileModel);
        $uploadFile = str_replace('&', '-', $uploadFile);
        $xml = simplexml_load_string($uploadFile);

        $this->manufactureService->saveAll(FIleDataManufactureStructureHelper::createFileManufactureStructure($xml));
    }

    /**
     * @param Request $request
     * @param File $fileModel
     * @return string
     */
    public function create(Request $request, File $fileModel): string
    {
        if ($request->file()) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

            $fileModel->name = time() . '_' . $request->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
        }

        return file_get_contents($request->file('file'));
    }
}
