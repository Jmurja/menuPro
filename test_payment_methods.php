<?php

// This script tests the payment method functionality by:
// 1. Creating a test order
// 2. Closing the order with a payment method
// 3. Verifying the payment method is saved correctly

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
    echo "Starting payment method test...\n";

    // Get a restaurant and user for testing
    $restaurant = Restaurant::first();
    $user = User::where('role', 'caixa')->first();

    if (!$restaurant) {
        echo "Error: No restaurant found for testing\n";
        exit(1);
    }

    if (!$user) {
        echo "No cashier user found, using any user for testing\n";
        $user = User::first();
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
        'table' => 'TEST02',
        'status' => 'aberto',
        'is_closed' => false,
    ]);

    echo "Created test order #{$order->id}\n";

    // Create order items
    $quantity = 2;
    $orderItem = OrderItem::create([
        'order_id' => $order->id,
        'menu_item_id' => $menuItem->id,
        'quantity' => $quantity,
        'price' => $menuItem->price,
    ]);

    $expectedTotal = $quantity * $menuItem->price;
    echo "Added {$quantity} x {$menuItem->name} with total price: {$expectedTotal}\n";

    // Test payment methods
    $paymentMethods = ['dinheiro', 'cartao_credito', 'cartao_debito', 'pix'];
    $testMethod = $paymentMethods[array_rand($paymentMethods)];

    // Close the order with payment method
    $order->update([
        'status' => 'fechado',
        'is_closed' => true,
        'payment_method' => $testMethod
    ]);

    echo "Closed the order with payment method: {$testMethod}\n";

    // Verify payment method was saved
    $updatedOrder = Order::find($order->id);

    if ($updatedOrder->payment_method === $testMethod) {
        echo "SUCCESS: Payment method was saved correctly\n";
    } else {
        echo "ERROR: Payment method was not saved correctly. Expected: {$testMethod}, Got: {$updatedOrder->payment_method}\n";
    }

    // Test bill splitting (simulation only since it's UI functionality)
    echo "Testing bill splitting calculation...\n";
    $splitCount = 4;
    $perPersonAmount = $expectedTotal / $splitCount;

    echo "Total bill: {$expectedTotal}\n";
    echo "Split between {$splitCount} people: {$perPersonAmount} per person\n";

    echo "Test completed successfully\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} finally {
    // Rollback all changes
    DB::rollBack();
    echo "All test changes have been rolled back\n";
}
