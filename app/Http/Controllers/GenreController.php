<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index (){
       $data = new Genre(); // Membuat object
       $genres = $data->getGenres(); // Mengakses method getGenres
       return view('genres', ['genres' => $genres]); // Mengirim data genre ke view
    }
}
