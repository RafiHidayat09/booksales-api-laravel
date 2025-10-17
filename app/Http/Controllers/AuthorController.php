<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            "message" => "Get All Resources",
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

     // SHOW
    public function show(string $id){
        $author = Author::find($id); //tidak pakai huruf s karena mengambil 1 data
        if (!$author){
            return response()->json([
                'sucess'=>false,
                'message'=>'Resource Not Found'
            ], 404);
        }
        return response()->json([
            'success'=>true,
            'message'=>'Get Detail Resource',
            'data'=>$author
        ], 200);
    }

    // UPDATE 
    public function update(string $id, Request $request){
        // 1. Mencari Data
        $author = Author::find($id);
        if(!$author){
            return response()->json([
                'success'=>false,
                'message'=>'Resource Not Found'
            ]);
        }
        // 2. Validasi
         $validator = Validator::make($request ->all(), [
            'name' => 'required|string|max:100', // jangan pakai spasi
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'bio' => 'required|string'
        ]);
        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. Siapkan Data Yang Ingin diUpdate
        $data = [
            'name' => $request->name,
            'bio' => $request->bio
        ];

        // 4. Handle Image (upload & delete)
        //Jika ingin mengganti maka akan di cek jika ada maka akan disimpan dalam storage folder authors (public)
        if ($request->hasFile('photo')){
            $image = $request->file('photo');
            $image->store('authors','public');
            // Lalu file yang lama akan dihapus dari folder authors dan nama filenya
            if ($author->bio){
              Storage::disk('public')->delete('authors/' . $author->photo); 
        }
        // Akan menambahkan array baru ke variabel data (diappend)
        $data['photo'] = $image->hashName();
        }
        
        // 5. Update Data Baru ke Database
        $author->update($data);

          return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully!',
            'data' => $author
        ], 200);
    }

    // DESTROY
    public function destroy(string $id){
        $author = Author::find($id);
         if (!$author){
            return response()->json([
                'sucess'=>false,
                'message'=>'Resource Not Found'
            ], 404);
        }

        // Supaya menghapus file gambar
        if ($author->photo){
            // delete from storage
            // Jangan lupa import class Storage (facades)
            Storage::disk('public')->delete('authors/' . $author->photo);
        }
        $author->delete();
        
        return response()->json([
            'success'=>true,
            'message'=>'Delete Resource Successfully'
        ]);
    }

}
