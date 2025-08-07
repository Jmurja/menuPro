<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantHoursController extends Controller
{
    /**
     * Show the form for editing restaurant hours.
     */
    public function edit(Restaurant $restaurant)
    {
        // Get existing hours or create default ones
        $hours = $restaurant->hours;

        // If no hours exist, create default ones for all days of the week
        if ($hours->isEmpty()) {
            $hours = collect();
            for ($day = 0; $day < 7; $day++) {
                $hours->push(new RestaurantHour([
                    'day_of_week' => $day,
                    'is_open' => $day > 0 && $day < 6, // Closed on weekends by default
                    'opening_time' => '08:00',
                    'closing_time' => '18:00',
                ]));
            }
        }

        return view('owner.hours', compact('restaurant', 'hours'));
    }

    /**
     * Update the restaurant hours.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        // Validate the request
        $validated = $request->validate([
            'days' => 'required|array',
            'days.*.day_of_week' => 'required|integer|min:0|max:6',
            'days.*.is_open' => 'boolean',
            'days.*.opening_time' => 'nullable|required_if:days.*.is_open,1|date_format:H:i',
            'days.*.closing_time' => 'nullable|required_if:days.*.is_open,1|date_format:H:i|after:days.*.opening_time',
        ]);

        // Ensure all days have the required keys
        foreach ($validated['days'] as $key => $day) {
            if (!isset($day['day_of_week'])) {
                $validated['days'][$key]['day_of_week'] = $key % 7;
            }
        }

        // Delete existing hours
        $restaurant->hours()->delete();

        // Create new hours
        foreach ($validated['days'] as $day) {
            $isOpen = isset($day['is_open']) && $day['is_open'] == 1;
            $restaurant->hours()->create([
                'day_of_week' => $day['day_of_week'],
                'is_open' => $isOpen,
                'opening_time' => $isOpen ? $day['opening_time'] : null,
                'closing_time' => $isOpen ? $day['closing_time'] : null,
            ]);
        }

        return redirect()->route('my_restaurants.show', $restaurant)
            ->with('success', 'Horários de funcionamento atualizados com sucesso.');
    }
}
