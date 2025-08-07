<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $request->validate([
            'table' => 'required|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:menu_items,id',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $restaurant = $user->primaryRestaurant();

        $order = Order::create([
            'restaurant_id' => $restaurant->id,
            'user_id' => $user->id,
            'table' => $request->input('table'), // <- CORRETO AGORA
            'is_closed' => false,
            'status' => 'aberto', // <- adiciona também se for obrigatório
        ]);

        foreach ($request->input('items') as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return response()->json(['message' => 'Pedido registrado com sucesso!']);
    }
}
