<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsAppPackage extends Model
{
    protected $table = 'whatsapp_packages';

    protected $fillable = [
        'name',
        'message_limit',
        'price',
        'duration_days',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // فقط الباقات الفعالة
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
