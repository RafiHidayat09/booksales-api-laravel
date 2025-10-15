<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
     public function index(){
        $authors = Author::all(); // Supaya mengambil semua data dan kirim ke view
        return view('authors', ['authors' => $authors]);
    }
    //   public function index (){
    //    $data = new Author(); // Membuat object
    //    $authors = $data->getAuthors(); // Mengakses method getAuthor
    //    return view('authors', ['authors' => $authors]); // Mengirim data author ke view
    // }
}
