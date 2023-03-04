<?php

namespace App\Services\Weather\Providers;

use Illuminate\Support\Facades\Http;
use App\Services\Weather\Interfaces\WeatherInterface;

class DarkSky implements WeatherInterface
{
    private static bool $timeout = true;

    public static function getWeather(float|int $lat, float|int $lon, string $unit = 'auto'): array|object
    {
        if($unit === 'metric') {
            $unit = 'si';
        } elseif($unit === 'imperial') {
            $unit = 'us';
        } else {
            $unit = 'auto';
        }

        if(self::$timeout){
            return Http::get('https://api.darksky.net/forecast/' . config('weather.providers.dark_sky.api_key') . "/{$lat},{$lon}?units={$unit}")
                ->timeout(0.5)
                ->throwIf(function ($response) {
                    return $response->failed();
                })
                ->json();
        }

        return Http::get('https://api.darksky.net/forecast/' . config('weather.providers.dark_sky.api_key') . "/{$lat},{$lon}?units={$unit}")
            ->throwIf(function ($response) {
                return $response->failed();
            })
            ->json();
    }

    public function format(array $weather): array
    {
        return [
            'temperature' => $weather['currently']['temperature'],
            'feels_like' => $weather['currently']['apparentTemperature'],
            'temp_min' => $weather['daily']['data'][0]['temperatureLow'],
            'temp_max' => $weather['daily']['data'][0]['temperatureHigh'],
            'pressure' => $weather['currently']['pressure'],
            'humidity' => $weather['currently']['humidity'],
        ];
    }

    public static function setTimeout(bool $timeout): static
    {
        self::$timeout = $timeout;
        return new static;
    }
}
