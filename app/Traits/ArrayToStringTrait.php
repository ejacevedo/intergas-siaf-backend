<?php

namespace App\Traits;

trait ArrayToStringTrait
{
    public function arrayToString(array $array): string
    {
        return implode('|', $array);
    }
}