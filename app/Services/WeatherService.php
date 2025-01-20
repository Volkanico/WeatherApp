<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getCurrentWeather(float $latitude, float $longitude): array
    {
        $certPath = storage_path('certs/cacert.pem');

        $response = Http::withOptions([
            'verify' => $certPath,
        ])->get('https://api.open-meteo.com/v1/forecast', [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'current_weather' => true,
            'timezone' => 'Europe/Madrid'
        ]);

        if ($response->failed()) {
            throw new \Exception('Error al obtener los datos del clima.');
        }

        $weatherData = $response->json()['current_weather'];

        $weatherCodes = config('weatherCodes');

        $weatherDescription = $weatherCodes[$weatherData['weathercode']] ?? 'Unknown';

        return [
            'temperature' => $weatherData['temperature'],
            'weathercode' => $weatherData['weathercode'],
            'weather_description' => $weatherDescription,
            'windspeed' => $weatherData['windspeed'],
            'winddirection' => $weatherData['winddirection'],
            'is_day' => $weatherData['is_day'],
            'time' => $weatherData['time'],
        ];
    }
}
