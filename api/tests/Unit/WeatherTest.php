<?php

namespace Tests\Unit;

use App\Services\Weather\Weather;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_it_throws_exception_when_wrong_unit_is_passed(): void
    {
        $this->expectException(\App\Services\Weather\Exceptions\WeatherException::class);
        $this->expectExceptionMessage('Invalid unit');

        $weather = new Weather(new \App\Services\Weather\Providers\OpenWeather(), 0, 0);
        $weather->setUnit('wrong');
    }

    public function test_it_show_no_exception_when_correct_unit_is_passed(): void
    {
        $weather = new Weather(new \App\Services\Weather\Providers\OpenWeather(), 0, 0);
        $weather->setUnit('metric');
        $weather->setUnit('imperial');
        $this->assertTrue(true);
    }

    public function test_it_returns_weather_data(): void
    {
        config(['weather.providers.open_weather.api_key' => 'test_api_key']);

        $response = file_get_contents(base_path('tests/Unit/open_weather_map_mock_response.json'));

        Http::fake([
            'api.openweathermap.org/data/2.5/*' => Http::response($response, 200),
        ]);

        $openweather = new Weather(new \App\Services\Weather\Providers\OpenWeather(), 0, 0);
        $openweather->setUnit('metric');
        $openweather->fetchWeather();
        $this->assertIsArray($openweather->getWeather());

        config(['weather.providers.dark_sky.api_key' => 'test_api_key']);

        $response = file_get_contents(base_path('tests/Unit/dark_sky_mock_response.json'));

        Http::fake([
            'api.darksky.net/forecast/*' => Http::response($response, 200),
        ]);

        $darkSky = new Weather(new \App\Services\Weather\Providers\DarkSky, 0, 0);
        $darkSky->setUnit('metric');
        $darkSky->fetchWeather();
        $this->assertIsArray($darkSky->getWeather());
    }
}
