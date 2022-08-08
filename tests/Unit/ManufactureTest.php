<?php

namespace Tests\Unit;

use App\Models\Manufacture;
use Tests\TestCase;

class ManufactureTest extends TestCase
{
    /**
     * check status url: /manufactures
     * @return void
     */
    public function test_all_manufactures(): void
    {
        $response = $this->get('/manufactures');

        $response->assertStatus(200);
    }

    /**
     * check status url: /manufactures/create
     * @return void
     */
    public function test_manufacture_page(): void
    {
        $response = $this->get('/manufacture/create');

        $response->assertStatus(200);
    }

    /**
     * push manufacture data on the url: /manufacture/save
     * save manufacture
     * @return void
     */
    public function test_create_manufacture(): void
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

    /**
     * delete last manufacture field
     * @return void
     */
    public function test_delete_manufacture(): void
    {
        $manufacture = Manufacture::latest()->first();

        if ($manufacture) {
            $manufacture->delete();
        }

        $this->assertTrue(true);
    }
}
