<?php

namespace App\Http\Services;

use App\Http\Dto\DtoCollection;
use Illuminate\Support\Facades\Storage;

class XmlService
{
    /**
     * @param DtoCollection $dtoCollection
     * @return void
     */
    public function save(DtoCollection $dtoCollection): void
    {
        $xml = '';
        $xml .= '<manufactures>' . PHP_EOL;
        foreach ($dtoCollection->get() as $item) {
            $xml .= '<manufacture>' . PHP_EOL;
            $xml .= '<manufacture_title>' . $item->title . '</manufacture_title>' . PHP_EOL;
            $xml .= '<manufacture_street>' . $item->address->street . '</manufacture_street>' . PHP_EOL;
            $xml .= '<manufacture_city>' . $item->address->city . '</manufacture_city>' . PHP_EOL;
            $xml .= '<manufacture_country>' . $item->address->country . '</manufacture_country>' . PHP_EOL;
            $xml .= '<macs>' . PHP_EOL;
            foreach ($item->macAddress->get() as $macAddress) {
                $xml .= '<mac>' . PHP_EOL;
                $xml .= '<mac_address>' . $macAddress->mac . '</mac_address>' . PHP_EOL;
                $xml .= '<mac_format>' . $macAddress->addressFormat . '</mac_format>' . PHP_EOL;
                $xml .= '</mac>' . PHP_EOL;
            }
            $xml .= '</macs>' . PHP_EOL;
            $xml .= '</manufacture>' . PHP_EOL;
        }
        $xml .= '<manufactures>' . PHP_EOL;

        Storage::disk('public')->put('my_file.xml', $xml);
    }
}
