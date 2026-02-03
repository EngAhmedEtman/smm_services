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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('smm_order_id')->nullable();
            $table->integer('service_id');
            $table->string('link');
            $table->integer('quantity');
            $table->integer('start_count')->nullable();
            $table->integer('remains')->nullable();
            $table->decimal('price', 10, 4)->nullable();
            $table->string('currency')->default('USD');
            $table->string('status')->default('pending'); // pending, completed, cancelled
            $table->text('error_log')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
