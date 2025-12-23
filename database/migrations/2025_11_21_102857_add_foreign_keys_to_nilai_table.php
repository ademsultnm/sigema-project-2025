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
        Schema::table('nilai', function (Blueprint $table) {
            $table->foreign(['guru_id'], 'fk_nilai_guru')->references(['id'])->on('guru')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['kelas_id'], 'fk_nilai_kelas')->references(['id'])->on('kelas')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['mata_pelajaran_id'], 'fk_nilai_mapel')->references(['id'])->on('mata_pelajaran')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['siswa_id'], 'fk_nilai_siswa')->references(['id'])->on('siswa')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropForeign('fk_nilai_guru');
            $table->dropForeign('fk_nilai_kelas');
            $table->dropForeign('fk_nilai_mapel');
            $table->dropForeign('fk_nilai_siswa');
        });
    }
};
