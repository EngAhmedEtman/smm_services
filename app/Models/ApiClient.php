<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'api_key',
        'instance_id',
        'balance',
        'status',
    ];

    /**
     * The "booted" method of the model.
     * دي بتشتغل أوتوماتيك مع الـ Model Lifecycle
     */
    protected static function boot()
    {
        parent::boot();
    }


    /**
     * العلاقة مع جدول المستخدمين
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}