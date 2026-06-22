<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranApiController extends Controller
{
    // API untuk melihat riwayat pendaftaran
    public function index()
    {
        $riwayat = Pendaftaran::where('user_id', Auth::id())->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar riwayat pendaftaran jemaah',
            'data'    => $riwayat
        ], 200);
    }

    // API untuk mendaftar (Haji/Umrah)
    public function store(Request $request)
    {
        $pendaftaran = Pendaftaran::create([
            'user_id'      => Auth::id(),
            'kategori'     => $request->kategori,
            'nama_lengkap' => $request->nama_lengkap,
            'nik'          => $request->nik,
            'nomor_hp'     => $request->nomor_hp,
            'status'       => 'Pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil dikirim melalui API',
            'data'    => $pendaftaran
        ], 201);
    }
}
