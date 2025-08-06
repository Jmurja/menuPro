<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Promotion;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurant = auth()->user()->primaryRestaurant();

        if (!$restaurant) {
            return back()->with('error', 'Restaurante não vinculado.');
        }

        $promotions = Promotion::where('restaurant_id', $restaurant->id)
            ->with('menuItem')
            ->orderBy('created_at', 'desc')
            ->get();

        $menuItems = MenuItem::where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('promotions.index', compact('promotions', 'menuItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $restaurant = auth()->user()->primaryRestaurant();

        if (!$restaurant) {
            return back()->with('error', 'Restaurante não vinculado.');
        }

        $menuItems = MenuItem::where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('promotions.create', compact('menuItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $restaurant = auth()->user()->primaryRestaurant();

        if (!$restaurant) {
            return back()->with('error', 'Restaurante não vinculado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'menu_item_id' => 'required|exists:menu_items,id',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean'
        ]);

        // Check if at least one discount type is provided
        if (empty($validated['discount_price']) && empty($validated['discount_percentage'])) {
            return back()->withErrors(['discount' => 'É necessário informar pelo menos um tipo de desconto.'])
                         ->withInput();
        }

        // Check if the menu item already has an active promotion
        $existingPromotion = Promotion::where('menu_item_id', $validated['menu_item_id'])
            ->where('is_active', true)
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_date', '<=', $validated['end_date'])
                      ->where('end_date', '>=', $validated['start_date']);
                });
            })
            ->first();

        if ($existingPromotion) {
            return back()->withErrors(['menu_item_id' => 'Este item já possui uma promoção ativa no período informado.'])
                         ->withInput();
        }

        $validated['restaurant_id'] = $restaurant->id;

        Promotion::create($validated);

        return redirect()->route('promotions.index')->with('success', 'Promoção criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $promotion = Promotion::with('menuItem')->findOrFail($id);

        // Check if user has access to this promotion
        $restaurant = auth()->user()->primaryRestaurant();
        if (!$restaurant || $promotion->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('promotions.show', compact('promotion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $promotion = Promotion::findOrFail($id);

        // Check if user has access to this promotion
        $restaurant = auth()->user()->primaryRestaurant();
        if (!$restaurant || $promotion->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action.');
        }

        $menuItems = MenuItem::where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('promotions.edit', compact('promotion', 'menuItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $promotion = Promotion::findOrFail($id);

        // Check if user has access to this promotion
        $restaurant = auth()->user()->primaryRestaurant();
        if (!$restaurant || $promotion->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'menu_item_id' => 'required|exists:menu_items,id',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean'
        ]);

        // Check if at least one discount type is provided
        if (empty($validated['discount_price']) && empty($validated['discount_percentage'])) {
            return back()->withErrors(['discount' => 'É necessário informar pelo menos um tipo de desconto.'])
                         ->withInput();
        }

        // Check if the menu item already has an active promotion (excluding this one)
        $existingPromotion = Promotion::where('menu_item_id', $validated['menu_item_id'])
            ->where('id', '!=', $id)
            ->where('is_active', true)
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_date', '<=', $validated['end_date'])
                      ->where('end_date', '>=', $validated['start_date']);
                });
            })
            ->first();

        if ($existingPromotion) {
            return back()->withErrors(['menu_item_id' => 'Este item já possui uma promoção ativa no período informado.'])
                         ->withInput();
        }

        $promotion->update($validated);

        return redirect()->route('promotions.index')->with('success', 'Promoção atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promotion = Promotion::findOrFail($id);

        // Check if user has access to this promotion
        $restaurant = auth()->user()->primaryRestaurant();
        if (!$restaurant || $promotion->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action.');
        }

        $promotion->delete();

        return redirect()->route('promotions.index')->with('success', 'Promoção excluída com sucesso!');
    }
}
