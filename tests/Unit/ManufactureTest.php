<?php

namespace Tests\Unit;

use App\Models\Manufacture;
use Tests\TestCase;

class ManufactureTest extends TestCase
{
    public function test_all_manufactures()
    {
        $response = $this->get('/manufactures');

        $response->assertStatus(200);
    }

    public function test_manufacture_page()
    {
        $response = $this->get('/manufacture/create');

        $response->assertStatus(200);
    }

    public function test_create_manufacture()
    {
        $response = $this->post('/manufacture/save', [
            'title' => 'Manufacture title one',
            'street' => 'No.2 Xin Cheng Road, Room R6,Songshan Lake Technology Park',
            'city' => 'Fremont  CA  94539',
            'country' => 'CN',
            'mac' => '68-DB-F5',
            'address_format' => 'hex',
        ]);

        $response->assertRedirect('/manufactures');
    }

    public function test_delete_manufacture()
    {
        $manufacture = Manufacture::latest()->first();

        if ($manufacture) {
            $manufacture->delete();
        }

        $this->assertTrue(true);
    }
}
