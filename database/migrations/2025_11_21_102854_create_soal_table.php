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
        Schema::create('soal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('guru_id')->index('soal_guru_id_foreign');
            $table->unsignedBigInteger('mata_pelajaran_id')->index('soal_mata_pelajaran_id_foreign');
            $table->enum('jenis_soal', ['essay', 'pilihan_ganda']);
            $table->text('pertanyaan');
            $table->enum('jenjang', ['SMP', 'SMA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal');
    }
};
