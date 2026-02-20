<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'service_name',
        'link',
        'quantity',
        'smm_order_id',
        'start_count',
        'remains',
        'price',
        'currency',
        'status',
        'error_log',
        'refill_available',
        'cancel_available',
        'last_refill_id',
        'last_refill_status',
        'refunded_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    protected $casts = [
        'refill_available' => 'boolean',
        'cancel_available' => 'boolean',
        'error_log' => 'array',
    ];
}
