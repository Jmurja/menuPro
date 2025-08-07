<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function index()
    {
        $restaurant = Auth::user()->primaryRestaurant();

        $orders = Order::with('items.menuItem')
            ->where('restaurant_id', $restaurant->id)
            ->where('status', 'aberto') // status pode ser: aberto, fechado
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy('table');

        return view('cashier.index', compact('orders'));
    }

    public function closeTab(Request $request)
    {
        $request->validate([
            'table' => 'required|string',
        ]);

        $restaurant = Auth::user()->primaryRestaurant();

        $orders = Order::where('restaurant_id', $restaurant->id)
            ->where('table', $request->table)
            ->where('status', 'aberto')
            ->get();

        foreach ($orders as $order) {
            $order->update([
                'status' => 'fechado',
                'is_closed' => true
            ]);
        }

        return back()->with('success', 'Conta da mesa ' . $request->table . ' foi fechada com sucesso!');
    }

    public function fetchOpenOrders()
    {
        $restaurant = Auth::user()->primaryRestaurant();

        $orders = Order::with('items.menuItem')
            ->where('restaurant_id', $restaurant->id)
            ->where('status', 'aberto')
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy('table');

        $result = [];

        foreach ($orders as $table => $tableOrders) {
            $result[] = [
                'table' => $table,
                'orders' => $tableOrders->map(function ($order) {
                    return [
                        'id' => $order->id,
                        'created_at' => $order->created_at->format('H:i'),
                        'items' => $order->items->map(function ($item) {
                            return [
                                'name' => $item->menuItem->name,
                                'quantity' => $item->quantity,
                            ];
                        }),
                    ];
                })->values(),
            ];
        }

        return response()->json(['tables' => $result]);
    }

    public function accountSummary(Request $request)
    {
        $restaurant = Auth::user()->primaryRestaurant();

        $orders = Order::with('items.menuItem')
            ->where('restaurant_id', $restaurant->id)
            ->where('table', $request->table)
            ->where('status', 'aberto')
            ->get();

        $items = [];
        $total = 0;

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $key = $item->menu_item_id;
                if (!isset($items[$key])) {
                    $items[$key] = [
                        'name' => $item->menuItem->name,
                        'quantity' => 0,
                        'total' => 0
                    ];
                }
                $items[$key]['quantity'] += $item->quantity;
                $items[$key]['total'] += $item->quantity * $item->price;
                $total += $item->quantity * $item->price;
            }
        }

        return response()->json([
            'items' => array_values($items),
            'total' => $total,
        ]);
    }
}
