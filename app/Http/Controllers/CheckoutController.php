<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CheckoutController extends Controller
{


    public function checkout(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'billing_first_name' => 'required|string|max:255',
            'billing_last_name' => 'required|string|max:255',
            'billing_email' => 'required|email',
            'billing_phone' => 'required|string|max:20',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string',
            'billing_state' => 'required|string',
            'billing_country' => 'required|string',
            'billing_postal_code' => 'required|string|max:20',
            'payment_method' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Fetch user’s cart items (from your `carts` table)
            $cartItems = DB::table('cart_items')
                ->join('carts', 'cart_items.cart_id', '=', 'carts.id')
                ->join('products', 'cart_items.product_id', '=', 'products.id')
                ->where('carts.user_id', $user->id)
                ->select(
                    'cart_items.id',
                    'cart_items.quantity',
                    'products.id as product_id',
                    'products.name as product_name',
                    'products.price as product_price'
                )
                ->get();



            if ($cartItems->isEmpty()) {
                return response()->json(['message' => 'Cart is empty'], 400);
            }

            // Calculate total
            $total = $cartItems->sum(fn($item) => $item->product_price * $item->quantity);
            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'subtotal' => $total,
                'total' => $total, // optional: if you’re not adding shipping/tax yet
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'status' => 'new',
                'billing_first_name' => $validated['billing_first_name'],
                'billing_last_name' => $validated['billing_last_name'],
                'billing_email' => $validated['billing_email'],
                'billing_phone' => $validated['billing_phone'],
                'billing_address' => $validated['billing_address'],
                'billing_city' => $validated['billing_city'],
                'billing_state' => $validated['billing_state'],
                'billing_country' => $validated['billing_country'],
                'billing_postal_code' => $validated['billing_postal_code'],
            ]);

            // Create Order Items
            foreach ($cartItems as $item) {
                $productName = $item->product_name ?? 'Unnamed Product';

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'price' => $item->product_price,
                    'quantity' => $item->quantity,
                    'total' => $item->product_price * $item->quantity, // ✅ Must be here
                ]);

                Product::where('id', $item->product_id)
                    ->decrement('quantity', $item->quantity);
            }



            // Clear cart
            DB::table('cart_items')
                ->join('carts', 'cart_items.cart_id', '=', 'carts.id')
                ->where('carts.user_id', $user->id)
                ->delete();

            DB::table('carts')->where('user_id', $user->id)->delete();

            DB::commit();

            return response()->json([
                'message' => 'Order placed successfully',
                'order_number' => $order->order_number,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Checkout failed: ' . $e->getMessage(),
            ], 500);
        }
    }

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

//    public function store(Request $request)
//    {
//        $user = Auth::user();
//        if (!$user) {
//            return response()->json(['message' => 'Unauthorized'], 401);
//        }
//
//        // ✅ Get the user's cart first
//        $cart = Cart::where('user_id', $user->id)->first();
//
//        if (!$cart) {
//            return response()->json(['message' => 'Cart not found'], 404);
//        }
//
//        // ✅ Fetch cart items joined with product data
//        $cartItems = DB::table('cart_items')
//            ->join('products', 'cart_items.product_id', '=', 'products.id')
//            ->where('cart_items.cart_id', $cart->id) // ✅ use cart_id, not user_id
//            ->select(
//                'cart_items.id',
//                'cart_items.quantity',
//                'products.id as product_id',
//                'products.name as product_name',
//                'products.price as product_price'
//            )
//            ->get();
//
//        if ($cartItems->isEmpty()) {
//            return response()->json(['message' => 'Your cart is empty'], 400);
//        }
//
//        // ✅ Calculate total
//        $total = $cartItems->sum(fn($item) => $item->product_price * $item->quantity);
//
//        // ✅ Create Order
//        $order = Order::create([
//            'order_number' => 'ORD-' . strtoupper(uniqid()),
//            'user_id' => $user->id,
//            'subtotal' => $total,
//            'total' => $total,
//            'payment_method' => 'cod',
//            'billing_first_name' => $user->name,
//            'billing_last_name' => '',
//            'billing_email' => $user->email,
//            'billing_phone' => '',
//            'billing_address' => '',
//            'billing_city' => '',
//            'billing_state' => '',
//            'billing_country' => 'Bangladesh',
//            'billing_postal_code' => '',
//        ]);
//
//        // ✅ Store each order item
//        foreach ($cartItems as $item) {
//            OrderItem::create([
//                'order_id' => $order->id,
//                'product_id' => $item->product_id,
//                'product_name' => $item->product_name,
//                'price' => $item->product_price,
//                'quantity' => $item->quantity,
//                'total' => $item->product_price * $item->quantity,
//            ]);
//
//            // Decrease stock
//            Product::where('id', $item->product_id)
//                ->decrement('stock', $item->quantity);
//        }
//
//        // ✅ Clear user's cart
//        DB::table('cart_items')->where('cart_id', $cart->id)->delete();
//
//        return response()->json(['message' => 'Order placed successfully!']);
//    }
}
