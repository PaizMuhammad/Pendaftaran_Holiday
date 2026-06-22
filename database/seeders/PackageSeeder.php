<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Package;

class PackageSeeder extends Seeder
{
  public function run()
{
    $fasilitas = "- Perlengkapan Ibadah\n- Visa Umroh\n- Akomodasi & Hotel\n- Air Zam-zam 5L\n- Driver / Transportasi\n- Makan 3x Sehari\n- Muthawwif";

    $packages = [
        [
            'nama_paket' => 'Umroh Reguler 9 Hari',
            'kategori' => 'umroh',
            'durasi' => 9,
            'harga' => 25000000,
            'fasilitas' => $fasilitas,
            'jarak_hotel' => '100-300m',
            'kuota' => 20
        ],
        [
            'nama_paket' => 'Umroh Khidmat 13 Hari',
            'kategori' => 'umroh',
            'durasi' => 13,
            'harga' => 32000000,
            'fasilitas' => $fasilitas,
            'jarak_hotel' => '100-150m',
            'kuota' => 15
        ],
    ];

    foreach ($packages as $p) {
        Package::create($p);
    }
}
}