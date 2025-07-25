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
            'name'              => ['required', 'string', 'max:255'],
            'users'             => ['nullable', 'array'],
            'users.*.id'        => ['required', 'exists:users,id'],
            'users.*.role'      => ['required', Rule::in(['dono', 'garcom', 'caixa'])],
        ]);

        $restaurant = Restaurant::create([
            'name' => $validated['name'],
        ]);

        if (!empty($validated['users'])) {
            $syncData = collect($validated['users'])->mapWithKeys(function ($user) {
                return [$user['id'] => ['role' => $user['role']]];
            })->toArray();

            $restaurant->users()->sync($syncData);
        }

        return redirect()->route('restaurants.index')->with('success', 'Restaurante cadastrado com sucesso.');
    }

    public function edit(Restaurant $restaurant)
    {
        $restaurant->load('users');
        $users = User::all();

        return view('restaurants.edit', compact('restaurant', 'users'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'users'             => ['nullable', 'array'],
            'users.*.id'        => ['required', 'exists:users,id'],
            'users.*.role'      => ['required', Rule::in(['dono', 'garcom', 'caixa'])],
        ]);

        $restaurant->update(['name' => $validated['name']]);

        if (!empty($validated['users'])) {
            $syncData = collect($validated['users'])->mapWithKeys(function ($user) {
                return [$user['id'] => ['role' => $user['role']]];
            })->toArray();

            $restaurant->users()->sync($syncData);
        } else {
            $restaurant->users()->detach();
        }

        return redirect()->route('restaurants.index')->with('success', 'Restaurante atualizado com sucesso.');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->users()->detach();
        $restaurant->delete();

        return redirect()->back()->with('success', 'Restaurante excluído com sucesso.');
    }
}
