<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappCampaignLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'whatsapp_campaign_id',
        'phone_number',
        'status',
        'message_id',
        'error_message',
    ];

    public function campaign()
    {
        return $this->belongsTo(WhatsappCampaign::class, 'whatsapp_campaign_id');
    }
}
