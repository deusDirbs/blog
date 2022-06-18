<?php

namespace App\Http\Dto\Manufacture;

use App\Http\Dto\DtoCollection;
use App\Http\Dto\Interfaces\DtoInterface;

class ManufactureDto implements DtoInterface
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var DtoCollection
     */
    public $macAddress;

    /**
     * @var AddressDto
     */
    public $address;

    /**
     * @param string $title
     * @param DtoCollection $macAddress
     * @param AddressDto $address
     */
    public function __construct(string $title, DtoCollection $macAddress, AddressDto $address)
    {
        $this->title = $title;
        $this->macAddress = $macAddress;
        $this->address = $address;

        return $this;
    }
}
