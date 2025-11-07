<?php

// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // User: Get own orders
    public function userOrders()
    {
        $orders = Order::with(['items.book'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    // Admin: Get all orders
    public function index()
    {
        $orders = Order::with(['user', 'items.book'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    // Get single order
    public function show($id)
    {
        $order = Order::with(['items.book'])->findOrFail($id);
        return response()->json($order);
    }

    // Admin: Update order status
    public function update(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,accepted,rejected']);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json(['success' => true, 'order' => $order]);
    }
}
