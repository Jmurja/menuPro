<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request; // ✅ necessário
use Illuminate\Support\Facades\Storage; // ✅ necessário

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::with(['menuItems' => function ($query) {
            $query->latest();
        }])->orderBy('name')->get();

        return view('menu.index', compact('categories'));
    }


    public function show($id)
    {
        $item = MenuItem::findOrFail($id);
        return view('menu.show', compact('item'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('menu-images', 'public');
            $validated['image_url'] = Storage::url($validated['image_url']);
        }

        MenuItem::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'image_url' => $validated['image_url'] ?? null,
            'category_id' => $validated['category_id'],
        ]);

        return back()->with('success', 'Item criado com sucesso!');
    }

    public function edit($id)
    {
        $item = MenuItem::findOrFail($id);
        return view('menu.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = MenuItem::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('menu-images', 'public');
            $validated['image_url'] = Storage::url($validated['image_url']);
        }

        $item->update(array_filter($validated));

        return redirect()->route('menu')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $item = MenuItem::findOrFail($id);
        $item->delete();

        return redirect()->route('menu')->with('success', 'Item excluído com sucesso!');
    }

}
