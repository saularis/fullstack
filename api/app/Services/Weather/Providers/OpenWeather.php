<?php

namespace App\Services\Weather\Providers;

use Illuminate\Support\Facades\Http;
use App\Services\Weather\Interfaces\WeatherInterface;

class OpenWeather implements WeatherInterface
{
    public static function getWeather(float|int $lat, float|int $lon, string $unit = 'imperial'): array|object
    {
        return Http::get('https://api.openweathermap.org/data/2.5/weather?lat=' . $lat . '&lon=' . $lon . '&units=' . $unit . '&appid=' . config('weather.providers.open_weather.api_key'))
            ->throwIf(function ($response) {
                return $response->failed();
            })
            ->json();
    }
}
