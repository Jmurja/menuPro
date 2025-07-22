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
        $items = MenuItem::with('category')->get()->groupBy(function ($item) {
            return $item->category->name ?? 'Sem Categoria';
        });

        $categories = Category::orderBy('name')->get();

        return view('menu.index', compact('items', 'categories'));
    }

    public function publicMenu(Request $request)
    {
        $query = MenuItem::with('category')->where('is_active', true);

        // Filter by search term if provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category if provided
        if ($request->has('category')) {
            $categoryId = $request->input('category');
            $query->where('category_id', $categoryId);
        }

        // Filter by availability time
        $currentTime = now()->format('H:i:s');
        $query->where(function($q) use ($currentTime) {
            $q->whereNull('availability_start_time')
              ->orWhereNull('availability_end_time')
              ->orWhere(function($q) use ($currentTime) {
                  $q->where('availability_start_time', '<=', $currentTime)
                    ->where('availability_end_time', '>=', $currentTime);
              });
        });

        // Filter by stock availability
        $query->where(function($q) {
            $q->whereNull('stock_quantity')
              ->orWhere('stock_quantity', '>', 0);
        });

        $items = $query->get()->groupBy(function ($item) {
            return $item->category->name ?? 'Sem Categoria';
        });

        $categories = Category::orderBy('name')->get();

        // Fake WhatsApp number for now
        $whatsappNumber = '5511999999999';

        return view('menu.public', compact('items', 'categories', 'whatsappNumber', 'request'));
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
        $request->merge([
            'price' => $this->parseCurrencyToFloat($request->input('price')),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'is_active' => 'boolean',
            'stock_quantity' => 'nullable|integer|min:0',
            'availability_start_time' => 'nullable|date_format:H:i',
            'availability_end_time' => 'nullable|date_format:H:i|after:availability_start_time',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('menu-images', 'public');
            $validated['image_url'] = Storage::url($validated['image_url']);
        }

        // Convert time format if provided
        if (!empty($validated['availability_start_time'])) {
            $validated['availability_start_time'] = date('H:i:s', strtotime($validated['availability_start_time']));
        }

        if (!empty($validated['availability_end_time'])) {
            $validated['availability_end_time'] = date('H:i:s', strtotime($validated['availability_end_time']));
        }

        MenuItem::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'image_url' => $validated['image_url'] ?? null,
            'category_id' => $validated['category_id'],
            'is_active' => $validated['is_active'] ?? true,
            'stock_quantity' => $validated['stock_quantity'] ?? null,
            'availability_start_time' => $validated['availability_start_time'] ?? null,
            'availability_end_time' => $validated['availability_end_time'] ?? null,
        ]);

        return back()->with('success', 'Item criado com sucesso!');
    }

    private function parseCurrencyToFloat($value)
    {
        if (!$value) return 0;

        // Remove símbolo e separadores de milhar
        $value = str_replace(['R$', ' '], '', $value);
        $value = preg_replace('/\.(?=\d{3,})/', '', $value); // remove pontos de milhar

        // Substitui vírgula por ponto
        $value = str_replace(',', '.', $value);

        return floatval($value);
    }


    public function edit($id)
    {
        $item = MenuItem::findOrFail($id);
        return view('menu.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = MenuItem::findOrFail($id);

        $request->merge([
            'price' => $this->parseCurrencyToFloat($request->input('price')),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'stock_quantity' => 'nullable|integer|min:0',
            'availability_start_time' => 'nullable|date_format:H:i',
            'availability_end_time' => 'nullable|date_format:H:i|after:availability_start_time',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('menu-images', 'public');
            $validated['image_url'] = Storage::url($validated['image_url']);
        }

        // Convert time format if provided
        if (!empty($validated['availability_start_time'])) {
            $validated['availability_start_time'] = date('H:i:s', strtotime($validated['availability_start_time']));
        }

        if (!empty($validated['availability_end_time'])) {
            $validated['availability_end_time'] = date('H:i:s', strtotime($validated['availability_end_time']));
        }

        // Handle boolean field explicitly
        if (isset($validated['is_active'])) {
            $item->is_active = $validated['is_active'];
            unset($validated['is_active']);
        }

        $item->update(array_filter($validated, function ($value) {
            return $value !== null;
        }));

        return redirect()->route('menu')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $item = MenuItem::findOrFail($id);
        $item->delete();

        return redirect()->route('menu')->with('success', 'Item excluído com sucesso!');
    }

    public function storeCategory(Request $request)
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
