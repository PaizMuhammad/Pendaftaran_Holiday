<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JemaahController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KloterController;
use App\Models\Jemaah;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes - Holiday Angkasa
|--------------------------------------------------------------------------
*/

// 1. Rute Public
Route::get('/', function () {
    return view('welcome');
});

// 2. Rute Guest
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 3. Rute Khusus User / Jemaah
Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/dashboard', [JemaahController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/pendaftaran/{kategori}', [JemaahController::class, 'create'])->name('pendaftaran.form');
    
    Route::get('/pendaftaran', function() {
        return redirect()->route('pendaftaran.form', ['kategori' => 'umroh']);
    });

    Route::post('/pendaftaran/store', [JemaahController::class, 'store'])->name('pendaftaran.store');

    // 👑 REVISI DOSEN SINKRON: Nama rute disamakan dengan tombol dashboard agar tidak error lagi
    Route::get('/info-keberangkatan', [KloterController::class, 'infoJemaah'])->name('user.info-keberangkatan');
});

// 4. Rute Khusus Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/verify/{id}', [AdminController::class, 'verify'])->name('admin.verify');
    Route::post('/update-status/{id}', [AdminController::class, 'updateStatus'])->name('admin.update_status');

    // REVISI DOSEN: Rute Manajemen Kloter Umrah (Grouping Jemaah)
    Route::get('/kloter', [KloterController::class, 'index'])->name('admin.kloter.index');
    Route::post('/kloter', [KloterController::class, 'store'])->name('admin.kloter.store');
    Route::get('/kloter/{id}/jemaah', [KloterController::class, 'kelolaJemaah'])->name('admin.kloter.jemaah');
    Route::post('/kloter/{id}/gabung', [KloterController::class, 'gabungkanJemaah'])->name('admin.kloter.gabung');
    Route::post('/jemaah/{id}/keluar', [KloterController::class, 'keluarkanJemaah'])->name('admin.jemaah.keluar');
});

// 5. RUTE SAKTI FINAL: Solusi 403 & 404
Route::get('/lihat-dokumen/{filename}', function ($filename) {
    // 1. Bersihkan path dari karakter aneh
    $cleanFilename = str_replace(['../', './'], '', $filename);

    // 2. Cari di dua lokasi (dengan 'dokumen/' atau tanpa 'dokumen/')
    $path1 = storage_path('app/public/dokumen/' . $cleanFilename);
    $path2 = storage_path('app/public/' . $cleanFilename);

    if (file_exists($path1)) {
        return response()->file($path1);
    } elseif (file_exists($path2)) {
        return response()->file($path2);
    }

    // Jika gagal, tampilkan info debug agar kita tahu path aslinya
    abort(404, "File tidak ada. Mencari di: " . $path1 . " | Nama di DB: " . $filename);
})->where('filename', '.*')->name('view.document')->middleware('auth');


// =========================================================================
// 6. RUTE KHUSUS TES API VIA POSTMAN (BEBAS LOCK/TANPA LOGIN)
// =========================================================================
Route::get('/tes-pendaftar-json', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Berhasil tersambung ke API Web Holiday Angkasa!',
        'data' => Jemaah::all()
    ], 200);
});