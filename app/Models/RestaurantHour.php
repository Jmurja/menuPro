<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantHour extends Model
{
    protected $fillable = [
        'restaurant_id',
        'day_of_week',
        'is_open',
        'opening_time',
        'closing_time',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
    ];

    /**
     * Get the restaurant that owns the hours.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the day name.
     */
    public function getDayNameAttribute()
    {
        $days = [
            0 => 'Domingo',
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
        ];

        return $days[$this->day_of_week] ?? '';
    }
}
