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
     * check url POST: upload/upload-file incorrect
     * push string http
     * upload url waiting file
     * @return void
     */
    public function test_download_data_with_files(): void
    {
        try {
            $response = $this->post('upload/upload-file', [
                'http' => 'https://standards-oui.ieee.org/'
            ]);

            $response->assertStatus(302);
        } catch (\Exception$exception) {
            $response->assertStatus(500);
        }
    }
}
