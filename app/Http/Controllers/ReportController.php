<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $restaurant = $request->restaurant_id
            ? Restaurant::findOrFail($request->restaurant_id)
            : $user->primaryRestaurant();

        if (!$restaurant || !$user->restaurants->contains($restaurant->id)) {
            abort(403, 'Você não tem permissão para acessar este restaurante.');
        }

        $startDate = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->subDays(30)->startOfDay();

        $endDate = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfDay();

        $ordersByStatus = Order::where('restaurant_id', $restaurant->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        $totalOrders = Order::where('restaurant_id', $restaurant->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $totalRevenue = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.restaurant_id', $restaurant->id)
            ->where('orders.is_closed', true)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->sum(DB::raw('order_items.price * order_items.quantity'));

        $ordersByDay = Order::where('restaurant_id', $restaurant->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topSellingItems = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->where('orders.restaurant_id', $restaurant->id)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(
                'menu_items.name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
            )
            ->groupBy('menu_items.name')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        return view('reports.index', compact(
            'restaurant',
            'ordersByStatus',
            'totalOrders',
            'totalRevenue',
            'ordersByDay',
            'topSellingItems',
            'startDate',
            'endDate'
        ));
    }
}
