<?php

namespace App\Models;

use App\Models\Order;
use App\Models\DeliveryWalletTransaction;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class DeliveryStaff extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'wallet_balance',
        'total_earned',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'wallet_balance' => 'decimal:2',
        'total_earned' => 'decimal:2',
    ];

    /**
     * Ei staff-er assign kora sob order (in-house channel-er)
     */
    public function assignedOrders()
    {
        return $this->hasMany(Order::class, 'delivery_staff_id');
    }

    /**
     * Wallet transactions for this staff
     */
    public function walletTransactions()
    {
        return $this->hasMany(DeliveryWalletTransaction::class, 'delivery_staff_id');
    }
}
