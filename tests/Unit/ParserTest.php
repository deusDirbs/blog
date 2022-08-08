<?php

namespace Tests\Unit;

use Tests\TestCase;

class ParserTest extends TestCase
{
    /**
     * check status url: parser/view
     * @return void
     */
    public function test_open_parser_page(): void
    {
        $response = $this->get('parser/view');

        $response->assertStatus(200);
    }

    /**
     * push string url in create manufacture
     * @return void
     */
    public function test_create_manufactures(): void
    {
        $response = $this->post('parser/create', [
            'http' => 'https://standards-oui.ieee.org/'
        ]);

        $response->assertOk();
    }
}
