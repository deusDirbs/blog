<?php

namespace App\Http\Services;

use App\Http\Helpers\FIleDataManufactureStructureHelper;
use App\Models\File;
use Illuminate\Http\Request;


class UploadFileService
{
    /**
     * validate on the form
     *
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
     * push data with file in the xml format and push in saveAll for save
     *
     * $uploadFile- > process the file
     * @param Request $request
     * @param ManufactureService $manufactureService
     * @return void
     */
    public function save(Request $request, ManufactureService $manufactureService): void
    {
        $fileModel = new File;
        $uploadFile = $this->create($request, $fileModel);
        $uploadFile = str_replace('&', '-', $uploadFile);
        $xml = simplexml_load_string($uploadFile);

        $manufactureService->saveAll(FIleDataManufactureStructureHelper::createFileManufactureStructure($xml));
    }

    /**
     * $fileName -> create file name and save in path
     *
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
