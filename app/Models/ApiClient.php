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
        'package_name',
        'package_status',
        'expire_at',
        'last_notification_sent',
    ];

    protected $casts = [
        'expire_at' => 'datetime',
        'last_notification_sent' => 'datetime',
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

    public function usageLogs()
    {
        return $this->hasMany(WhatsAppUsageLog::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('package_status', 'active')
            ->where('expire_at', '>', now());
    }

    public function scopeExpiringSoon($query, $days = 3)
    {
        return $query->where('package_status', 'active')
            ->whereBetween('expire_at', [now(), now()->addDays($days)]);
    }

    // Helper Methods  
    public function hasActivePackage()
    {
        return $this->package_status === 'active' && $this->expire_at && $this->expire_at > now();
    }

    public function canSendMessage()
    {
        return $this->hasActivePackage() && $this->balance > 0;
    }

    public function decrementBalance($count = 1)
    {
        if ($this->balance >= $count) {
            $this->decrement('balance', $count);
            return true;
        }
        return false;
    }
}
