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
        Schema::table('whatsapp_campaigns', function (Blueprint $table) {
            $table->integer('batch_size')->default(0)->after('max_delay');       // 0 = disabled
            $table->integer('batch_sleep')->default(0)->after('batch_size');     // minutes
            $table->integer('batch_sent_count')->default(0)->after('batch_sleep'); // internal counter
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whatsapp_campaigns', function (Blueprint $table) {
            $table->dropColumn(['batch_size', 'batch_sleep', 'batch_sent_count']);
        });
    }
};
