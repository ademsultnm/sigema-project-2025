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
        Schema::create('nilai_lama', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('siswa_id')->index('nilai_siswa_id_foreign');
            $table->unsignedBigInteger('mata_pelajaran_id')->index('nilai_mata_pelajaran_id_foreign');
            $table->decimal('nilai_ulangan_harian', 5)->nullable();
            $table->decimal('nilai_ujian_tengah_semester', 5)->nullable();
            $table->decimal('nilai_ujian_akhir_semester', 5)->nullable();
            $table->enum('sumber_nilai', ['e-learning', 'manual']);
            $table->enum('jenjang', ['SMP', 'SMA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_lama');
    }
};
