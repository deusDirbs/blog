<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\FileUploadInterface;
use App\Http\Services\UploadFileService;
use Illuminate\Http\Request;

class FileUploadController extends Controller implements FileUploadInterface
{
    /**
     * @var UploadFileService
     */
    private $uploadFileService;

    /**
     * @param UploadFileService $uploadFileService
     */
    public function __construct
    (
        UploadFileService $uploadFileService
    )
    {
        $this->uploadFileService = $uploadFileService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function createForm()
    {
        return view('upload/file-upload');
    }

    /**
     * push $request (file) in the save
     *
     * checking validate on the form
     * @param Request $request
     * @return void
     */
    public function fileUpload(Request $request): void
    {
        $this->uploadFileService->validate($request);
        $this->uploadFileService->save($request);
    }
}
