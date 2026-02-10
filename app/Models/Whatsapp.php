<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Whatsapp extends Model
{
    protected $table = 'whatsapp_instances';

    protected $fillable = [
        'user_id',
        'instance_id',
        'status',
    ];
}
