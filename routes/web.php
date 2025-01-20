<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WeatherController::class, 'show'])->name('weather.show');

Route::get('/weather/store', [WeatherController::class, 'store']);
Route::post('/city/create', [CityController::class, 'store'])->name('city.create');
Route::delete('/city/{id}', [CityController::class, 'destroy'])->name('city.delete');
