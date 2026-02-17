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
        Schema::create('category_settings', function (Blueprint $table) {
            $table->id();
            $table->string('original_category_name')->unique(); // The key to map API category
            $table->foreignId('main_category_id')->nullable()->constrained('main_categories')->nullOnDelete();
            $table->string('custom_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_settings');
    }
};
