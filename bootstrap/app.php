<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        // Obtener todas las ciudades desde la base de datos
        $cities = \App\Models\City::all();

        foreach ($cities as $city) {
            // Programa el comando weather:fetch para cada ciudad, ejecutándose cada minuto
            $schedule->command('weather:fetch', [$city->name])
                     ->everyMinute(); // Puedes ajustar la frecuencia según lo necesites
        }
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
