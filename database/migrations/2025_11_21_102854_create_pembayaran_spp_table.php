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
        Schema::create('pembayaran_spp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tagihan_id')->index('pembayaran_tagihan_id_foreign');
            $table->unsignedBigInteger('siswa_id')->index('pembayaran_siswa_id_foreign');
            $table->decimal('jumlah_bayar', 10);
            $table->dateTime('tanggal_bayar');
            $table->enum('metode_pembayaran', ['Virtual Account', 'Tunai', 'Transfer Bank']);
            $table->string('bukti_pembayaran')->nullable()->comment('Path ke file bukti transfer');
            $table->string('kode_referensi')->nullable()->comment('Nomor VA atau kode unik transaksi');
            $table->enum('status_verifikasi', ['Pending', 'Terverifikasi', 'Ditolak'])->default('Pending');
            $table->unsignedBigInteger('verifikator_id')->nullable()->index('pembayaran_verifikator_id_foreign')->comment('ID user (staf keuangan) yang memverifikasi');
            $table->text('catatan')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_spp');
    }
};
