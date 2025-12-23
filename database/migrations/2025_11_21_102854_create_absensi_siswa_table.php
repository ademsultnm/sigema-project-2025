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
        Schema::create('absensi_siswa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('siswa_id')->index('absensi_siswa_siswa_id_foreign');
            $table->unsignedBigInteger('kelas_id')->nullable()->index('fk_absensi_kelas');
            $table->date('tanggal');
            $table->enum('kehadiran', ['hadir', 'tidak_hadir', 'izin', 'sakit']);
            $table->enum('jenjang', ['SMP', 'SMA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_siswa');
    }
};
