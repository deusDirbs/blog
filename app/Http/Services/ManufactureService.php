<?php

namespace App\Http\Services;

use App\Http\Dto\DtoCollection;
use App\Http\Dto\Manufacture\AddressDto;
use App\Http\Dto\Manufacture\MacAddressDto;
use App\Http\Dto\Manufacture\ManufactureDto;
use App\Models\Manufacture;
use App\Models\ManufactureAddress;
use App\Models\ManufactureMacAddress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManufactureService
{
    /**
     * @param DtoCollection $dtoCollection
     * @return bool
     */
    public function saveAll(DtoCollection $dtoCollection): bool
    {
        foreach ($dtoCollection->get() as $item) {
            $this->save($item);
            return true;
        }

       return false;
    }

    /**
     * @param ManufactureDto $manufactureDto
     * @return Manufacture
     */
    public function saveEntry(ManufactureDto $manufactureDto): Manufacture
    {
        return Manufacture::firstOrCreate(
            [
                'title' => $manufactureDto->title
            ],
        );
    }

    /**
     * @param AddressDto $dto
     * @param int $id
     * @return ManufactureAddress
     */
    public function saveAddressRelation(AddressDto $dto, int $id): ManufactureAddress
    {
        return ManufactureAddress::updateOrCreate(
            [
                'manufacture_id' => $id,
                'street' => $dto->street,
                'city' => $dto->city,
                'country' => $dto->country
            ]
        );
    }

    /**
     * @param MacAddressDto $dto
     * @param int $id
     * @return Manufacture
     */
    public function saveMacAddressRelation(MacAddressDto $dto, int $id): ManufactureMacAddress
    {
        return ManufactureMacAddress::updateOrCreate(
            [
                'manufacture_id' => $id,
                'mac' => $dto->mac,
                'address_format' => $dto->addressFormat,
            ]
        );
    }

    /**
     * @param ManufactureDto $manufactureDto
     * @return bool
     */
    public function save(ManufactureDto $manufactureDto): bool
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
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * @param $request
     * @return bool
     */
    public function createOneManufacture($request): bool
    {
        $dto = new ManufactureDto($request->title,
            (new DtoCollection())->add(
                new MacAddressDto($request->mac, $request->address_format)
            ),
            new AddressDto($request->street, $request->city, $request->country)
        );

        return $this->save($dto);
//        $model = $this->createOneManufactureTitle($request);
//        $this->createOneManufactureMacAddress($request, $model->id);
//        $this->createOneManufactureAddress($request, $model->id);
//
//        return $model;
    }

    /**
     * @param Request $request
     * @return Manufacture
     */
    public function createOneManufactureTitle(Request $request): Manufacture
    {
        return Manufacture::create(
            [
                'title' => $request->title,
            ]
        );
    }

    /**
     * @param Request $request
     * @param $id
     * @return ManufactureMacAddress
     */
    public function createOneManufactureMacAddress(Request $request, int $id): ManufactureMacAddress
    {
        return ManufactureMacAddress::updateOrCreate(
            [
                'manufacture_id' => $id,
                'mac' => $request->mac,
                'address_format' => $request->address_format,
            ]
        );
    }

    /**
     * @param Request $request
     * @param int $id
     * @return ManufactureAddress
     */
    public function createOneManufactureAddress(Request $request, int $id): ManufactureAddress
    {
       return ManufactureAddress::create(
            [
                'manufacture_id' => $id,
                'street' => $request->street,
                'city' => $request->city,
                'country' => $request->country,
            ]
        );
    }

    /**
     * @param $manufactureMac
     * @return bool
     */
    public function validateManufactureMac($manufactureMac): bool
    {
        $pattern = '/^(\d{2}-){2}\d{2}$|^\d{6}$/';

        if (!empty($manufactureMac->mac)) {
            $result = preg_match($pattern, $manufactureMac->mac);
            if ((integer)$result === 0) {
                Log::warning($manufactureMac->mac . ' - This MAC address is in the wrong format!');
                session()->flash('error', 'Errors were detected while recording MAC ADDRESSES');
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function validateCreateOrUpdateData(): bool
    {
        $newDateTime = Carbon::now()->addHour(3)->addMinutes(-5);
        $manufacture = DB::table('manufacture')->orderBy('id', 'DESC')->first();

        if ($newDateTime > $manufacture->created_at) {
            return true;
        } else {
            session()->flash('error', 'Wait 5 minutes');
            return false;
        }
    }
}
