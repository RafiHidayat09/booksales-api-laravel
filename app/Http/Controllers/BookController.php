<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    
    public function index(){
        $books = Book::all(); // Supaya mengambil semua data dan kirim ke view
        return view('books', ['books' => $books]);
    }
    // public function index(){
    //    $data = new Book(); // Membuat object
    //    $books = $data->getBooks(); // Mengakses method getBooks
    //    return view('books', ['books' => $books]); // Mengirim data buku ke view
    // }
}
