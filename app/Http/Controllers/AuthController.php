<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // 1. REGISTER (Daftar Akun Baru)
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Opsional: Langsung login setelah register (dapat token)
        $token = Auth::guard('api')->login($user);

        return response()->json([
            'message' => 'Registrasi Berhasil',
            'user' => $user,
            'access_token' => $token
        ], 201);
    }

    // 2. LOGIN
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Email atau Password Salah'], 401);
        }

        return $this->respondWithToken($token);
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
