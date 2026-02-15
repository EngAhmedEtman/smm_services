<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_clients', function (Blueprint $table) {
            $table->id();
            // ربط العميل بجدول المستخدمين الأساسي
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // الـ API Key فريد وطوله 64 حرف
            $table->string('api_key', 64)->unique(); 
            
            // الـ Instance ID الخاص بمزود الخدمة (ممكن يكون Null في البداية لحد ما يتكريت)
            $table->string('instance_id')->nullable(); 
            
            // الرصيد (ممكن تخليه integer لو بتخصم نقط صحيحة، أو decimal لو فلوس)
            $table->decimal('balance', 10, 2)->default(0.00); 
            
            // حالة العميل (شغال ولا موقوف)
            $table->boolean('status')->default(true); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_clients');
    }
};
