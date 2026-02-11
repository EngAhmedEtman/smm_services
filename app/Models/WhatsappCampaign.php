<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instance_id',
        'whatsapp_contact_id',
        'whatsapp_message_id', // Nullable
        'campaign_name',
        'message',
        'media_path',
        'min_delay',
        'max_delay',
        'status',
        'total_numbers',
        'sent_count',
        'failed_count',
        'last_sent_at',
    ];

    protected $casts = [
        'message' => 'array',
        'last_sent_at' => 'datetime',
    ];

    public function contact()
    {
        return $this->belongsTo(WhatsappContact::class, 'whatsapp_contact_id');
    }

    public function whatsappMessage()
    {
        return $this->belongsTo(WhatsappMessage::class, 'whatsapp_message_id');
    }

    public function logs()
    {
        return $this->hasMany(WhatsappCampaignLog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
