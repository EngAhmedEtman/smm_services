<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsAppUsageLog extends Model
{
    protected $table = 'whatsapp_usage_logs';

    public $timestamps = false;

    protected $fillable = [
        'api_client_id',
        'messages_count',
        'endpoint',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function apiClient()
    {
        return $this->belongsTo(ApiClient::class);
    }
}
