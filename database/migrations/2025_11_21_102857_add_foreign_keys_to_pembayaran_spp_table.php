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
        Schema::table('pembayaran_spp', function (Blueprint $table) {
            $table->foreign(['siswa_id'], 'pembayaran_siswa_id_foreign')->references(['id'])->on('siswa')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tagihan_id'], 'pembayaran_tagihan_id_foreign')->references(['id'])->on('tagihan_spp')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['verifikator_id'], 'pembayaran_verifikator_id_foreign')->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran_spp', function (Blueprint $table) {
            $table->dropForeign('pembayaran_siswa_id_foreign');
            $table->dropForeign('pembayaran_tagihan_id_foreign');
            $table->dropForeign('pembayaran_verifikator_id_foreign');
        });
    }
};
