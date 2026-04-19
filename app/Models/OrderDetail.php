<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    protected $table = 'orderdetails';
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'discount',
    ];
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
        'quantity' => 'integer',
        'discount' => 'float',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['total', 'original_price'];

    /**
     * Get the order that owns the order detail.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the product that owns the order detail.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id')
            ->withTrashed()
            ->with(['category', 'brand']);
    }

    /**
     * Calculate the total price for this order detail.
     *
     * @return float
     */
    public function getTotalAttribute(): float
    {
        return ($this->price * $this->quantity) - ($this->discount ?? 0);
    }

    /**
     * Get the original price before discount.
     *
     * @return float
     */
    public function getOriginalPriceAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    /**
     * Get the discount amount.
     *
     * @return float
     */
    public function getDiscountAmountAttribute(): float
    {
        return $this->discount ?? 0;
    }
}
