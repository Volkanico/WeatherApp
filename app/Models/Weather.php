<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $fillable = [
        'temperature',
        'weathercode',
        'weather_description',
        'windspeed',
        'winddirection',
        'is_day',
        'time',
        'city_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}

