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
        Schema::create('e_learning', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('guru_id')->index('e_learning_guru_id_foreign');
            $table->unsignedBigInteger('mata_pelajaran_id')->index('e_learning_mata_pelajaran_id_foreign');
            $table->string('judul');
            $table->text('deskripsi');
            $table->mediumText('file_data')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_mime')->nullable();
            $table->enum('jenjang', ['SMP', 'SMA']);
            $table->enum('tipe', ['materi', 'tugas'])->default('materi');
            $table->dateTime('batas_waktu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_learning');
    }
};
