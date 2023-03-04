<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Services\Weather\Weather;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Weather\Providers\DarkSky;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Services\Weather\Providers\OpenWeather;

class UpdateWeatherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private User $user){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $lat = $this->user->latitude;
        $lon = $this->user->longitude;
        $providers = [ OpenWeather::class, DarkSky::class ];
        foreach($providers as $provider){
            try {
                $providerWithoutTimeout = $provider::setTimeout(false);
                $weather = new Weather(new $providerWithoutTimeout, $lat, $lon);
                $weatherData = $weather->fetchWeather()->getWeather();
                $this->user->weather()->update([
                    'temperature' => $weatherData['temperature'],
                    'feels_like' => $weatherData['feels_like'],
                    'temp_min' => $weatherData['temp_min'],
                    'temp_max' => $weatherData['temp_max'],
                    'pressure' => $weatherData['pressure'],
                    'humidity' => $weatherData['humidity'],
                ]);
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                // try next provider
            } catch (\Throwable $e) {
                Log::error($e->getMessage());
            }
            continue;
        }
    }
}
