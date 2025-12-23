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
        Schema::table('e_learning_kelas', function (Blueprint $table) {
            $table->foreign(['e_learning_id'], 'fk_elearning_kelas_elearning')->references(['id'])->on('e_learning')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['kelas_id'], 'fk_elearning_kelas_kelas')->references(['id'])->on('kelas')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('e_learning_kelas', function (Blueprint $table) {
            $table->dropForeign('fk_elearning_kelas_elearning');
            $table->dropForeign('fk_elearning_kelas_kelas');
        });
    }
};
