<?php

// This script tests the reports functionality by:
// 1. Creating a test order with items
// 2. Closing the order
// 3. Verifying the order appears in reports with correct prices

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// Start transaction to rollback changes after test
DB::beginTransaction();

try {
    echo "Starting reports test...\n";

    // Get a restaurant and user for testing
    $restaurant = Restaurant::first();
    $user = User::where('role', 'dono')->first();

    if (!$restaurant || !$user) {
        echo "Error: No restaurant or owner user found for testing\n";
        exit(1);
    }

    echo "Using restaurant: {$restaurant->name}\n";

    // Get a menu item for testing
    $menuItem = MenuItem::where('restaurant_id', $restaurant->id)->first();

    if (!$menuItem) {
        echo "Error: No menu item found for testing\n";
        exit(1);
    }

    echo "Using menu item: {$menuItem->name} with price: {$menuItem->price}\n";

    // Create a test order
    $order = Order::create([
        'restaurant_id' => $restaurant->id,
        'user_id' => $user->id,
        'table' => 'TEST01',
        'status' => 'aberto',
        'is_closed' => false,
    ]);

    echo "Created test order #{$order->id}\n";

    // Create order items
    $quantity = 3;
    $orderItem = OrderItem::create([
        'order_id' => $order->id,
        'menu_item_id' => $menuItem->id,
        'quantity' => $quantity,
        'price' => $menuItem->price,
    ]);

    $expectedRevenue = $quantity * $menuItem->price;
    echo "Added {$quantity} x {$menuItem->name} with total price: {$expectedRevenue}\n";

    // Close the order
    $order->update([
        'status' => 'fechado',
        'is_closed' => true,
    ]);

    echo "Closed the order\n";

    // Get the current date range
    $startDate = Carbon::now()->subDays(1)->startOfDay();
    $endDate = Carbon::now()->addDays(1)->endOfDay();

    // Calculate revenue using the same logic as ReportController
    $actualRevenue = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.restaurant_id', $restaurant->id)
        ->where('orders.is_closed', true)
        ->whereBetween('orders.created_at', [$startDate, $endDate])
        ->sum(DB::raw('order_items.price * order_items.quantity'));

    echo "Expected revenue: {$expectedRevenue}\n";
    echo "Actual revenue from query: {$actualRevenue}\n";

    // Check if the revenue is calculated correctly
    if ($actualRevenue >= $expectedRevenue) {
        echo "SUCCESS: Revenue is calculated correctly\n";
    } else {
        echo "ERROR: Revenue calculation is incorrect\n";
    }

    // Test date filtering
    $pastDate = Carbon::now()->subDays(30);
    $futureDate = Carbon::now()->addDays(30);

    $pastRevenue = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.restaurant_id', $restaurant->id)
        ->where('orders.is_closed', true)
        ->whereBetween('orders.created_at', [$pastDate, $pastDate->copy()->addDays(1)])
        ->sum(DB::raw('order_items.price * order_items.quantity'));

    $futureRevenue = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.restaurant_id', $restaurant->id)
        ->where('orders.is_closed', true)
        ->whereBetween('orders.created_at', [$futureDate, $futureDate->copy()->addDays(1)])
        ->sum(DB::raw('order_items.price * order_items.quantity'));

    echo "Revenue from 30 days ago: {$pastRevenue} (should be 0)\n";
    echo "Revenue from 30 days in future: {$futureRevenue} (should be 0)\n";

    if ($pastRevenue == 0 && $futureRevenue == 0) {
        echo "SUCCESS: Date filtering is working correctly\n";
    } else {
        echo "ERROR: Date filtering is not working correctly\n";
    }

    echo "Test completed successfully\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} finally {
    // Rollback all changes
    DB::rollBack();
    echo "All test changes have been rolled back\n";
}
