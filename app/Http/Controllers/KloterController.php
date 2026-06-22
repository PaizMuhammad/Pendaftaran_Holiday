<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kloter;
use App\Models\Jemaah;

class KloterController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen kloter (Admin)
     */
    public function index()
    {
        $kloters = Kloter::all()->map(function ($kloter) {
            $kloter->jemaahs_count = Jemaah::where('kloter_id', $kloter->id)->count();
            return $kloter;
        });

        return view('admin.kloter.index', compact('kloters'));
    }

    /**
     * Menyimpan data kloter baru yang diinput oleh Admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kloter' => 'required|string|max:255',
            'tanggal_keberangkatan' => 'required|date',
            'maskapai' => 'required|string|max:255',
            'jam_keberangkatan' => 'required',
            'lama_keberangkatan' => 'required|string',
            'fasilitas' => 'required|string',
            'rundown' => 'required|string',
        ]);

        Kloter::create([
            // Kolom Baru
            'nama_kloter' => $request->nama_kloter,
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'maskapai' => $request->maskapai,
            'jam_keberangkatan' => $request->jam_keberangkatan,
            'lama_keberangkatan' => $request->lama_keberangkatan,
            'fasilitas' => $request->fasilitas,
            'rundown' => $request->rundown,

            // SINKRONISASI KOLOM LAMA (Yang terbukti ada di database kamu)
            'tanggal_berangkat' => $request->tanggal_keberangkatan, 
            'jam_berangkat' => $request->jam_keberangkatan, 
            'lama_perjalanan' => $request->lama_keberangkatan,
        ]);

        return redirect()->route('admin.kloter.index')->with('success', 'Kloter baru berhasil dibuat!');
    }

    /**
     * Menampilkan halaman kelola anggota jemaah berdasarkan ID Kloter
     */
   public function kelolaJemaah($id)
    {
        $kloter = Kloter::findOrFail($id);
        
        // Ambil jemaah yang sudah masuk ke kloter ini beserta data paketnya
        $jemaahKloter = Jemaah::with('package')->where('kloter_id', $id)->get();
        
        // Ambil jemaah yang "Verified" tapi BELUM punya kloter (Siap di-plot)
        // Kita sertakan 'package' juga biar ketahuan mereka ambil paket apa
        $jemaahSedia = Jemaah::with('package')
                            ->where('status', 'Verified')
                            ->where(function($query) {
                                $query->whereNull('kloter_id')
                                      ->orWhere('kloter_id', 0);
                            })->get();

        return view('admin.kloter.kelola_jemaah', compact('kloter', 'jemaahKloter', 'jemaahSedia'));
    }

    /**
     * Memasukkan jemaah secara massal (Checkbox) ke dalam Kloter
     */
    public function gabungkanJemaah(Request $request, $id)
    {
        $request->validate([
            'jemaah_ids' => 'required|array',
            'jemaah_ids.*' => 'exists:jemaahs,id'
        ]);

        Jemaah::whereIn('id', $request->jemaah_ids)->update([
            'kloter_id' => $id
        ]);

        return redirect()->route('admin.kloter.jemaah', $id)->with('success', 'Jemaah berhasil digabungkan ke dalam kloter!');
    }

    /**
     * Mengeluarkan jemaah dari Kloter (Sudah diperbaiki kata '原' yang typo)
     */
    public function keluarkanJemaah($id)
    {
        $jemaah = Jemaah::findOrFail($id);
        $kloterId = $jemaah->kloter_id;

        $jemaah->update([
            'kloter_id' => null
        ]);

        return redirect()->route('admin.kloter.jemaah', $kloterId)->with('success', 'Jemaah berhasil dikeluarkan dari kloter.');
    }

    /**
     * Fitur Jemaah: Melihat info keberangkatan (Sistem Banyak Daftar / 1 KK per Akun)
     */
    public function infoJemaah()
    {
        // 1. Ambil semua jemaah yang didaftarkan oleh user_id yang sedang login dan sudah diberi kloter
        $jemaahList = Jemaah::where('user_id', auth()->id())
                            ->whereNotNull('kloter_id')
                            ->where('kloter_id', '!=', 0)
                            ->get();

        // 2. Jika akun ini belum mendaftarkan siapapun, atau belum ada anggota yang dimasukkan ke kloter
        if ($jemaahList->isEmpty()) {
            return view('user.info_keberangkatan', ['kloter' => null, 'jemaahList' => collect()]);
        }

        // 3. Ambil kloter dari jemaah pertama sebagai acuan detail penerbangan & rundown rombongan
        $firstJemaah = $jemaahList->first();
        $kloter = Kloter::find($firstJemaah->kloter_id);

        return view('user.info_keberangkatan', compact('kloter', 'jemaahList'));
    }
}