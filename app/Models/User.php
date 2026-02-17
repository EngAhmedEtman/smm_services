<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone', // Added phone number
        'is_active', // Added is_active status
        'password',
        'balance',
        'total_spent',
        'total_messages_sent',
        'role',
        'allow_api_key',
        'code',
        'expire_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Set the phone number attribute (auto-clean).
     * Removes +, -, spaces, and keeps only digits.
     */
    protected function setPhoneAttribute($value)
    {
        // Remove everything except numbers
        $this->attributes['phone'] = preg_replace('/[^0-9]/', '', $value);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function favoriteServices()
    {
        return $this->hasMany(FavoriteService::class);
    }

    public function whatsappInstances()
    {
        return $this->hasMany(Whatsapp::class, 'user_id');
    }

    public function whatsappCampaigns()
    {
        return $this->hasMany(WhatsappCampaign::class);
    }

    public function banned()
    {
        return $this->hasOne(BannedUser::class);
    }


    public function generateVerificationCode()
    {
        $this->timestamps = false;
        $this->code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->expire_at = now()->addMinutes(10);
        $this->is_active = false; // Deactivate until verified
        $this->save();
    }

    public function clearVerificationCode()
    {
        $this->timestamps = false;
        $this->code = null;
        $this->expire_at = null;
        $this->is_active = true; // Activate after verification
        $this->save();
    }
}
