<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = [
        'customer_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'zip_code',
        'is_default'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
