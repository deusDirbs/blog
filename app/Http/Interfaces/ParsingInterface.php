<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface ParsingInterface
{
    public function create(Request $request);
}
