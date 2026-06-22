<?php

namespace App\Http\Controllers;

use App\Models\Jemaah;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan form pendaftaran
     */
    public function create($kategori) {
        // Ambil paket berdasarkan kategori (haji/umroh) agar user bisa pilih durasi
        $packages = Paket::where('kategori', $kategori)->get();
        
        return view('user.form_daftar', compact('kategori', 'packages'));
    }

    /**
     * Menampilkan riwayat pendaftaran di Dashboard User
     */
    public function index() {
        $userId = Auth::id(); 
        // Menggunakan model Jemaah dan eager load relasi package
        $riwayat = Jemaah::with('package')->where('user_id', $userId)->latest()->get();
        
        return view('user.dashboard', compact('riwayat'));
    }

    /**
     * Proses simpan pendaftaran
     */
    public function store(Request $request) {
        // 1. Validasi Input
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'kategori' => 'required',
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|numeric',
            'nomor_hp' => 'required',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Siapkan data awal
        $data = [
            'user_id' => Auth::id(),
            'package_id' => $request->package_id,
            'kategori' => $request->kategori,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'nomor_hp' => $request->nomor_hp,
            'status' => 'Pending'
        ];

        // 2. Logika Upload Foto KTP
        if ($request->hasFile('foto_ktp')) {
            $pathKtp = $request->file('foto_ktp')->store('dokumen', 'public');
            $data['foto_ktp'] = $pathKtp;
        }

        // 3. Logika Upload Foto KK
        if ($request->hasFile('foto_kk')) {
            $pathKk = $request->file('foto_kk')->store('dokumen', 'public');
            $data['foto_kk'] = $pathKk;
        }

        // 4. Simpan ke Database menggunakan model Pilgrim
        $pendaftaran = Jemaah::create($data);

        // Respon untuk Postman / API
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran berhasil disimpan!',
                'data' => $pendaftaran
            ], 201);
        }

        return redirect()->route('user.dashboard')->with('success', 'Pendaftaran Berhasil! Admin akan segera memverifikasi dokumen Anda.');
    }
}