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
        Schema::table('absensi_guru', function (Blueprint $table) {
            $table->foreign(['guru_id'])->references(['id'])->on('guru')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi_guru', function (Blueprint $table) {
            $table->dropForeign('absensi_guru_guru_id_foreign');
        });
    }
};
