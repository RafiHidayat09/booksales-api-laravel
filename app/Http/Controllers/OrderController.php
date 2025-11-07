<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // ✅ tambahkan ini
use App\Models\Cart;  // ✅ tambahkan ini

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();
        $carts = Cart::where('user_id', $user->id)->with('book')->get();

        $total = $carts->sum(fn($item) => $item->book->price * $item->quantity);

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $total,
            'status' => 'pending',
            'payment_method' => 'cod',
        ]);

        // Kosongkan cart setelah pesanan dibuat
        Cart::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Order created', 'order' => $order]);
    }

    public function index()
    {
        // Ambil semua order dengan relasi user
        return response()->json(Order::with('user')->get());
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Order status updated']);
    }
}
