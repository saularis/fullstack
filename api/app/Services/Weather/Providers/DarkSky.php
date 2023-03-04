<?php

namespace App\Services\Weather\Providers;

use Illuminate\Support\Facades\Http;
use App\Services\Weather\Interfaces\WeatherInterface;

class DarkSky implements WeatherInterface
{
    public static function getWeather(float|int $lat, float|int $lon, string $unit = 'auto'): array|object
    {
        if($unit === 'metric') {
            $unit = 'si';
        } elseif($unit === 'imperial') {
            $unit = 'us';
        } else {
            $unit = 'auto';
        }

        return Http::get('https://api.darksky.net/forecast/' . config('weather.providers.dark_sky.api_key') . "/{$lat},{$lon}?units={$unit}")
            ->throwIf(function ($response) {
                return $response->failed();
            })
            ->json();
    }
}
