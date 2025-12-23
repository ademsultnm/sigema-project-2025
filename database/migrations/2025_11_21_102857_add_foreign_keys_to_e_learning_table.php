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
        Schema::table('e_learning', function (Blueprint $table) {
            $table->foreign(['guru_id'])->references(['id'])->on('guru')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['mata_pelajaran_id'])->references(['id'])->on('mata_pelajaran')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('e_learning', function (Blueprint $table) {
            $table->dropForeign('e_learning_guru_id_foreign');
            $table->dropForeign('e_learning_mata_pelajaran_id_foreign');
        });
    }
};
