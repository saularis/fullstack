<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {

    $users = cache()->remember('users', 60, function () {
        return \App\Models\User::with('weather')->get();
    });

    return response()->json([
        'message' => 'all systems are a go',
        'users' => $users,
    ]);
});

Route::get('/users/{user}/weather', [WeatherController::class, 'handleUpdateRequest'])
    ->name('weather.update')
    ->middleware('throttle:1,1');
