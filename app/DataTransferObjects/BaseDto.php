<?php

namespace App\DataTransferObjects;

use Illuminate\Http\Request;

interface BaseDto
{
    public static function fromRequest(Request $request);
}
