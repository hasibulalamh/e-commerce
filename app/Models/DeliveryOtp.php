<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOtp extends Model
{
    protected $fillable = [
        'order_id',
        'channel',
        'otp_hash',
        'expires_at',
        'attempts',
        'verified_at',
        'verified_by_staff_id',
        'verified_ip',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function verifiedByStaff()
    {
        return $this->belongsTo(User::class, 'verified_by_staff_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    public function isLocked(): bool
    {
        return $this->attempts >= 5;
    }
}
