<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // LANGSUNG BUAT TOKEN BIAR AUTO-LOGIN
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'User created successfully',
        'access_token' => $token, // Ini ditangkap JS untuk Auto Login
        'token_type' => 'Bearer',
        'user' => $user
    ]);
    }

    // 2. LOGIN
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Login details are invalid'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        // BUAT TOKEN BARU
        $token = $user->createToken('auth_token')->plainTextToken;

        // KEMBALIKAN TOKEN KE FRONTEND
        return response()->json([
            'message' => 'Hi ' . $user->name,
            'access_token' => $token, // Bisa pakai access_token
            'token_type' => 'Bearer',
            'token' => $token, // SAYA TAMBAHKAN INI BIAR JS DI ATAS JALAN
        ]);
    }

    // 3. ME (Cek Profil Sendiri - Butuh Token)
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    // 4. LOGOUT (Hapus Sesi - Butuh Token)
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    // Helper Respon Token
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'user' => Auth::guard('api')->user()
        ]);
    }
}
