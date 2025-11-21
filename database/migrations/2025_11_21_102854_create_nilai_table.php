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
        Schema::create('nilai', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('siswa_id')->index('fk_nilai_siswa');
            $table->unsignedBigInteger('kelas_id')->index('fk_nilai_kelas');
            $table->unsignedBigInteger('mata_pelajaran_id')->index('fk_nilai_mapel');
            $table->unsignedBigInteger('guru_id')->index('fk_nilai_guru')->comment('Guru yang memberikan nilai');
            $table->enum('tipe_nilai', ['Tugas', 'Ulangan Harian', 'UTS', 'UAS']);
            $table->string('deskripsi')->comment('Contoh: Tugas 1, Ulangan Bab 2');
            $table->decimal('nilai', 5);
            $table->date('tanggal_penilaian');
            $table->string('tahun_ajaran', 9);
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
