<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\TransactionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api'); // Untuk mengakses logout harus login dahulu

Route::apiResource('/books', BookController::class)->only(['index', 'show']);     // Misal Semua Data Buku bisa diakses oleh semua orang
Route::apiResource('/authors', AuthorController::class)->only('index', 'show'); // Misal semua data author dan genre bisa diakses oleh semua orang
Route::apiResource('/genres', GenreController::class)->only('index','show');

Route::middleware(['auth:api'])->group(function(){
    Route::apiResource('/transactions', TransactionController::class)->only('index', 'store', 'show'); // Transaction bisa diakses jika sudah login
    // Route::apiResource('/genres', GenreController::class); // Genre Bisa diakses jika login
    // Namun untuk menambahkan data buku hanya bisa ditambahkan orang yang sudah login
    // Dan hanya role admin yang bisa menambahkan
    Route::middleware(['role:admin'])->group(function(){
        Route::apiResource('/transactions', TransactionController::class)->only('update', 'destroy'); // Update dan Destroy hanya untuk admin
        Route::apiResource('/books', BookController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('/genres', GenreController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('/authors', AuthorController::class)->only(['store', 'update', 'destroy']);


    });
   
});

