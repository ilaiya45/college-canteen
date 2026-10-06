<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

use Carbon\Carbon;
class AdminController extends Controller
{
    public function dashboard()
{
    $orders = Order::with('user', 'items.snack')
    ->where('status', '!=', 'completed')
    ->latest()
    ->get();

    $totalOrders = Order::count();

    $pendingOrders = Order::where('status', 'pending')->count();

    $preparingOrders = Order::where('status', 'preparing')->count();

    $readyOrders = Order::where('status', 'ready')->count();

    $completedOrders = Order::where('status', 'completed')->count();

    return view('admin.dashboard', compact(
        'orders',
        'totalOrders',
        'pendingOrders',
        'preparingOrders',
        'readyOrders',
        'completedOrders'
    ));
}

    public function verifyOrder(Request $request)
{
    $request->validate([
        'kot_number' => 'required|string',
    ]);

    $order = Order::with('user', 'items.snack')
                  ->where('kot_number', $request->kot_number)
                  ->first();

    if (!$order) {
        return redirect()
            ->route('admin.dashboard')
            ->with('error', 'Invalid KOT number.');
    }

    return view('admin.verify-order', compact('order'));
}

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Order status updated successfully.');
    }

    public function verifyPayment(Order $order)
{
    $order->load('user', 'items.snack');

    return view('admin.verify-payment', compact('order'));
}

public function confirmPayment(Order $order)
{
    $indiaTime = \Carbon\Carbon::now('Asia/Kolkata');

    $order->update([
        'payment_status' => 'confirmed',
        'payment_paid_at' => $indiaTime,
        'status' => 'pending',
    ]);

    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Payment confirmed successfully.');
}

public function rejectPayment(Order $order)
{
    $order->update([
        'payment_status' => 'rejected',
        'payment_paid_at' => null,
    ]);

    return redirect()
        ->route('admin.dashboard')
        ->with('error', 'Payment rejected successfully.');
}

}
