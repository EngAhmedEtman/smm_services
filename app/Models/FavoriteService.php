<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteService extends Model
{
    protected $table = 'service_favorites';

    protected $fillable = [
        'user_id',
        'service_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // No relation to local Service model anymore
}
