<?php

namespace Tests\Unit;


use App\Http\Dto\DtoCollection;
use App\Http\Dto\Manufacture\AddressDto;
use App\Http\Dto\Manufacture\MacAddressDto;
use App\Http\Dto\Manufacture\ManufactureDto;
use App\Http\Services\ManufactureService;
use Carbon\Exceptions\UnitException;
use Tests\TestCase;

class ManufactureServiceTest extends TestCase
{
    /**
     * @param bool $isTitle
     * @param bool $isMacAddress
     * @param bool $isAddress
     * @return DtoCollection|ManufactureDto
     */
    public function fakeManufacture($isTitle = false, $isMacAddress = false, $isAddress = false): mixed
    {
        $data = new DtoCollection();
        $macAddressCollection = (new DtoCollection())->add(new MacAddressDto('fakeMacAddress', 'base64'))->add(new MacAddressDto('fakeMacAddress2', 'hex'));
        $data->add(new ManufactureDto('fakeTitle', $macAddressCollection, new AddressDto('fakeStreet', 'fakeCity', 'fakeCountry')));

        if ($isTitle) {
            return $data->get()[0];
        }

        if ($isMacAddress) {
            return $data->get()[1];
        }

        if ($isAddress) {
            return $data->get()[2];
        }

        return $data;
    }

    /**
     * test save entity incorrect type
     * set $manufactureDto empty data
     * @param ManufactureService $manufactureService
     * @return void
     */
    public function test_save_entity_incorrect_type(ManufactureService $manufactureService): void
    {
        $manufactureDto = [];

        try {
            $manufacture = $manufactureService->saveEntry($manufactureDto);
            $this->assertTrue($manufacture);
        } catch (UnitException $exception) {
            $this->assertFalse(true);
        }
    }

    /**
     * test save entity correct type
     * set model
     * @param ManufactureService $manufactureService
     * @return void
     */
    public function test_save_entity_correct_type(ManufactureService $manufactureService): void
    {
        try {
            $manufacture = $manufactureService->saveEntry($this->fakeManufacture(true));
            $this->assertTrue($manufacture);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test save address relation incorrect type
     * set $fakeManufactureId string type
     * @param ManufactureService $manufactureService
     * @return void
     */
    public function test_save_address_relation_incorrect_type(ManufactureService $manufactureService): void
    {
        $fakeManufactureId = 'qweasdzxc';

        try {
            $manufacture = $manufactureService->saveAddressRelation($this->fakeManufacture(true, true), $fakeManufactureId);
            $this->assertTrue($manufacture);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test save address relation correct type
     * set $fakeManufactureId int number 1
     * @param ManufactureService $manufactureService
     * @return void
     */
    public function test_save_address_relation_correct_type(ManufactureService $manufactureService): void
    {
        $fakeManufactureId = 1;

        try {
            $manufacture = $manufactureService->saveAddressRelation($this->fakeManufacture(false, true), $fakeManufactureId);
            $this->assertTrue($manufacture);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test save mac address incorrect type
     * $fakeManufactureId = string
     * @param ManufactureService $manufactureService
     * @return void
     */
    public function test_save_mac_address_incorrect_type(ManufactureService $manufactureService): void
    {
        $fakeManufactureId = 'zxcvbnghj';

        try {
            $manufacture = $manufactureService->saveAddressRelation($this->fakeManufacture(true, true, true), $fakeManufactureId);
            $this->assertTrue($manufacture);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test save mac address incorrect type
     * $fakeManufactureId = int
     * fakeManufacture -> get DTO Address
     * @param ManufactureService $manufactureService
     * @return void
     */
    public function test_save_mac_address_correct_type(ManufactureService $manufactureService): void
    {
        $fakeManufactureId = 1;

        try {
            $manufacture = $manufactureService->saveAddressRelation($this->fakeManufacture(false, false, true), $fakeManufactureId);
            $this->assertTrue($manufacture);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test save all manufactures incorrect type
     * use fakeManufacture
     * @param ManufactureService $manufactureService
     * @return void
     */
    public function test_save_all_manufactures_correct_type(ManufactureService $manufactureService): void
    {
        try {
            $manufacture = $manufactureService->saveAll($this->fakeManufacture());
            $this->assertTrue($manufacture);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test save manufactures incorrect type
     * use fakeManufacture
     * @param ManufactureService $manufactureService
     * @return void
     */
    public function test_save_manufactures_correct_type(ManufactureService $manufactureService): void
    {
        try {
            $manufacture = $manufactureService->save($this->fakeManufacture());
            $this->assertTrue($manufacture);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test validate manufacture mac incorrect string
     * $validateString empty string
     * @param ManufactureService $manufactureService
     * @return void
     */
    public function test_validate_manufacture_mac_incorrect_string(ManufactureService $manufactureService): void
    {
        $validateString = '';

        try {
            $validateMac = $manufactureService->validateManufactureMac($validateString);
            $this->assertTrue($validateMac);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test validate manufacture mac correct string
     * $validateString correct mac
     * @param ManufactureService $manufactureService
     * @return void
     */
    public function test_validate_manufacture_mac_correct_string(ManufactureService $manufactureService): void
    {
        $validateString = '00-00-00';

        try {
            $validateMac = $manufactureService->validateManufactureMac($validateString);
            $this->assertTrue($validateMac);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }
}
