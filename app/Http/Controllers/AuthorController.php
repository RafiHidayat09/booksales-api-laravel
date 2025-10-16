<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index(){
        $authors = Author::all();
        if ($authors ->isEmpty()){
            return response()->json([
                "success" => true,
                "message" => "Resource Data Not Found"
            ],200); //Hanya mengecek sehingga tidak mengirim data
        }

        return response()->json([
            "success" => true,
            "massage" => "Get All Resources",
            "data" => $authors
        ], 200);
    }
    public function store(Request $request)
    {
        // 1. Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'bio' => 'required|string'

        ]);

        // 2. Check Validator Error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. Upload Image (jika ada)
        $image = $request->file('photo');
        $image->store('authors', 'public'); //disimpan di folder public di storage untuk dibuat folder bernama authors

        // 4. Insert Data
        $author = Author::create([
            'name' => $request->name,
            'photo' => $image->hashName(),
            'bio' => $request->bio,
        ]);

        // 5. Response
        return response()->json([
            'success' => true,
            'message' => 'Author added successfully!',
            'data' => $author
        ], 201);
    }
}
