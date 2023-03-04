<?php

namespace App\Services\Weather;

use App\Services\Weather\Exceptions\WeatherException;
use App\Services\Weather\Interfaces\WeatherInterface;

class Weather
{
    private string $unit;

    private array|object $weather;

    public function __construct(
        private WeatherInterface $provider,
        public float|int $lat,
        public float|int $lon
    ){}

    public function setUnit(string $unit): static
    {
        if (!in_array($unit, ['metric', 'imperial'])) {
            throw WeatherException::invalidUnit();
        }

        $this->unit = $unit;
        return $this;
    }

    public function fetchWeather(): static
    {
        $this->weather = $this->provider::getWeather($this->lat, $this->lon, $this->unit);
        return $this;
    }

    public function getWeather(): array|object
    {
        return $this->weather;
    }
}
