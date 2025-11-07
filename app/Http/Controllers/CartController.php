<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Book;


class CartController extends Controller
{
    public function index(Request $request)
    {
        $carts = Cart::with('book')->where('user_id', $request->user()->id)->get();
        return response()->json($carts);
    }

    public function store(Request $request)
    {
        $cart = Cart::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'book_id' => $request->book_id,
            ],
            ['quantity' => \DB::raw('quantity + 1')]
        );

        return response()->json(['message' => 'Book added to cart', 'cart' => $cart]);
    }

    public function destroy($id)
    {
        Cart::findOrFail($id)->delete();
        return response()->json(['message' => 'Book removed from cart']);
    }
}
