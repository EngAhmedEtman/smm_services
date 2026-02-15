<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiInstance extends Model
{
    protected $fillable = ['client_id','instance_id','provider','status'];

    public function client()
    {
        return $this->belongsTo(ApiClient::class);
    }
}
