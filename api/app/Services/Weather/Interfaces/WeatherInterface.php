<?php

namespace App\Services\Weather\Interfaces;

interface WeatherInterface
{
    public static function getWeather(float|int $lat, float|int $lon, string $unit): array|object;

    public function format(array $weather): array;

    public static function setTimeout(bool $timeout): static;
}
