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
        if (Schema::hasTable('whatsapp_random_texts') && !Schema::hasColumn('whatsapp_random_texts', 'user_id')) {
            Schema::table('whatsapp_random_texts', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            });
        }

        if (Schema::hasTable('whatsapp_welcome_texts') && !Schema::hasColumn('whatsapp_welcome_texts', 'user_id')) {
            Schema::table('whatsapp_welcome_texts', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('whatsapp_random_texts', 'user_id')) {
            Schema::table('whatsapp_random_texts', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }

        if (Schema::hasColumn('whatsapp_welcome_texts', 'user_id')) {
            Schema::table('whatsapp_welcome_texts', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }
    }
};
