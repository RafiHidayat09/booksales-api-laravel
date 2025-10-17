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
      // SHOW
    public function show(string $id){
        $genre = Genre::find($id); //tidak pakai huruf s karena mengambil 1 data
        if (!$genre){
            return response()->json([
                'sucess'=>false,
                'message'=>'Resource Not Found'
            ], 404);
        }
        return response()->json([
            'success'=>true,
            'message'=>'Get Detail Resource',
            'data'=>$genre
        ], 200);
    }

    // UPDATE 
    public function update(string $id, Request $request){
        // 1. Mencari Data
        $genre = Genre::find($id);
        if(!$genre){
            return response()->json([
                'success'=>false,
                'message'=>'Resource Not Found'
            ]);
        }
        // 2. Validasi
         $validator = Validator::make($request ->all(), [
            'name' => 'required|string|max:100', // jangan pakai spasi
            'description' => 'required|string'
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
            'description' => $request->description
        ];

        // 4. Update Data Baru ke Database
        $genre->update($data);

          return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully!',
            'data' => $genre
        ], 200);
    }

     // DESTROY
    public function destroy(string $id){
        $genre = Genre::find($id);
         if (!$genre){
            return response()->json([
                'sucess'=>false,
                'message'=>'Resource Not Found'
            ], 404);
        }

        $genre->delete();
        
        return response()->json([
            'success'=>true,
            'message'=>'Delete Resource Successfully'
        ]);
    }


}
