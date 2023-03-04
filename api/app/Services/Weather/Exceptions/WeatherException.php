<?php

namespace App\Services\Weather\Exceptions;

class WeatherException extends \Exception
{
    public static function invalidUnit(): static
    {
        return new static('Invalid unit');
    }
}
