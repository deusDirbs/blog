<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface FileUploadInterface
{
    public function createForm();

    public function fileUpload(Request $request);
}
