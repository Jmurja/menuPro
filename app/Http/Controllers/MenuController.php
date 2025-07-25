<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class MenuController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!in_array($user->role, [UserRole::DONO, UserRole::CAIXA])) {
            abort(403, 'Acesso não autorizado.');
        }

        $restaurant = $user->primaryRestaurant();

        if (!$restaurant) {
            return back()->with('error', 'Restaurante não vinculado.');
        }

        $items = MenuItem::with('category')
            ->where('restaurant_id', $restaurant->id)
            ->get()
            ->groupBy(fn($item) => $item->category->name ?? 'Sem Categoria');

        $categories = Category::orderBy('name')->get();

        return view('menu.index', compact('items', 'categories'));
    }

    public function publicMenu(Request $request)
    {
        $query = MenuItem::with('category')->where('is_active', true);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('category')) {
            $categoryId = $request->input('category');
            $query->where('category_id', $categoryId);
        }

        $currentTime = now()->format('H:i:s');
        $query->where(function($q) use ($currentTime) {
            $q->whereNull('availability_start_time')
                ->orWhereNull('availability_end_time')
                ->orWhere(function($q) use ($currentTime) {
                    $q->where('availability_start_time', '<=', $currentTime)
                        ->where('availability_end_time', '>=', $currentTime);
                });
        });

        $query->where(function($q) {
            $q->whereNull('stock_quantity')
                ->orWhere('stock_quantity', '>', 0);
        });

        $items = $query->get()->groupBy(function ($item) {
            return $item->category->name ?? 'Sem Categoria';
        });

        $categories = Category::orderBy('name')->get();
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
        $user = Auth::user();
        $restaurant = $user->primaryRestaurant();

        if (!$restaurant) {
            return back()->with('error', 'Restaurante não vinculado.');
        }

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
            $validated['image_url'] = Storage::url($request->file('image')->store('menu-images', 'public'));
        }

        $validated['restaurant_id'] = $restaurant->id;

        MenuItem::create($validated);

        return back()->with('success', 'Item criado com sucesso!');
    }

    private function parseCurrencyToFloat($value)
    {
        if (!$value) return 0;
        $value = str_replace(['R$', ' '], '', $value);
        $value = preg_replace('/\.(?=\d{3,})/', '', $value);
        return floatval(str_replace(',', '.', $value));
    }

    public function edit($id)
    {
        $item = MenuItem::findOrFail($id);
        $restaurant = Auth::user()->primaryRestaurant();
        if ($item->restaurant_id !== $restaurant?->id) {
            abort(403);
        }
        return view('menu.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = MenuItem::findOrFail($id);
        $restaurant = Auth::user()->primaryRestaurant();
        if ($item->restaurant_id !== $restaurant?->id) {
            abort(403);
        }

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
            $validated['image_url'] = Storage::url($request->file('image')->store('menu-images', 'public'));
        }

        if (isset($validated['is_active'])) {
            $item->is_active = $validated['is_active'];
            unset($validated['is_active']);
        }

        $item->update(array_filter($validated, fn($value) => $value !== null));

        return redirect()->route('menu')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $item = MenuItem::findOrFail($id);
        $restaurant = Auth::user()->primaryRestaurant();
        if ($item->restaurant_id !== $restaurant?->id) {
            abort(403);
        }
        $item->delete();

        return redirect()->route('menu')->with('success', 'Item excluído com sucesso!');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
        ]);

        return back()->with('success', 'Categoria criada com sucesso!');
    }
}
