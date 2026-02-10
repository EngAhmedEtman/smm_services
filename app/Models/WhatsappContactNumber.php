<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappContactNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'whatsapp_contact_id',
        'phone_number',
    ];

    public function group()
    {
        return $this->belongsTo(WhatsappContact::class, 'whatsapp_contact_id');
    }
}
