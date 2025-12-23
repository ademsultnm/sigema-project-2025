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
        Schema::create('pengumpulan_tugas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('e_learning_id')->comment('Merujuk ke tugas di tabel e_learning');
            $table->unsignedBigInteger('siswa_id')->index('fk_pengumpulan_siswa');
            $table->mediumText('file_data')->comment('Data file jawaban dalam format Base64');
            $table->string('file_name');
            $table->string('file_mime');
            $table->dateTime('waktu_pengumpulan')->useCurrent();
            $table->decimal('nilai', 5)->nullable()->comment('Nilai yang diberikan guru untuk tugas ini');
            $table->text('catatan_guru')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->unique(['e_learning_id', 'siswa_id'], 'pengumpulan_tugas_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_tugas');
    }
};
