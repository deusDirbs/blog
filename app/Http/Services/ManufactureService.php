<?php

namespace App\Http\Services;

use App\Http\Dto\DtoCollection;
use App\Http\Dto\Manufacture\AddressDto;
use App\Http\Dto\Manufacture\MacAddressDto;
use App\Http\Dto\Manufacture\ManufactureDto;
use App\Models\Manufacture;
use App\Models\ManufactureAddress;
use App\Models\ManufactureMacAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManufactureService
{
    /**
     * @param DtoCollection $dtoCollection
     * @return void
     */
    public function saveAll(DtoCollection $dtoCollection): void
    {
        foreach ($dtoCollection->get() as $item) {
            $this->save($item);
        }
    }

    /**
     * @param ManufactureDto $manufactureDto
     * @return mixed
     */
    public function saveEntry(ManufactureDto $manufactureDto)
    {
        $model = Manufacture::firstOrCreate(
            ['title' => $manufactureDto->title],
        );

        return $model;
    }

    /**
     * @param AddressDto $dto
     * @param int $id
     * @return mixed
     */
    public function saveAddressRelation(AddressDto $dto, int $id)
    {
        $model = ManufactureAddress::updateOrCreate(
            ['manufacture_id' => $id,
                'street' => $dto->street,
                'city' => $dto->city,
                'country' => $dto->country
            ]
        );

        return $model;
    }

    /**
     * @param MacAddressDto $dto
     * @param int $id
     * @return mixed
     */
    public function saveMacAddressRelation(MacAddressDto $dto, int $id)
    {
        $model = ManufactureMacAddress::updateOrCreate(
            ['manufacture_id' => $id,
                'mac' => $dto->mac,
                'address_format' => $dto->addressFormat,
            ]
        );

        return $model;
    }

    /**
     * @param ManufactureDto $manufactureDto
     * @return mixed|null
     */
    public function save(ManufactureDto $manufactureDto)
    {
        DB::beginTransaction();
        try {
            $model = $this->saveEntry($manufactureDto);

            $this->saveAddressRelation($manufactureDto->address, $model->id);
            foreach ($manufactureDto->macAddress->get() as $macAddress) {
                $this->validateManufactureMac($macAddress->mac);
                $this->saveMacAddressRelation($macAddress, $model->id);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $model;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function createOneManufacture($request)
    {
        $model = $this->createOneManufactureTitle($request);
        $this->createOneManufactureMacAddress($request, $model->id);
        $this->createOneManufactureAddress($request, $model->id);

        return $model;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function createOneManufactureTitle(Request $request)
    {
        $model = Manufacture::create([
            'title' => $request->title,
        ]);

        return $model;
    }

    /**
     * @param Request $request
     * @param $id
     * @return void
     */
    public function createOneManufactureMacAddress(Request $request, $id): void
    {
        ManufactureMacAddress::create([
            'manufacture_id' => $id,
            'mac' => $request->mac,
            'address_format' => $request->address_format,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return void
     */
    public function createOneManufactureAddress(Request $request, $id): void
    {
            ManufactureAddress::create([
                'manufacture_id' => $id,
                'street' => $request->street,
                'city' => $request->city,
                'country' => $request->country,
            ]);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function validateManufactureMac(Request $request)
    {
        $pattern = '/^(\d{2}-){2}\d{2}$|^\d{6}$/';

        if (!empty($request->mac)) {
            $result = preg_match($pattern, $request->mac);
            if ((integer)$result === 0) {
                Log::warning($request->mac . ' - This MAC address is in the wrong format!');
                session()->flash('error', 'Errors were detected while recording MAC ADDRESSES');
            }
        }

        return true;
    }
}
