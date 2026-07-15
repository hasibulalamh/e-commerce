<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryReport extends Model
{
    protected $fillable = [
        'order_id',
        'delivery_staff_id',
        'status_reported',
        'reason'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function deliveryStaff()
    {
        return $this->belongsTo(DeliveryStaff::class, 'delivery_staff_id');
    }
}
