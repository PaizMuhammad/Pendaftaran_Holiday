<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jemaah extends Model
{
    // 1. Tentukan nama tabel secara manual karena kita sudah ubah di phpMyAdmin
    protected $table = 'jemaahs';

    // 2. Gunakan $fillable (bukan $table) untuk daftar kolom yang bisa diisi
    protected $fillable = [
        'user_id', 
        'package_id', 
        'nama_lengkap', 
        'nik', 
        'nomor_hp', 
        'kategori', 
        'status', 
        'foto_ktp', 
        'foto_kk'
    ];

    /**
     * 3. Hubungkan Jemaah ke Paket (Relasi)
     * Karena model Package juga sudah di-rename jadi Paket, sesuaikan di sini.
     */
    public function package()
    {
        // Pastikan nama class-nya Paket::class kalau sudah di-rename
        return $this->belongsTo(Paket::class, 'package_id');
    }

    /**
     * Hubungkan Jemaah ke User (Login)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hubungkan Jemaah ke Kloter
     */
    public function kloter()
    {
        return $this->belongsTo(Kloter::class, 'kloter_id');
    }
}