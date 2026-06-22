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
            // Kita paksa ubah tipe data kolom maskapai menjadi VARCHAR (string) agar bisa menampung teks biasa
            $table->string('maskapai', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kloters', function (Blueprint $table) {
            $table->date('maskapai')->nullable()->change();
        });
    }
};