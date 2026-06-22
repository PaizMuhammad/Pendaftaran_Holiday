<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pilgrims', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('package_id')->constrained()->onDelete('cascade');
        $table->string('nama_lengkap'); // <--- PASTIKAN BARIS INI ADA
        $table->string('nik');
        $table->string('nomor_hp');
        $table->enum('kategori', ['haji', 'umroh']);
        $table->string('status')->default('Pending');
        $table->string('foto_ktp')->nullable();
        $table->string('foto_kk')->nullable();
        
        // Kolom ceklis administrasi yang kita buat sebelumnya
        $table->boolean('is_paspor_received')->default(false);
        $table->boolean('is_buku_nikah_received')->default(false);
        $table->boolean('is_vaksin_received')->default(false);
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilgrims');
    }
};
