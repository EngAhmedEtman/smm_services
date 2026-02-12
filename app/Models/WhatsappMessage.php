<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'content',
        'media_path', // Added media_path to fillable
    ];

    protected $casts = [
        'content' => 'array',
        // No explicit cast for media_path was requested, assuming string or default
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
