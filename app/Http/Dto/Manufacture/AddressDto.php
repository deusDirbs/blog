<?php

namespace App\Http\Dto\Manufacture;

class AddressDto
{
    /**
     * @var string $street
     */
    public $street;
    /**
     * @var string $city
     */
    public $city;

    /**
     * @var string $country
     */
    public $country;

    /**
     * @param string $street
     * @param string $city
     * @param string $country
     */
    public function __construct(string $street, string $city, string $country)
    {
        $this->street = $street;
        $this->city = $city;
        $this->country = $country;

        return $this;
    }
}
