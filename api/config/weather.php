<?php

return [
    'providers' => [
        'open_weather' => [
            'class' => \App\Services\Weather\Providers\OpenWeather::class,
            'api_key' => env('OPEN_WEATHER_API_KEY'),
        ],
        'dark_sky' => [
            'class' => \App\Services\Weather\Providers\DarkSky::class,
            'api_key' => env('DARK_SKY_API_KEY'),
        ],
    ],
];
