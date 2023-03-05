<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\UpdateWeatherJob;

class WeatherController extends Controller
{
    public function handleUpdateRequest(User $user): \Illuminate\Http\JsonResponse
    {
        dispatch(new UpdateWeatherJob($user));

        return response()->json([
            'message' => 'Processing weather update request',
        ]);
    }
}
