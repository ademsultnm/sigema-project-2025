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
        Schema::create('tagihan_spp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('siswa_id')->index('tagihan_siswa_id_foreign');
            $table->string('deskripsi')->comment('Contoh: SPP Bulan Oktober 2025');
            $table->decimal('jumlah_tagihan', 10);
            $table->date('jatuh_tempo');
            $table->enum('status', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->string('tahun_ajaran', 9);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_spp');
    }
};
