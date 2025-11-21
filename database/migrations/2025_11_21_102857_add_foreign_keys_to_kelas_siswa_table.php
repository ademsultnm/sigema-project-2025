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
        Schema::table('kelas_siswa', function (Blueprint $table) {
            $table->foreign(['kelas_id'])->references(['id'])->on('kelas')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['siswa_id'])->references(['id'])->on('siswa')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas_siswa', function (Blueprint $table) {
            $table->dropForeign('kelas_siswa_kelas_id_foreign');
            $table->dropForeign('kelas_siswa_siswa_id_foreign');
        });
    }
};
