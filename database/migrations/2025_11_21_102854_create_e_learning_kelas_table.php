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
        Schema::create('e_learning_kelas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('e_learning_id');
            $table->unsignedBigInteger('kelas_id')->index('fk_elearning_kelas_kelas');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->unique(['e_learning_id', 'kelas_id'], 'e_learning_kelas_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_learning_kelas');
    }
};
