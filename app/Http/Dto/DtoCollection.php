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
     * @return void
     */
    public function add(DtoInterface $dto): void
    {
        $this->item[] = $dto;
    }
}
