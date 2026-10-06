<?php

namespace App\Http\Controllers;

use App\Models\Snack;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Add food item to cart
     */
    public function add(Request $request, Snack $snack)
    {
        // Check whether food is available
        if (!$snack->is_available) {
            return redirect()
                ->route('food.index')
                ->with('error', 'Sorry, this food is currently unavailable.');
        }

        // Get existing cart from session
        $cart = session()->get('cart', []);

        // Get snack ID
        $snackId = $snack->id;

        // Check whether item already exists
        if (isset($cart[$snackId])) {

            // Increase quantity
            $cart[$snackId]['quantity']++;

        } else {

            // Add new item
            $cart[$snackId] = [
                'id'       => $snack->id,
                'name'     => $snack->name,
                'price'    => $snack->price,
                'quantity' => 1,
            ];
        }

        // Save cart into session
        session()->put('cart', $cart);

        // Go to cart page
        return redirect()
            ->route('cart.index')
            ->with('success', 'Food added to cart successfully.');
    }


    /**
     * Display cart
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }


    /**
     * Increase quantity
     */
    public function increase($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {

            $cart[$id]['quantity']++;

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }


    /**
     * Decrease quantity
     */
    public function decrease($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {

            if ($cart[$id]['quantity'] > 1) {

                $cart[$id]['quantity']--;

            } else {

                unset($cart[$id]);
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }


    /**
     * Remove item
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {

            unset($cart[$id]);

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }
}
