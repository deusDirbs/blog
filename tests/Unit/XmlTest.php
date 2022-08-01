<?php

namespace Tests\Unit;

use Tests\TestCase;

class XmlTest extends TestCase
{
    public function test_open_page_xml()
    {
        $response = $this->get('xml/create');

        $response->assertStatus(200);
    }

    public function test_created_xml_file()
    {
        $response = $this->post('upload/xml', [
            'http' => 'https://standards-oui.ieee.org/'
        ]);

        $response->assertOk();
    }
}
