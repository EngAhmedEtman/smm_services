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
        Schema::create('whatsapp_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('instance_id'); // From which instance we are sending
            $table->foreignId('whatsapp_contact_id')->constrained('whatsapp_contacts'); // Target Group
            $table->string('campaign_name');
            $table->text('message');
            $table->string('media_path')->nullable();
            $table->integer('min_delay')->default(5);
            $table->integer('max_delay')->default(10);
            $table->enum('status', ['pending', 'processing', 'completed', 'paused', 'failed'])->default('pending');
            $table->integer('total_numbers')->default(0);
            $table->integer('sent_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_campaigns');
    }
};
