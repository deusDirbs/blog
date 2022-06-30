<?php

namespace Tests\Unit;

use App\Models\Manufacture;
use App\Models\ManufactureAddress;
use App\Models\ManufactureMacAddress;
use Tests\TestCase;

class ManufactureTest extends TestCase
{
    /**
     * @return void
     */
    public function test_create_manufacture()
    {
        $manufacture = Manufacture::make([
            'title' => 'Manufacture title one'
        ]);

        $manufactureAddress = ManufactureAddress::make([
            'street' => 'No.2 Xin Cheng Road, Room R6,Songshan Lake Technology Park',
            'city' => 'Fremont  CA  94539',
            'country' => 'CN',
            'manufacture_id' => $manufacture->id
        ]);

        $manufactureMacAddress = ManufactureMacAddress::make([
            'mac' => '68-DB-F5',
            'address_format' => 'hex',
            'manufacture_id' => $manufacture->id
        ]);

        $this->assertTrue(true);
    }
}
