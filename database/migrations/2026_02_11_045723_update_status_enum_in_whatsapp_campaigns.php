<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update ENUM to include 'sending' and keep backward compatibility
        DB::statement("ALTER TABLE whatsapp_campaigns MODIFY COLUMN status ENUM('pending', 'processing', 'sending', 'completed', 'paused', 'failed') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE whatsapp_campaigns MODIFY COLUMN status ENUM('pending', 'processing', 'completed', 'paused', 'failed') DEFAULT 'pending'");
    }
};
