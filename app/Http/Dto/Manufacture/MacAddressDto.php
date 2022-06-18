<?php

namespace App\Http\Dto\Manufacture;

use App\Http\Dto\Interfaces\DtoInterface;

class MacAddressDto implements DtoInterface
{
    /**
     * @var string
     */
    public $mac;

    /**
     * @var string
     */
    public $addressFormat;

    /**
     * @param string $mac
     * @param string $addressFormat
     */
    public function __construct(string $mac, string $addressFormat)
    {
        $this->mac = $mac;
        $this->addressFormat = $addressFormat;

        return $this;
    }
}
