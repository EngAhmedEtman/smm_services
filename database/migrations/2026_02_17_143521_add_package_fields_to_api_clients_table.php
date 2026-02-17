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
        Schema::table('api_clients', function (Blueprint $table) {
            $table->string('package_name')->nullable()->after('balance');
            $table->enum('package_status', ['active', 'expired', 'cancelled'])
                ->default('expired')->after('package_name');
            $table->timestamp('expire_at')->nullable()->after('package_status');
            $table->timestamp('last_notification_sent')->nullable()->after('expire_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('api_clients', function (Blueprint $table) {
            $table->dropColumn(['package_name', 'package_status', 'expire_at', 'last_notification_sent']);
        });
    }
};
