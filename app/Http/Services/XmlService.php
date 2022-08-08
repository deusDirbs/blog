<?php

namespace App\Http\Services;

use App\Http\Dto\DtoCollection;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class XmlService
{
    /**
     * create structures for XML file
     *
     * @param DtoCollection $dtoCollection
     * @param User $user
     * @param Carbon $timeNow
     * @return bool
     */
    public function save(DtoCollection $dtoCollection, User $user, Carbon $timeNow): bool
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

        return Storage::disk('public')->put('id-' . $user->id . '-' . $timeNow . '-' . 'file.xml', $xml);
    }
}
