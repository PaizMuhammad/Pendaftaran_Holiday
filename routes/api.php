<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use App\Models\User;

// 1. Endpoint Login (Bisa diakses siapa saja/Public)
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('holiday_token')->plainTextToken;

        return response()->json([
            'message' => 'Login Berhasil!',
            'token' => $token,
            'user' => $user
        ]);
    }

    return response()->json(['message' => 'Login Gagal'], 401);
});

// 2. Endpoint Terproteksi (Harus pakai Token)
Route::middleware('auth:sanctum')->group(function () {
    
    // Lihat Riwayat Jemaah
    Route::get('/riwayat', function () {
        return Pendaftaran::where('user_id', Auth::id())->get();
    });

    // Kirim Pendaftaran
    Route::post('/daftar', function (Request $request) {
        $request->validate([
            'kategori' => 'required|in:Haji,Umrah',
            'nama_lengkap' => 'required|string',
            'nik' => 'required|string|size:16',
            'nomor_hp' => 'required|string'
        ]);
        
        $data = Pendaftaran::create([
            'user_id' => Auth::id(),
            'kategori' => $request->kategori,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'nomor_hp' => $request->nomor_hp,
            'status' => 'Pending'
        ]);
        
        return response()->json(['message' => 'Berhasil Daftar!', 'data' => $data]);
    });

    // 3. Endpoint Logout (Taruh di SINI agar sistem tahu token mana yang dihapus)
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout Berhasil']);
    });

});
