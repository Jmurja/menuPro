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
            'icon' => 'nullable|string|max:10',
            'custom_icon' => 'nullable|string|max:10',
            'is_offer' => 'nullable|boolean',
            'offer_type' => 'nullable|string|in:ofertas,combos',
        ]);

        // Capitalize the first letter of the category name
        $name = ucfirst($validated['name']);

        // Determine the icon (either from dropdown or custom input)
        $icon = !empty($validated['custom_icon']) ? $validated['custom_icon'] : $validated['icon'];

        Category::create([
            'restaurant_id' => $restaurant->id,
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'icon' => $icon,
            'is_offer' => isset($validated['is_offer']),
            'offer_type' => isset($validated['is_offer']) ? $validated['offer_type'] : null,
        ]);

        return back()->with('success', 'Categoria criada com sucesso!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $restaurant = $user->primaryRestaurant();

        if (!$restaurant) {
            return back()->with('error', 'Restaurante não vinculado.');
        }

        // Ensure the category belongs to the authenticated user's primary restaurant
        $category = Category::where('restaurant_id', $restaurant->id)->findOrFail($id);

        // Detach related menu items to avoid foreign key constraint issues
        if (method_exists($category, 'menuItems')) {
            $category->menuItems()->update(['category_id' => null]);
        }

        $category->delete();

        return back()->with('success', 'Categoria excluída com sucesso!');
    }
}
