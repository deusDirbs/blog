<?php

namespace App\Http\Helpers;

use App\Http\Dto\DtoCollection;
use App\Http\Dto\Manufacture\AddressDto;
use App\Http\Dto\Manufacture\MacAddressDto;
use App\Http\Dto\Manufacture\ManufactureDto;

class FIleDataManufactureStructureHelper
{
    /**
     * create structure manufactures
     *
     * set structure data in $data
     * @param $xml
     * @return DtoCollection
     */
    public static function createFileManufactureStructure($xml)
    {
        $data = new DtoCollection();
        foreach ($xml->manufacture as $manufacture) {
            $macAddressArray = new DtoCollection();
            $macAddressArray->add(
                new MacAddressDto($manufacture[0]->macs->mac->mac_address ?? '-', $manufacture[0]->macs->mac->mac_format ?? '-'));

            $data->add(
                new ManufactureDto($manufacture[0]->manufacture_title ?? '-', $macAddressArray,
                    new AddressDto($manufacture[0]->manufacture_street ?? '-', $manufacture[0]->manufacture_city ?? '-', $manufacture[0]->manufacture_country ?? '-')));

        }

        return $data;
    }
}
