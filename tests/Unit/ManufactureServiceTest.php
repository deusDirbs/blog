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
     * test save entity incorrect type
     * set $manufactureDto empty data
     * @return void
     */
    public function test_save_entity_incorrect_type(): void
    {
        $manufactureService = new ManufactureService();
        $manufactureDto = [];

        try {
            $manufactureService->saveEntry($manufactureDto);
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(true);
        }
    }

    /**
     * test save entity correct type
     * set model
     * @return void
     */
    public function test_save_entity_correct_type(): void
    {
        $manufactureService = new ManufactureService();

        try {
            $manufactureService->saveEntry($this->fakeManufacture(true));
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test save address relation incorrect type
     * set $fakeManufactureId string type
     * @return void
     */
    public function test_save_address_relation_incorrect_type(): void
    {
        $manufactureService = new ManufactureService();
        $fakeManufactureId = 'qweasdzxc';

        try {
            $manufactureService->saveAddressRelation($this->fakeManufacture(true, true), $fakeManufactureId);
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test save address relation correct type
     * set $fakeManufacture new model
     * @return void
     */
    public function test_save_address_relation_correct_type(): void
    {
        $manufactureService = new ManufactureService();
        $fakeManufacture = $manufactureService->saveEntry($this->fakeManufacture(true));

        try {
            $manufactureService->saveAddressRelation($this->fakeManufacture(false, false, true), $fakeManufacture->id);
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test save mac address incorrect type
     * $fakeManufactureId = string
     * @return void
     */
    public function test_save_mac_address_incorrect_type(): void
    {
        $manufactureService = new ManufactureService();
        $fakeManufactureId = 'zxcvbnghj';

        try {
            $manufactureService->saveAddressRelation($this->fakeManufacture(true, true, true), $fakeManufactureId);
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test save mac address incorrect type
     * $fakeManufacture new model
     * fakeManufacture -> get DTO Address
     * @return void
     */
    public function test_save_mac_address_correct_type(): void
    {
        $manufactureService = new ManufactureService();
        $fakeManufacture = $manufactureService->saveEntry($this->fakeManufacture(true));

        try {
            $manufactureService->saveMacAddressRelation($this->fakeManufacture(false, true), $fakeManufacture->id);
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test save all manufactures correct type
     * use fakeManufacture
     * create all models manufactures
     * @return void
     */
    public function test_save_all_manufactures_correct_type(): void
    {
        $manufactureService = new ManufactureService();
        try {
            $manufactureService->saveAll($this->fakeManufacture());
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test save manufactures incorrect type
     * use fakeManufacture
     * @return void
     */
    public function test_save_manufactures_incorrect_type(): void
    {
        $manufactureService = new ManufactureService();
        $string = '';

        try {
            $manufactureService->save($string);
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test validate manufacture mac incorrect string
     * $validateString empty array
     * @return void
     */
    public function test_validate_manufacture_mac_incorrect_string(): void
    {
        $manufactureService = new ManufactureService();
        $validateArray = [];

        try {
            $manufactureService->validateManufactureMac($validateArray);
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test validate manufacture mac correct string
     * $validateString correct mac
     * @return void
     */
    public function test_validate_manufacture_mac_correct_string(): void
    {
        $manufactureService = new ManufactureService();
        $validateString = '00-00-00';

        try {
            $validateMac = $manufactureService->validateManufactureMac($validateString);
            $this->assertTrue($validateMac);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }
}
