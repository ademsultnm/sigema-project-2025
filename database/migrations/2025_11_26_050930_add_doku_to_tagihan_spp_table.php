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
        Schema::table('tagihan_spp', function (Blueprint $table) {
            $table->string('payment_status')->default('pending')->after('status');
            $table->string('external_id')->nullable()->after('payment_status');
            $table->string('payment_channel')->nullable()->after('external_id');
            $table->timestamp('payment_date')->nullable()->after('payment_channel');
            $table->json('raw_callback')->nullable()->after('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tagihan_spp', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'external_id',
                'payment_channel',
                'payment_date',
                'raw_callback',
            ]);
        });
    }
};
