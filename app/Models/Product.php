<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'description',
        'price',
        'stock',
        'discount',
        'image',
        'status',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
        'sale_price' => 'float',
        'quantity' => 'integer',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Get the brand that owns the product.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    
    /**
     * Get the order details for the product.
     */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Calculate the discount amount in BDT.
     */
    public function getDiscountAmountAttribute(): float
    {
        return round($this->price * ($this->discount ?? 0) / 100, 2);
    }

    /**
     * Calculate the final price after discount.
     */
    public function getFinalPriceAttribute(): float
    {
        return round($this->price - $this->discount_amount, 2);
    }
}
