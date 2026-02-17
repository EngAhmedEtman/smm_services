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
        Schema::create('whatsapp_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الباقة
            $table->integer('message_limit'); // عدد الرسائل
            $table->decimal('price', 10, 2); // السعر
            $table->integer('duration_days')->default(30); // المدة بالأيام
            $table->boolean('is_active')->default(true); // فعالة أم لا
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_packages');
    }
};
