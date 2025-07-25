<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurant::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $restaurants = $query->orderBy('name')->get();
        $users = User::all();

        return view('restaurants.index', compact('restaurants', 'users'));
    }

    public function create()
    {
        $users = User::all();
        return view('restaurants.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'city'      => ['nullable', 'string', 'max:255'],
            'state'     => ['nullable', 'string', 'size:2'],
            'is_active' => ['nullable', 'boolean'],
            'user_id'   => ['required', 'exists:users,id'],
        ]);

        $restaurant = Restaurant::create([
            'name'      => $validated['name'],
            'city'      => $validated['city'] ?? null,
            'state'     => $validated['state'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        $restaurant->users()->attach($validated['user_id'], ['role' => 'dono']);

        return redirect()->route('restaurants.index')->with('success', 'Restaurante cadastrado com sucesso.');
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'city'      => ['nullable', 'string', 'max:255'],
            'state'     => ['nullable', 'string', 'size:2'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $restaurant->update([
            'name'      => $validated['name'],
            'city'      => $validated['city'] ?? null,
            'state'     => $validated['state'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('restaurants.index')->with('success', 'Restaurante atualizado com sucesso.');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->users()->detach();
        $restaurant->delete();

        return redirect()->back()->with('success', 'Restaurante excluído com sucesso.');
    }
}
