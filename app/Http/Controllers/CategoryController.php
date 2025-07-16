<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create()
    {
        return view('menu.modal.createCategory'); // Crie esta view com o form
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $slug = \Illuminate\Support\Str::slug($validated['name']);

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        return back()->with('success', 'Categoria criada com sucesso!');
    }
}
