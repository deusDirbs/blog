<?php

namespace Tests\Unit;

use Tests\TestCase;

class UploadFileTest extends TestCase
{
    /**
     * check url GET: upload/upload-file
     * @return void
     */
    public function test_open_upload_page(): void
    {
        $response = $this->get('upload/upload-file');

        $response->assertStatus(200);
    }

    /**
     * check url POST: upload/upload-file
     * @return void
     */
    public function test_download_data_with_files(): void
    {
        $response = $this->post('upload/upload-file', [
            'http' => 'https://standards-oui.ieee.org/'
        ]);

        $response->assertOk();
    }
}
