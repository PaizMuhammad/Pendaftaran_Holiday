<?php

namespace App\Http\Controllers;

use App\Models\Jemaah;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JemaahController extends Controller
{
    /**
     * 1. Menampilkan Halaman Detail & Form Pendaftaran
     */
    public function create(Request $request, $kategori)
    {
        // PERBAIKAN: Mencari paket dengan toleransi penulisan o/a
        $searchKategori = (strtolower($kategori) == 'umrah') ? 'Umroh' : ucfirst($kategori);
        
        $packages = Paket::where('kategori', $searchKategori)->get();

        return view('user.form_pendaftaran', compact('kategori', 'packages'));
    }

    /**
     * 2. Menyimpan Data Pendaftaran
     */
    public function store(Request $request)
    {
        $request->validate([
            'package_id'   => 'nullable', 
            'nama_lengkap' => 'required|string|max:255',
            'nik'          => 'required|numeric',
            'nomor_hp'     => 'required',
            'kategori'     => 'required',
            'foto_ktp'     => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'foto_kk'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $jemaah = new Jemaah();
        $jemaah->user_id = Auth::id();
        
        // PERBAIKAN 1: Jika package_id bernilai "0" atau kosong, simpan sebagai NULL
        // Ini mencegah error SQL "Foreign Key Constraint" atau data invalid
        $jemaah->package_id = ($request->package_id == 0 || empty($request->package_id)) ? null : $request->package_id;

        $jemaah->nama_lengkap = $request->nama_lengkap;
        $jemaah->nik = $request->nik;
        $jemaah->nomor_hp = $request->nomor_hp;

        // PERBAIKAN 2: Konversi "Umrah" kembali menjadi "Umroh" sebelum Save ke DB
        // Agar sesuai dengan batasan ENUM di database kamu
        $kategoriInput = ucfirst(strtolower($request->kategori));
        if ($kategoriInput == 'Umrah') {
            $jemaah->kategori = 'Umroh';
        } else {
            $jemaah->kategori = $kategoriInput;
        }

        $jemaah->status = 'Pending';

        if ($request->hasFile('foto_ktp')) {
            $jemaah->foto_ktp = $request->file('foto_ktp')->store('dokumen', 'public');
        }

        if ($request->hasFile('foto_kk')) {
            $jemaah->foto_kk = $request->file('foto_kk')->store('dokumen', 'public');
        }

        $jemaah->save();

        // Update kuota hanya jika package_id benar-benar ada (bukan 0/null)
        if ($jemaah->package_id) {
            $package = Paket::find($jemaah->package_id);
            if ($package) {
                $package->increment('kuota_terisi'); 
            }
        }

        return redirect()->route('user.dashboard')->with('success', 'Pendaftaran berhasil dikirim!');
    }

    /**
     * 3. Dashboard User
     */
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $riwayat = Jemaah::where('user_id', Auth::id())
                          ->latest()
                          ->get();

        return view('user.dashboard', compact('riwayat'));
    }
}