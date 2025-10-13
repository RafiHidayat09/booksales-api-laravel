<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
      public function index (){
       $data = new Author(); // Membuat object
       $authors = $data->getAuthors(); // Mengakses method getAuthor
       return view('authors', ['authors' => $authors]); // Mengirim data author ke view
    }
}
