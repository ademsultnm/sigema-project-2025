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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('username')->nullable()->unique();
            $table->enum('role', ['admin', 'Guru', 'Staf', 'Murid', 'Orang Tua', 'Alumni', 'Guest', 'Super Admin', 'Kepala Sekolah', 'Staf Keuangan', 'Waka Kurikulum'])->default('Murid');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->nullable()->default('Aktif');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('guru_id')->nullable()->index('users_guru_id_foreign');
            $table->unsignedBigInteger('siswa_id')->nullable()->index('users_siswa_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
