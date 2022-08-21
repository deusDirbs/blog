<?php

namespace Tests\Unit;

use App\Http\Dto\DtoCollection;
use App\Http\Dto\Manufacture\AddressDto;
use App\Http\Dto\Manufacture\MacAddressDto;
use App\Http\Dto\Manufacture\ManufactureDto;
use App\Http\Services\XmlService;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Exceptions\UnitException;
use Tests\TestCase;

class XmlServiceTest extends TestCase
{
    /**
     * data fakeManufacture
     * @return DtoCollection|ManufactureDto
     */
    public function fakeManufacture($isTitle = false, $isMacAddress = false, $isAddress = false)
    {
        $dto = new DtoCollection();
        $dto->add(new ManufactureDto('fakeTitle',
            (new DtoCollection())->add(
                new MacAddressDto('00-AA-00', 'hex')
            ),
            new AddressDto('fakeStreet', 'fakeCity', 'UA')
        ));

        if ($isTitle) {
            return $dto->get()[0];
        }

        if ($isMacAddress) {
            return  (new MacAddressDto('00-AA-00', 'hex'));

        }

        if ($isAddress) {
            return (new AddressDto('fakeStreet', 'fakeCity', 'UA'));
        }

        return $dto;
    }

    /**
     * test correct save xml structures
     * set fakeManufacture
     * set $user auth
     * set $timeNow date now
     * @return void
     */
    public function test_create_new_xml_service(): void
    {
        $user = new User();
        $xmlService = new XmlService();
        $timeNow = Carbon::now();
        $user->getAttribute('id') ;

        if($xmlService->save($this->fakeManufacture(), $user, $timeNow)){
            $this->assertTrue(true);
        } else {
            $this->assertFalse(false);
        }
    }

    /**
     * test incorrect save xml structures
     * set empty data
     * @return void
     */
    public function test_create_new_incorrect_xml_service(): void
    {
        $xmlService = new XmlService();
        $timeNow = Carbon::now();
        $user = new User();
        $user->getAttribute('id') ;
        $array = [];

        try {
            $xmlService->save($array, $user, $timeNow);
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }
}
