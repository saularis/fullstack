<?php

namespace App\Services\Weather\Interfaces;

interface WeatherInterface
{
    public static function getWeather(float|int $lat, float|int $lon, string $unit): array|object;
}
