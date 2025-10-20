<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        // 1. Setup Validator
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8'
        ]);

        // 2. Check Validator (Untuk Role dibuat supaya user otomatis mendapatkan customer bukan admin)
        if ($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        // 3. Create User
        $user = User::create([ // Jangan lupa import User atau Modelnya
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => bcrypt($request -> password)
        ]);

        // 4. Cek Keberhasilan
        if ($user){
            return response()->json([
                'success'=> true,
                'message' => 'User Created Successfully',
                'data'=> $user
            ], 201);
        }

        // 5. Cek Kegalalan
        return response()->json([
            'success' => false,
            'message' => 'User Creation Failed',   
        ], 409); // Conflict
    }

    // Login
    public function login(Request $request) { // Untuk method POST
        // 1. Setup Validator
        $validator = Validator::make($request->all(), [
            // Biasanya kalau login menggunakan email dan password
            'email' => 'required|email',
            'password' => 'required' //tidak usah pakai min, karena itu untuk register
        ]);  

        // 2. Cek Validator
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 3. Get Kredensial dari request
        $credentials = $request->only('email', 'password');

        // 4. Cek isFailed
        if (!$token = auth()->guard('api')->attempt($credentials)){ // ini dari config bagian auth
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda Salah!'
            ], 401);
        }

        // 5. Cek isSuccess
        return response()->json([
            'success' => true,
            'message' => 'Login Successfully!',
            'user' => auth()->guard('api')->user(),
            'token'=> $token,
        ], 200);
    }
     public function logout(Request $request) {
        // try 
        // 1. Invalidate Token (Supaya token tidak dapat digunakan kembali)
        // 2. Cek isSuccess
        // catch (jika gagal)
        // 1. Cek isFailed
        try {
            JWTAuth::invalidate(JWTAuth::getToken()); // Jangan lupa import class JWTAuth-nya
            return response()->json([
                'success' => true,
                'message' => 'Logout Successfully!'
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout Failed!'
            ], 500);
        }

    }


}
