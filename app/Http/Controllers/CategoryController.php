<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function index()
    {
        $restaurant = auth()->user()->primaryRestaurant();

        if (!$restaurant) {
            return back()->with('error', 'Restaurante não vinculado.');
        }

        $categories = Category::where('restaurant_id', $restaurant->id)->orderBy('name')->get();
        return view('categories.index', compact('categories'));
    }    
    public function create()
    {
        $restaurant = auth()->user()->primaryRestaurant();

        if (!$restaurant) {
            return back()->with('error', 'Restaurante não vinculado.');
        }

        $categories = Category::where('restaurant_id', $restaurant->id)->orderBy('name')->get();
        return view('menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $restaurant = $user->primaryRestaurant();

        if (!$restaurant) {
            return back()->with('error', 'Restaurante não vinculado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'restaurant_id' => $restaurant->id,
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
        ]);

        return back()->with('success', 'Categoria criada com sucesso!');
    }

}
