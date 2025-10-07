<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->withCount('items')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    // Show single order with items
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['items' => function ($query) {
                $query->select('id', 'order_id', 'product_name', 'variant_name', 'price', 'quantity', 'total');
            }])
            ->findOrFail($id);

        return response()->json($order);
    }
}
