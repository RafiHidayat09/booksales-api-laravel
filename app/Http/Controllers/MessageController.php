<?php

// app/Http/Controllers/MessageController.php
namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // User: Send message
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'nullable|exists:books,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
            'message' => $request->message,
        ]);

        return response()->json(['success' => true, 'message' => $message], 201);
    }

    // Admin: Get all messages
    public function index()
    {
        $messages = Message::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($messages);
    }

    // Admin: Delete message
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return response()->json(['success' => true]);
    }
}
