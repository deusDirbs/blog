<?php

namespace Tests\Unit;

use Tests\TestCase;

class ParserTest extends TestCase
{
    public function test_open_parser_page()
    {
        $response = $this->get('parser/view');

        $response->assertStatus(200);
    }

    public function test_create_manufactures()
    {
        $response = $this->post('parser/create', [
            'http' => 'https://standards-oui.ieee.org/'
        ]);

        $response->assertOk();
    }
}
