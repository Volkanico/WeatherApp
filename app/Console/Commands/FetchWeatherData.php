<?php

namespace App\Console\Commands;

use App\Models\Weather;
use App\Models\City;
use App\Services\WeatherService;
use Illuminate\Console\Command;

class FetchWeatherData extends Command
{
    protected $signature = 'weather:fetch {cityName}';
    protected $description = 'Fetch weather data from Open-Meteo API and store it in the database';

    protected WeatherService $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        parent::__construct();
        $this->weatherService = $weatherService;
    }

    public function handle()
    {
        try {
            $cityName = $this->argument('cityName');

            $city = City::where('name', $cityName)->first();

            if (!$city) {
                $this->error('City not found');
                return;
            }

            $latitude = $city->latitude;
            $longitude = $city->longitude;

            $weather = $this->weatherService->getCurrentWeather($latitude, $longitude);

            Weather::create([
                'temperature' => $weather['temperature'],
                'weathercode' => $weather['weathercode'],
                'weather_description' => $weather['weather_description'],
                'windspeed' => $weather['windspeed'],
                'winddirection' => $weather['winddirection'],
                'is_day' => $weather['is_day'],
                'time' => $weather['time'],
                'city_id' => $city->id,
            ]);

            $this->info('Weather data updated successfully for ' . $cityName);
        } catch (\Exception $e) {
            $this->error('Error fetching weather data: ' . $e->getMessage());
        }
    }
}
