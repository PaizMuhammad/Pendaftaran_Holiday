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
        Schema::create('kloters', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kloter');
            $table->date('tanggal_berangkat');
            $table->date('maskapai');
            $table->string('jam_berangkat');
            $table->string('lama_perjalanan');
            $table->string('fasilitas');
            $table->string('rundown');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kloters');
    }
};
