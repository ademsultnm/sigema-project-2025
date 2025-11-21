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
        Schema::table('raport', function (Blueprint $table) {
            $table->foreign(['siswa_id'])->references(['id'])->on('siswa')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raport', function (Blueprint $table) {
            $table->dropForeign('raport_siswa_id_foreign');
        });
    }
};
