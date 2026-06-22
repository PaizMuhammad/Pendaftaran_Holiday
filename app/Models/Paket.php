<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'pakets';
    
    protected $fillable = [
        'nama_paket', 'kategori', 'maskapai', 'hotel_mekkah', 
        'hotel_madinah', 'harga_idr', 'harga_usd', 
        'kuota_maksimal', 'kuota_terisi', 'tanggal_keberangkatan'
    ];
}