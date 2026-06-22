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
    Schema::create('packages', function (Blueprint $table) {
        $table->id();
        $table->string('nama_paket');
        $table->enum('kategori', ['haji', 'umroh']);
        $table->integer('harga'); // <--- PASTIKAN INI ADA
        $table->integer('durasi')->nullable(); // Untuk 9, 11, 13 hari
        $table->text('fasilitas')->nullable();
        $table->string('jarak_hotel')->default('100-300m');
        $table->integer('kuota');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
