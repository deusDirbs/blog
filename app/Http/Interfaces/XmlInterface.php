<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface XmlInterface
{
    public function create(Request $request);
}
