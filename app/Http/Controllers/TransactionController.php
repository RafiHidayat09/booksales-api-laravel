<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        // Jangan lupa di import class Transactionnya
        $transactions = Transaction::with('user', 'book')->get(); // Untuk menampilkan data usernya juga
        // $transactions = Transaction::with('user', 'book')->find($id); // Untuk show id

        if ($transactions->isEmpty()){
            return response()->json([
                "success" => true,
                "message" => "Resource Data Not Found"
            ],200); //Hanya mengecek sehingga tidak mengirim data
        }

        return response()->json([
            "success" => true,
            "message" => "Get All Resources",
            "data" => $transactions
        ], 200);
    }

    public function store(Request $request)
    {
        // 1. Validator dan Cek Validator (Jangan lupa import class Support/Facades/Validator)
        $validator = Validator::make($request->all(), [
            // Order number tidak perlu karena digenerate
            // Customer id tidak perlu karena diambil dari user yang sedang login
            'book_id' => 'required|exists:books,id',// Harus diambil  untuk mencari data buku
            // Total amount juga otomatis jadi tidak usah
            'quantity' => 'required|integer|min:1' // Walau tidak ada di tabel tapi tidak masalah
        ]);
        if ($validator->fails()){
            return response()->json([
                'success' =>false,
                'message' => 'Validator Error',
                'data' => $validator->errors()
            ], 422);
        }

        // 2. Generate Order Number -> Unique dan berformat ORD-(Angka Generate Unik)
        $uniqueCode = "ORD-" . strtoupper(uniqid());

        // 3. Ambil user yang sedang login (pakai token auth) & cek login (apakah ada user?)
        $user = auth('api')->user();
        if (!$user){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized!'
            ], 401);
        }

        // 4. Mencari data buku dari request
        $book = Book::find($request->book_id); // Book jangan lupa di import

        // 5. Cek stok buku (jika stok kurang maka tidak boleh membeli lebih dari jumlah yang ada)
        if ($book->stock < $request->quantity){
            return response()->json([
                'success' => false,
                'message' => 'Stock Barang Tidak Cukup!'
            ], 400);
        }

        // 6. Hitung total harga (price * quantity)
        $totalAmount = $book->price * $request->quantity;

        // 7. Kurangi stok buku (update)
        $book->stock -= $request->quantity;
        $book->save(); // Save untuk melakukan update

        // 8. Simpan data transaksi
        $transactions = Transaction::create([
            'order_number' => $uniqueCode,
            'customer_id' => $user->id,
            'book_id' => $request->book_id,
            'total_amount'=> $totalAmount
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction Created Successfully',
            'data' => $transactions
        ], 201);

    }

    public function updateStatus(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'status' => 'required|in:pending,accepted,rejected',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validator Error',
            'data' => $validator->errors(),
        ], 422);
    }

    $transaction = Transaction::findOrFail($id);
    $transaction->status = $request->status;
    $transaction->save();

    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully',
        'data' => $transaction
    ]);
}


}
