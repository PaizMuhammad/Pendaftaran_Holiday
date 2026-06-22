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
        Schema::table('jemaahs', function (Blueprint $table) {
            // Menambahkan kolom kloter_id ke tabel jemaahs jika belum ada
            if (!Schema::hasColumn('jemaahs', 'kloter_id')) {
                $table->unsignedBigInteger('kloter_id')->nullable()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jemaahs', function (Blueprint $table) {
            if (Schema::hasColumn('jemaahs', 'kloter_id')) {
                $table->dropColumn('kloter_id');
            }
        });
    }
};