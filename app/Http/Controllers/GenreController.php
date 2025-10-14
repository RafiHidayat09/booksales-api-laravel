<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // Ini apabila data dibuat dalam Model saja
    // public function index (){
    //    $data = new Genre(); // Membuat object
    //    $genres = $data->getGenres(); // Mengakses method getGenres
    //    return view('genres', ['genres' => $genres]); // Mengirim data genre ke view
    // }

    public function index(){
        $genres = Genre::all(); // Supaya mengambil semua data dan kirim ke view
        return view('genres', ['genres' => $genres]);
    }
}
