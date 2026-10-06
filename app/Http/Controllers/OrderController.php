<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Student Orders
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }


    /*
    |--------------------------------------------------------------------------
    | Store Order
    |--------------------------------------------------------------------------
    */

    public function store()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = DB::transaction(function () use ($cart, $total) {

            $kotNumber = 'KOT-' . now()->format('YmdHis');

            $order = Order::create([
                'user_id' => Auth::id(),
                'kot_number' => $kotNumber,
                'total_amount' => $total,
                'status' => 'pending',
                'payment_status' => 'submitted',
            ]);

            foreach ($cart as $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'snack_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order placed successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Show Order
    |--------------------------------------------------------------------------
    */

    public function show(Order $order)
    {
        abort_unless(
            $order->user_id === Auth::id(),
            403
        );

        $order->load('items.snack');

        return view('orders.show', compact('order'));
    }


    /*
    |--------------------------------------------------------------------------
    | Payment Page
    |--------------------------------------------------------------------------
    */

    public function payment()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('orders.payment', compact('cart', 'total'));
    }


    /*
    |--------------------------------------------------------------------------
    | Submit Payment
    |--------------------------------------------------------------------------
    */

    public function submitPayment(Request $request)
    {
        $request->validate([
            'payment_reference' => 'required|string|max:100',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $kotNumber = 'KOT-' . now()->format('YmdHis');

        $order = Order::create([
            'user_id' => Auth::id(),
            'kot_number' => $kotNumber,
            'total_amount' => $total,
            'status' => 'pending',
            'payment_status' => 'submitted',
            'payment_reference' => $request->payment_reference,
        ]);

        foreach ($cart as $item) {

            $subtotal = $item['price'] * $item['quantity'];

            $order->items()->create([
                'snack_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $subtotal,
            ]);
        }

        session()->forget('cart');

        return redirect()
            ->route('orders.show', $order)
            ->with(
                'success',
                'Payment submitted successfully. Your order is waiting for admin verification.'
            );
    }
}
