<?php

namespace Tests\Unit;

use App\Http\Dto\DtoCollection;
use App\Http\Dto\Manufacture\AddressDto;
use App\Http\Dto\Manufacture\MacAddressDto;
use App\Http\Dto\Manufacture\ManufactureDto;
use App\Http\Services\XmlService;
use Carbon\Carbon;
use Carbon\Exceptions\UnitException;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class XmlServiceTest extends TestCase
{
    /**
     * data fakeManufacture
     * @return DtoCollection|ManufactureDto
     */
    public function fakeManufacture(): mixed
    {
        $data = new DtoCollection();
        $macAddressCollection = (new DtoCollection())->add(new MacAddressDto('fakeMacAddress', 'base64'))->add(new MacAddressDto('fakeMacAddress2', 'hex'));
        $data->add(new ManufactureDto('fakeTitle', $macAddressCollection, new AddressDto('fakeStreet', 'fakeCity', 'fakeCountry')));

        return $data;
    }

    /**
     * test correct save xml structures
     * set fakeManufacture
     * set $user auth
     * set $timeNow date now
     * @param XmlService $xmlService
     * @return void
     */
    public function test_create_new_xml_service(XmlService $xmlService): void
    {
        $timeNow = Carbon::now();
        $user = Auth::user();

        if($xmlService->save($this->fakeManufacture(), $user, $timeNow)){
            $this->assertTrue(true);
        } else {
            $this->assertFalse(false);
        }
    }

    /**
     * test incorrect save xml structures
     * set empty data
     * @param XmlService $xmlService
     * @return void
     */
    public function test_create_new_incorrect_xml_service(XmlService $xmlService): void
    {
        $timeNow = Carbon::now();
        $user = Auth::user();
        $array = [];

        try {
            $xmlService->save($array, $user, $timeNow);
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }
}
