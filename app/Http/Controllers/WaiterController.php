<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\MenuItem;

class WaiterController extends Controller
{
    public function ordersIndex()
    {
        $restaurant = Auth::user()->primaryRestaurant();

        $items = MenuItem::with('category')
            ->where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->get()
            ->groupBy(fn($item) => $item->category->name ?? 'Sem Categoria');

        return view('waiter.orders.index', compact('items'));
    }
}
