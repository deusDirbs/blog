<?php

namespace App\Http\Dto\Interfaces;

use App\Http\Dto\DtoCollection;

interface DtoCollectionInterface
{
    public function add(DtoInterface $dto): DtoCollection;

    public function get(): array;
}
