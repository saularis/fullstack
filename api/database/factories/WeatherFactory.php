<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weather>
 */
class WeatherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'temperature' => $this->faker->randomFloat(2, 0, 100),
            'feels_like' => $this->faker->randomFloat(2, 0, 100),
            'temp_min' => $this->faker->randomFloat(2, 0, 100),
            'temp_max' => $this->faker->randomFloat(2, 0, 100),
            'pressure' => $this->faker->randomFloat(2, 0, 100),
            'humidity' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
