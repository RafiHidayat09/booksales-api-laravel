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


Route::middleware(['auth:api'])->group(function(){
    // Bagian yang update, create, dan show bisa diakses semua user yang sudah login
    Route::apiResource('/books', BookController::class)->only(['update', 'store','show']);    
    Route::apiResource('/authors', AuthorController::class)->only('update', 'store', 'show'); 
    Route::apiResource('/genres', GenreController::class)->only('update','store','show');
    Route::apiResource('/transactions', TransactionController::class)->only('update', 'store', 'show');
    // Untuk menambahkan dan menghapus data hanya bisa dilakukan orang yang sudah login
    // Dan hanya role admin yang bisa menambahkan
    Route::middleware(['role:admin'])->group(function(){
        Route::apiResource('/transactions', TransactionController::class)->only('index', 'destroy'); // Read All dan Destroy hanya untuk admin
        Route::apiResource('/books', BookController::class)->only(['index', 'destroy']);
        Route::apiResource('/genres', GenreController::class)->only(['index', 'destroy']);
        Route::apiResource('/authors', AuthorController::class)->only(['index', 'destroy']);


    });
   
});

