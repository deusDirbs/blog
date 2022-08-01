<?php

namespace App\Http\Dto;

use App\Http\Dto\Interfaces\DtoCollectionInterface;
use App\Http\Dto\Interfaces\DtoInterface;

class DtoCollection implements DtoCollectionInterface
{
    /**
     * @var array
     */
    public $item = [];

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->item;
    }

    /**
     * @param DtoInterface $dto
     * @return DtoCollection
     */
    public function add(DtoInterface $dto): DtoCollection
    {
        $this->item[] = $dto;

        return $this;
    }
}
