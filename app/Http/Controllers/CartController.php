<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $cart = $this->getCart($request);
        $items = $cart->items()->with('product')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'image' => $item->product->image ?? null,
            ];
        });

        return response()->json([
            'cartItems' => $items
        ]);





//        $cart = Auth::check()
//            ? Cart::with('items.product')->where('user_id', Auth::id())->first()
//            : Cart::with('items.product')->where('session_id', session()->getId())->first();
//
//        $cartItems = $cart ? $cart->items : [];
//        return Inertia::render('Checkout', [
//            'cartItems' => $cartItems,
//        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'nullable|integer|min:1'
        ]);
        $cart = $this->getCart($request, true);

        $quantity = $request->quantity ?? 1;

        $cartItem = $cart->items()
            ->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'quantity' => $quantity,
            ]);
        }

        return response()->json(['message' => 'Product added']);





//        $validated = $request->validate([
//            'product_id' => 'required|exists:products,id',
//            'variant_id' => 'nullable|exists:product_variants,id',
//            'quantity' => 'required|integer|min:1',
//        ]);
//        $cart = $this->getCart($request, true);
//        $quantity = $request->quantity ?? 1;
//        $cartItem = $cart->items()->where('product_id', $validated['product_id'])
//            ->where('variant_id', $validated['variant_id'] ?? null)
//            ->first();
//
//        if($cartItem) {
//            $cartItem->quantity += $quantity;
//            $cartItem->save();
//        } else {
//            $cart->items()->create([
//                'product_id' => $validated['product_id'],
//                'variant_id' => $validated['variant_id'] ?? null,
//                'quantity' => $quantity,
//            ]);
//        }
//        return response()->json(['message' => 'Product added to cart']);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getCart($request);
        $cartItem = $cart->items()->find($id);

        if (!$cartItem) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(['message' => 'Cart updated']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function remove(Request $request, $id)
    {
        $cart = $this->getCart($request);
        $cartItem = $cart->items()->find($id);

        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['message' => 'Item removed']);
        }

        return response()->json(['message' => 'Item not found'], 404);





        //        $cart->items()->where('id', $cartItemId)->delete();
    }
    public function updateQuantity(Request $request, $itemId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = $this->getCart($request);
        $item = $cart->items()->findOrFail($itemId);
        $item->quantity = $request->quantity;
        $item->save();

        return response()->json(['message' => 'Quantity updated']);
    }




    // Helper: get or create cart
    protected function getCart(Request $request, $create = true)
    {
        if ($user = $request->user()) {
            $cart = $create
                ? Cart::firstOrCreate(['user_id' => $user->id])
                : Cart::where('user_id', $user->id)->first();
        } else {
            $sessionId = $request->session()->getId();
            $cart = $create
                ? Cart::firstOrCreate(['session_id' => $sessionId])
                : Cart::where('session_id', $sessionId)->first();
        }

        return $cart;
    }
}
