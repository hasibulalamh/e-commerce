<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase',
        'expiry_date',
        'usage_limit',
        'used_count',
        'status',
        'product_id',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'value' => 'float',
        'min_purchase' => 'float',
    ];

    /**
     * Check if the coupon is valid for a given subtotal.
     */
    public function isValid($subtotal, $cartItems = null): bool
    {
        if ($this->status !== 'active') return false;
        
        // Use endOfDay to allow usage on the expiry date itself
        if ($this->expiry_date && $this->expiry_date->endOfDay()->isPast()) return false;
        
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        
        if ($this->product_id && $cartItems) {
            $isProductInCart = collect($cartItems)->contains('id', $this->product_id);
            if (!$isProductInCart) return false;
        }

        if ($subtotal < $this->min_purchase) return false;

        return true;
    }

    /**
     * Calculate the discount amount based on subtotal.
     */
    public function calculateDiscount($subtotal): float
    {
        if ($this->type === 'percent') {
            return round($subtotal * ($this->value / 100), 2);
        }

        return min($this->value, $subtotal);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_coupons')
                    ->withPivot('collected_at', 'is_used')
                    ->withTimestamps();
    }
}
