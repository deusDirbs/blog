<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    public function test_upload_test()
    {
        $file = Storage::disk('public')->get('my_file.xml');

        $response = $this->post('/upload/upload-file', [
           'file' => $file
        ]);

        $this->assertTrue(true);
    }
}
