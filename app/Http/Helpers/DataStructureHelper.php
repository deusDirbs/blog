<?php

namespace App\Http\Helpers;

use App\Http\Dto\DtoCollection;
use App\Http\Dto\Manufacture\AddressDto;
use App\Http\Dto\Manufacture\MacAddressDto;
use App\Http\Dto\Manufacture\ManufactureDto;
use App\Http\Services\ManufactureService;
use App\Http\Services\ParsingService;

class DataStructureHelper
{
    public const EXCEPTION = ['Private'];

    /**
     * @param array $result
     * @param ParsingService $parsingService
     * @return DtoCollection
     */
    public static function createManufactureStructure(array $result, ParsingService $parsingService)
    {
        $data = new DtoCollection();
        foreach ($result as $item) {
            if (isset($item[1]) && in_array($item[1], self::EXCEPTION)) continue;
            $address = $parsingService->splitMacAddress($item[0] ?? '-');
            $array = new DtoCollection();
            $array->add(new MacAddressDto(
                    $address[0] ?? '-',
                    $address[1] ?? '-'
                )
            );
            $address = $parsingService->splitMacAddress($item[2] ?? '-');
            $array->add(new MacAddressDto(
                    $address[0] ?? '-',
                    $address[1] ?? '-'
                )
            );

            $data->add(new ManufactureDto($item[1] ?? '-', $array, new AddressDto($item[3] ?? '-', $item[4] ?? '-', $item[5] ?? '-')));
        }

        return $data;
    }
}
