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
        Schema::table('tagihan_spp', function (Blueprint $table) {
            $table->foreign(['siswa_id'], 'tagihan_siswa_id_foreign')->references(['id'])->on('siswa')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tagihan_spp', function (Blueprint $table) {
            $table->dropForeign('tagihan_siswa_id_foreign');
        });
    }
};
