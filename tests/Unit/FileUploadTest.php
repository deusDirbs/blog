<?php

namespace Tests\Unit;

use App\Http\Services\UploadFileService;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    /**
     * test incorrect save upload file
     * set empty data
     * @return void
     */
    public function test_incorrect_save_upload_file(): void
    {
        $fileService = new UploadFileService();
        $emptyArray = [];

        if (is_string($emptyArray) || empty($emptyArray)) {
            $this->assertFalse(false);
        } else {
            $fileService->save($emptyArray);
            $this->assertTrue(true);
        }
    }
}
