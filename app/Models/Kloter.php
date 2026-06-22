<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kloter extends Model
{
    use HasFactory;

    protected $table = 'kloters';

    protected $fillable = [
        'nama_kloter',
        'tanggal_keberangkatan',
        'tanggal_berangkat',
        'maskapai',
        'jam_keberangkatan',
        'jam_berangkat',
        'lama_keberangkatan',
        'lama_perjalanan',
        'fasilitas',
        'rundown'
    ];

    public function jemaahs()
    {
        return $this->hasMany(Jemaah::class, 'kloter_id');
    }
}