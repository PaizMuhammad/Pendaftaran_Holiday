<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kloters', function (Blueprint $table) {
            // Cek dan tambah kolom 'tanggal_keberangkatan' jika belum ada
            if (!Schema::hasColumn('kloters', 'tanggal_keberangkatan')) {
                $table->date('tanggal_keberangkatan')->nullable()->after('nama_kloter');
            }
            
            // Cek dan tambah kolom 'maskapai' jika belum ada
            if (!Schema::hasColumn('kloters', 'maskapai')) {
                $table->string('maskapai')->nullable()->after('tanggal_keberangkatan');
            }
            
            // Cek dan tambah kolom 'jam_keberangkatan' jika belum ada
            if (!Schema::hasColumn('kloters', 'jam_keberangkatan')) {
                $table->time('jam_keberangkatan')->nullable()->after('maskapai');
            }
            
            // Cek dan tambah kolom 'lama_keberangkatan' jika belum ada
            if (!Schema::hasColumn('kloters', 'lama_keberangkatan')) {
                $table->string('lama_keberangkatan')->nullable()->after('jam_keberangkatan');
            }
            
            // Cek dan tambah kolom 'fasilitas' jika belum ada
            if (!Schema::hasColumn('kloters', 'fasilitas')) {
                $table->text('fasilitas')->nullable()->after('lama_keberangkatan');
            }
            
            // Cek dan tambah kolom 'rundown' jika belum ada
            if (!Schema::hasColumn('kloters', 'rundown')) {
                $table->text('rundown')->nullable()->after('fasilitas');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kloters', function (Blueprint $table) {
            // Hapus kolom hanya jika kolom tersebut ada di database
            $columnsToDrop = [];
            
            foreach (['tanggal_keberangkatan', 'maskapai', 'jam_keberangkatan', 'lama_keberangkatan', 'fasilitas', 'rundown'] as $col) {
                if (Schema::hasColumn('kloters', $col)) {
                    $columnsToDrop[] = $col;
                }
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};