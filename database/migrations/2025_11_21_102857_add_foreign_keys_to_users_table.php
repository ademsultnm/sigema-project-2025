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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign(['guru_id'])->references(['id'])->on('guru')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['siswa_id'])->references(['id'])->on('siswa')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_guru_id_foreign');
            $table->dropForeign('users_siswa_id_foreign');
        });
    }
};
