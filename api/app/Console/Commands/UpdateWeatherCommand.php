<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Jobs\UpdateWeatherJob;
use Illuminate\Console\Command;
use App\Services\Weather\Weather;
use Illuminate\Support\Facades\Log;
use App\Services\Weather\Providers\DarkSky;
use App\Services\Weather\Providers\OpenWeather;

class UpdateWeatherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command updates the weather.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Updating weather...');
        $totalUsers = User::count();
        for($i = 0; $i < $totalUsers; $i+=50) {
            $users = User::skip($i)->take(50)->get();
            foreach($users as $user){
                $lat = $user->latitude;
                $lon = $user->longitude;
                $providers = [ OpenWeather::class, DarkSky::class ];
                foreach($providers as $provider){
                    try {
                        $weather = new Weather(new $provider, $lat, $lon);
                        $weatherData = $weather->fetchWeather()->getWeather();
                        $user->weather()->update([
                            'temperature' => $weatherData['temperature'],
                            'feels_like' => $weatherData['feels_like'],
                            'temp_min' => $weatherData['temp_min'],
                            'temp_max' => $weatherData['temp_max'],
                            'pressure' => $weatherData['pressure'],
                            'humidity' => $weatherData['humidity'],
                        ]);
                    } catch (\Illuminate\Http\Client\ConnectionException $e) {
                        Log::info('ConnectionException: ' . $e->getMessage());
                        // try next provider
                    } catch (\Throwable $e){
                        dispatch(new UpdateWeatherJob($user));
                        $this->error($e->getMessage());
                    }
                    continue;
                }
            }
        }
        $this->info('Weather updated!');
    }
}
