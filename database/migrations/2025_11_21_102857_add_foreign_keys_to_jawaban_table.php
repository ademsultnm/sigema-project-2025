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
        Schema::table('jawaban', function (Blueprint $table) {
            $table->foreign(['soal_id'])->references(['id'])->on('soal')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jawaban', function (Blueprint $table) {
            $table->dropForeign('jawaban_soal_id_foreign');
        });
    }
};
