<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('whatsapp_instances', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // لو عندك users
        $table->string('instance_id');
        $table->string('status')->default('pending'); // pending / connected / disconnected
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_instances');
    }
};
