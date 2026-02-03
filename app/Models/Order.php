<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'link',
        'quantity',
        'smm_order_id',
        'start_count',
        'remains',
        'price',
        'currency',
        'status',
        'error_log',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
