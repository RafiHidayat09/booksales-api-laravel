<?php

namespace App\Http\Controllers;

use App\Models\User; // Pastikan model User sudah ada
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Ambil semua user
        return response()->json($users);
    }
}
