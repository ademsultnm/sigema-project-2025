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
        Schema::table('pengumpulan_tugas', function (Blueprint $table) {
            $table->foreign(['e_learning_id'], 'fk_pengumpulan_elearning')->references(['id'])->on('e_learning')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['siswa_id'], 'fk_pengumpulan_siswa')->references(['id'])->on('siswa')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengumpulan_tugas', function (Blueprint $table) {
            $table->dropForeign('fk_pengumpulan_elearning');
            $table->dropForeign('fk_pengumpulan_siswa');
        });
    }
};
