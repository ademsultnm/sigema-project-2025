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
        Schema::create('absensi_guru', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('guru_id')->index('absensi_guru_guru_id_foreign');
            $table->date('tanggal');
            $table->enum('kehadiran', ['hadir', 'tidak_hadir', 'izin']);
            $table->enum('jenjang', ['SMP', 'SMA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_guru');
    }
};
