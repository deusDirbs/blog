<?php

namespace App\Http\Dto\Interfaces;

interface DtoCollectionInterface
{
    public function add(DtoInterface $dto): void;

    public function get(): array;
}
