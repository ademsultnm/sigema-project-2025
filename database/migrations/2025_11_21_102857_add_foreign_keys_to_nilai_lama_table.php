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
        Schema::table('nilai_lama', function (Blueprint $table) {
            $table->foreign(['mata_pelajaran_id'], 'nilai_mata_pelajaran_id_foreign')->references(['id'])->on('mata_pelajaran')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['siswa_id'], 'nilai_siswa_id_foreign')->references(['id'])->on('siswa')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_lama', function (Blueprint $table) {
            $table->dropForeign('nilai_mata_pelajaran_id_foreign');
            $table->dropForeign('nilai_siswa_id_foreign');
        });
    }
};
