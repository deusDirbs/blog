<?php

namespace Tests\Unit;

use Tests\TestCase;

class UploadFileTest extends TestCase
{
    public function test_open_upload_page()
    {
        $response = $this->get('upload/upload-file');

        $response->assertStatus(200);
    }

    public function test_download_data_with_files()
    {
        $response = $this->post('upload/upload-file', [
            'http' => 'https://standards-oui.ieee.org/'
        ]);

        $response->assertOk();
    }
}
