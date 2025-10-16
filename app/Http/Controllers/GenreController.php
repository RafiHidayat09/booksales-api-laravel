<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    
    public function index(){
        $genres = Genre::all();
        if ($genres ->isEmpty()){
            return response()->json([
                "success" => true,
                "massage" => "Resource Data Not Found"
            ],200); //Hanya mengecek sehingga tidak mengirim data
        }

        return response()->json([
            "success" => true,
            "massage" => "Get All Resources",
            "data" => $genres
        ], 200);
        
    }
        public function store(Request $request)
    {
        // 1. Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required|string'
        ]);

        // 2. Check Validator Error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. (Tidak ada upload image, jadi lewati)

        // 4. Insert Data
        $genre = Genre::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        // 5. Response
        return response()->json([
            'success' => true,
            'message' => 'Genre added successfully!',
            'data' => $genre
        ], 201);
    }
}
