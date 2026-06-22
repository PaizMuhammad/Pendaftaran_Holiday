<?php

namespace App\Http\Controllers;

use App\Models\Jemaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Menampilkan Dashboard Admin & Daftar Jemaah (Dengan Fitur Cari & Filter)
     */
    public function index(Request $request) {
        // Proteksi Role
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('user.dashboard')->with('error', 'Akses ditolak!');
        }

        // Ambil data dari input search dan filter
        $search = $request->input('search');
        $kategori = $request->input('kategori');

        // Query Jemaah dengan Fitur Pencarian & Filter
        $pilgrims = Jemaah::with(['user', 'package'])
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%");
                });
            })
            ->when($kategori, function ($query, $kategori) {
                return $query->where('kategori', $kategori);
            })
            ->latest()
            ->get();
        
        return view('admin.dashboard', compact('pilgrims', 'search', 'kategori'));
    }

    /**
     * Fungsi Verifikasi Cepat
     */
    public function verify($id) {
        if (Auth::user()->role !== 'admin') { 
            abort(403, 'Tindakan tidak diizinkan.'); 
        }

        $pilgrim = Jemaah::findOrFail($id);
        $pilgrim->status = 'Verified'; 
        $pilgrim->save();

        return redirect()->back()->with('success', 'Pendaftaran ' . $pilgrim->nama_lengkap . ' telah disetujui!');
    }

    /**
     * Update administrasi dokumen fisik
     */
    public function updateStatus(Request $request, $id) {
        if (Auth::user()->role !== 'admin') { 
            abort(403); 
        }

        $pilgrim = Jemaah::findOrFail($id);
        
        $pilgrim->is_paspor_received = $request->has('paspor');
        $pilgrim->is_buku_nikah_received = $request->has('buku_nikah');
        $pilgrim->is_vaksin_received = $request->has('vaksin');

        if ($pilgrim->is_paspor_received && $pilgrim->is_vaksin_received) {
            $pilgrim->status = 'Verified';
        } else {
            $pilgrim->status = $request->status ?? $pilgrim->status;
        }

        $pilgrim->save();
        
        return redirect()->back()->with('success', 'Data administrasi ' . $pilgrim->nama_lengkap . ' berhasil diperbarui!');
    }
}