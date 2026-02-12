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
        // Fix whatsapp_random_texts
        if (Schema::hasTable('whatsapp_random_texts')) {
            Schema::table('whatsapp_random_texts', function (Blueprint $table) {
                if (!Schema::hasColumn('whatsapp_random_texts', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('whatsapp_random_texts', 'text')) {
                    $table->text('text')->nullable();
                }
            });
        }

        // Fix whatsapp_welcome_texts
        if (Schema::hasTable('whatsapp_welcome_texts')) {
            Schema::table('whatsapp_welcome_texts', function (Blueprint $table) {
                if (!Schema::hasColumn('whatsapp_welcome_texts', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('whatsapp_welcome_texts', 'text')) {
                    $table->text('text')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('whatsapp_random_texts')) {
            Schema::table('whatsapp_random_texts', function (Blueprint $table) {
                if (Schema::hasColumn('whatsapp_random_texts', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->dropColumn('user_id');
                }
                if (Schema::hasColumn('whatsapp_random_texts', 'text')) {
                    $table->dropColumn('text');
                }
            });
        }

        if (Schema::hasTable('whatsapp_welcome_texts')) {
            Schema::table('whatsapp_welcome_texts', function (Blueprint $table) {
                if (Schema::hasColumn('whatsapp_welcome_texts', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->dropColumn('user_id');
                }
                if (Schema::hasColumn('whatsapp_welcome_texts', 'text')) {
                    $table->dropColumn('text');
                }
            });
        }
    }
};
