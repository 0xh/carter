<?php

namespace NickyWoolf\Thrust;

use Illuminate\Support\Str;

class NonceGenerator
{
    public function generate()
    {
        return Str::random(30);
    }
}