<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function index()
    {
        return Inertia::render('Checkout');
        // Fetch cart from session or database
//        $cart = session()->get('cart', []);
//
//        return Inertia::render('Checkout', [
//            'cartItems' => $cart,
//        ]);
    }

    public function store(Request $request)
    {
        // Process payment & order creation logic here
        $cart = session()->get('cart', []);

        // Example: save order to DB (pseudo)
        // Order::create([...]);

        // Clear cart
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }
}
