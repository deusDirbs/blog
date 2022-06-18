<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface ManufactureInterface
{
    public function index();

    public function create();

    public function save(Request $request);
}
