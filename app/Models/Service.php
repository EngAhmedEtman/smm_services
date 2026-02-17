<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'name',
        'category',
        'rate',
        'min',
        'max',
        'type',
        'provider',
        'is_active',
        'custom_category',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'service_favorites', 'service_id', 'user_id');
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
