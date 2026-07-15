<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryWalletTransaction extends Model
{
    protected $fillable = [
        'delivery_staff_id',
        'order_id',
        'type',
        'amount',
        'balance_after',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
    ];

    /**
     * The delivery staff this transaction belongs to.
     */
    public function deliveryStaff()
    {
        return $this->belongsTo(DeliveryStaff::class, 'delivery_staff_id');
    }

    /**
     * The order linked to this transaction (if any).
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
