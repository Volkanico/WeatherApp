<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $city = City::create([
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('weather.show', ['city' => $city->name])->with('success', 'City created successfully!');
    }


    public function destroy($id)
    {
        $city = City::find($id);

        if ($city) {
            $city->delete();
            return redirect()->route('weather.show')->with('success', 'City deleted successfully!');
        }

        return redirect()->route('weather.show')->with('error', 'City not found!');
    }
}
