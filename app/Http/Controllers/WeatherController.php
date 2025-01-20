<?php
namespace App\Http\Controllers;

use App\Models\Weather;
use App\Models\City;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected WeatherService $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function show(Request $request)
    {

        $cityName = $request->input('city', 'Palma de Mallorca');
        $city = City::where('name', $cityName)->first();

        if (!$city) {
            return redirect()->route('weather.show', ['city' => 'Palma de Mallorca'])->with('error', 'City not found!');
        }

        $weatherData = Weather::where('city_id', $city->id)
                              ->orderBy('created_at', 'asc')
                              ->get();

        $weatherDataGrouped = $weatherData->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('H');
        });

        $hourlyData = $weatherDataGrouped->map(function ($hourGroup) {
            return [
                'hour' => $hourGroup->first()->created_at->format('H:i'),
                'temperature' => $hourGroup->avg('temperature')
            ];
        });

        $weatherDataDetailed = Weather::where('city_id', $city->id)
                                      ->orderBy('created_at', 'desc')
                                      ->take(4)
                                      ->get();

        $cities = City::all();

        return view('index', compact('weatherData', 'hourlyData', 'weatherDataDetailed', 'cities', 'city'));
    }
}
