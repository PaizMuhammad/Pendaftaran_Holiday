<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftarans';

    protected $fillable = [
        'user_id',
        'kategori',
        'nama_lengkap',
        'nik',
        'nomor_hp',
        'status',
        'foto_ktp', // Tambahan baru
        'foto_kk',  // Tambahan baru
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}