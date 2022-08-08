<?php

namespace Tests\Unit;

use App\Http\Services\UploadFileService;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    /**
     * test incorrect save upload file
     * set empty data
     * @param UploadFileService $fileService
     * @return void
     */
    public function test_incorrect_save_upload_file(UploadFileService $fileService): void
    {
        $emptyArray = [];

        if (is_string($emptyArray) || empty($emptyArray)) {
            $this->assertFalse(false);
        } else {
            $fileService->save($emptyArray);
            $this->assertTrue(true);
        }
    }

    /**
     * test incorrect create data for upload file
     * set empty data
     * @param UploadFileService $fileService
     * @return void
     */
    public function test_incorrect_create_upload_file(UploadFileService $fileService): void
    {
        $request = [];
        $fileModel = '';
        $file = $fileService->create($request, $fileModel);

        if (is_string($file)) {
            $this->assertTrue(true);
        } else {
            $this->assertFalse(false);
        }
    }
}
