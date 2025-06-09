<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request; // ✅ necessário
use Illuminate\Support\Facades\Storage; // ✅ necessário

class MenuController extends Controller
{
    public function index()
    {
        $items = MenuItem::latest()->get();
        return view('menu.index', compact('items'));
    }


    public function show($id)
    {
        $item = MenuItem::findOrFail($id);
        return view('menu.show', compact('item'));
    }

    public function create()
    {

        return view('menu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048', // até 2MB
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('menu-images', 'public');
        }

        \App\Models\MenuItem::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'image_url' => isset($validated['image_url']) ? Storage::url($validated['image_url']) : null,
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
