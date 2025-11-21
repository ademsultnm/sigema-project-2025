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
        Schema::create('raport', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('siswa_id')->index('raport_siswa_id_foreign');
            $table->string('semester');
            $table->string('tahun_ajaran');
            $table->decimal('rata_rata_nilai', 5);
            $table->string('keterangan');
            $table->enum('jenjang', ['SMP', 'SMA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raport');
    }
};
