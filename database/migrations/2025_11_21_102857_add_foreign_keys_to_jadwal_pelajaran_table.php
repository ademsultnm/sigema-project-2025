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
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->foreign(['guru_id'], 'jadwal_guru_id_foreign')->references(['id'])->on('guru')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['kelas_id'], 'jadwal_kelas_id_foreign')->references(['id'])->on('kelas')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['mata_pelajaran_id'], 'jadwal_matapelajaran_id_foreign')->references(['id'])->on('mata_pelajaran')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->dropForeign('jadwal_guru_id_foreign');
            $table->dropForeign('jadwal_kelas_id_foreign');
            $table->dropForeign('jadwal_matapelajaran_id_foreign');
        });
    }
};
