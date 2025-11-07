<?php

// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Get cart items
    public function index()
    {
        $cartItems = Cart::with('book')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json(['items' => $cartItems]);
    }

    // Add to cart
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::updateOrCreate(
            ['user_id' => auth()->id(), 'book_id' => $request->book_id],
            ['quantity' => \DB::raw('quantity + ' . $request->quantity)]
        );

        return response()->json(['cart' => $cart], 201);
    }

    // Update quantity
    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);
        $cart->update(['quantity' => $request->quantity]);

        return response()->json(['cart' => $cart]);
    }

    // Remove from cart
    public function destroy($id)
    {
        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);
        $cart->delete();

        return response()->json(['success' => true]);
    }

    // Checkout
    public function checkout(Request $request)
    {
        $request->validate(['payment_method' => 'required|in:COD']);

        $cartItems = Cart::with('book')->where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Cart is empty'], 400);
        }

        $totalPrice = $cartItems->sum(fn($item) => $item->book->price * $item->quantity);

        // Create order
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $item->book_id,
                'quantity' => $item->quantity,
                'price' => $item->book->price,
            ]);
        }

        // Clear cart
        Cart::where('user_id', auth()->id())->delete();

        return response()->json(['success' => true, 'order' => $order], 201);
    }
}
