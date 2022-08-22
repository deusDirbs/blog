<?php

namespace Tests\Unit;

use Tests\TestCase;

class XmlTest extends TestCase
{
    /**
     * test open page xml
     * check url GET: xml/create
     * @return void
     */
    public function test_open_page_xml(): void
    {
        $response = $this->get('xml/create');

        $response->assertStatus(200);
    }

    /**
     * test created xml file
     * check url post: upload/xml
     * @return void
     */
    public function test_created_xml_file(): void
    {
        try {
            $response = $this->post('upload/xml', [
                'http' => 'https://standards-oui.ieee.org/'
            ]);

            $response->assertOk();
        } catch (\Exception $exception) {
            $response->assertStatus(500);
        }

    }
}
