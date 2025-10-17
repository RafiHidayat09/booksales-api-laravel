<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(){
        $books = Book::all();
        if ($books ->isEmpty()){
            return response()->json([
                "success" => true,
                "message" => "Resource Data Not Found"
            ],200); //Hanya mengecek sehingga tidak mengirim data
        }

        return response()->json([
            "success" => true,
            "message" => "Get All Resources",
            "data" => $books
        ], 200);
    }
    public function store(Request $request){
        // 1. Validator
        $validator = Validator::make($request ->all(), [
            'title' => 'required|string|max:100', // jangan pakai spasi
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'cover_photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'genre_id' => 'required|exists:genres,id',
            'author_id' => 'required|exists:authors,id'

        ]);

        // 2. Check Validator Error
        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'massage' => $validator->errors()
            ], 422);
        }

        // 3. Upload Image
        $image = $request->file('cover_photo');
        $image->store('books', 'public'); //disimpan di folder public di storage untuk dibuat folder bernama books

        // 4. Insert Data
        $book = Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'cover_photo' => $image->hashName(),
            'genre_id' => $request->genre_id,
            'author_id' => $request->author_id
        ]);

        // 5. Response
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully!',
            'data' => $book
        ], 201);
    }
    
    // SHOW
    public function show(string $id){
        $book = Book::find($id); //tidak pakai huruf s karena mengambil 1 data
        if (!$book){
            return response()->json([
                'sucess'=>false,
                'message'=>'Resource Not Found'
            ], 404);
        }
        return response()->json([
            'success'=>true,
            'message'=>'Get Detail Resource',
            'data'=>$book
        ], 200);
    }

    // UPDATE 
    public function update(string $id, Request $request){
        // 1. Mencari Data
        $book = Book::find($id);
        if(!$book){
            return response()->json([
                'success'=>false,
                'message'=>'Resource Not Found'
            ]);
        }
        // 2. Validasi
         $validator = Validator::make($request ->all(), [
            'title' => 'required|string|max:100', // jangan pakai spasi
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'cover_photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // Nullable supaya mengantisipasi apabila kondisi updatenya tidak selalu mengganti gambar
            'genre_id' => 'required|exists:genres,id',
            'author_id' => 'required|exists:authors,id'
        ]);
        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. Siapkan Data Yang Ingin diUpdate
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'genre_id' => $request->genre_id,
            'author_id' => $request->author_id
            // Cover Photo bisa tidak dimasukkan supaya data lama tidak perlu diubah
        ];

        // 4. Handle Image (upload & delete)
        //Jika ingin mengganti maka akan di cek jika ada maka akan disimpan dalam storage folder books (public)
        if ($request->hasFile('cover_photo')){
            $image = $request->file('cover_photo');
            $image->store('books','public');
            // Lalu file yang lama akan dihapus dari folder books dan nama filenya
            if ($book->cover_photo){
              Storage::disk('public')->delete('books/' . $book->cover_photo); 
        }
        // Akan menambahkan array baru ke variabel data (diappend)
        $data['cover_photo'] = $image->hashName();
        }
        
        // 5. Update Data Baru ke Database
        $book->update($data);

          return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully!',
            'data' => $book
        ], 200);
    }

    // DESTROY
    public function destroy(string $id){
        $book = Book::find($id);
         if (!$book){
            return response()->json([
                'sucess'=>false,
                'message'=>'Resource Not Found'
            ], 404);
        }

        // Supaya menghapus file gambar
        if ($book->cover_photo){
            // delete from storage
            // Jangan lupa import class Storage (facades)
            Storage::disk('public')->delete('books/' . $book->cover_photo);
        }
        $book->delete();
        
        return response()->json([
            'success'=>true,
            'message'=>'Delete Resource Successfully'
        ]);
    }

}
