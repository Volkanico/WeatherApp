<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        City::create([
            'name' => 'Palma de Mallorca',
            'latitude' => 39.5696,
            'longitude' => 2.6502,
        ]);

        City::create([
            'name' => 'Madrid',
            'latitude' => 40.4168,
            'longitude' => -3.7038,
        ]);

        City::create([
            'name' => 'Barcelona',
            'latitude' => 41.3784,
            'longitude' => 2.1925,
        ]);

        City::create([
            'name' => 'Sevilla',
            'latitude' => 37.3886,
            'longitude' => -5.9823,
        ]);
    }
}
