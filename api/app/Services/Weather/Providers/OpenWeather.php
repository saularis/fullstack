<?php

namespace App\Services\Weather\Providers;

use Illuminate\Support\Facades\Http;
use App\Services\Weather\Interfaces\WeatherInterface;

class OpenWeather implements WeatherInterface
{
    private static bool $timeout = true;

    public static function getWeather(float|int $lat, float|int $lon, string $unit = 'imperial'): array|object
    {
        if(self::$timeout){
            return Http::get('https://api.openweathermap.org/data/2.5/weather?lat=' . $lat . '&lon=' . $lon . '&units=' . $unit . '&appid=' . config('weather.providers.open_weather.api_key'))
                ->timeout(0.5)
                ->throwIf(function ($response) {
                    return $response->failed();
                })
                ->json();
        }

        return Http::get('https://api.openweathermap.org/data/2.5/weather?lat=' . $lat . '&lon=' . $lon . '&units=' . $unit . '&appid=' . config('weather.providers.open_weather.api_key'))
            ->throwIf(function ($response) {
                return $response->failed();
            })
            ->json();
    }

    public function format(array $weather): array
    {
        return [
            'temperature' => $weather['main']['temp'],
            'feels_like' => $weather['main']['feels_like'],
            'temp_min' => $weather['main']['temp_min'],
            'temp_max' => $weather['main']['temp_max'],
            'pressure' => $weather['main']['pressure'],
            'humidity' => $weather['main']['humidity'],
        ];
    }

    public static function setTimeout(bool $timeout): static
    {
        self::$timeout = $timeout;
        return new static;
    }
}
