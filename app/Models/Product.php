<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected static function booted()
    {
        static::updated(function ($product) {
            if ($product->isDirty('stock')) {
                $oldStock = $product->getOriginal('stock');
                $newStock = $product->stock;

                if ($oldStock <= 0 && $newStock > 0) {
                    // Send notifications to wishlist users
                    $wishlistUsers = \App\Models\Customer::whereHas('wishlists', function ($query) use ($product) {
                        $query->where('product_id', $product->id);
                    })->get();

                    foreach ($wishlistUsers as $user) {
                        try {
                            $user->notify(new \App\Notifications\BackInStockNotification($product));
                        } catch (\Exception $e) {
                            \Log::error("Failed to notify user {$user->id} about product {$product->id}: " . $e->getMessage());
                        }
                    }
                }
            }
        });
    }

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
    
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Get the wishlists that contain this product.
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 'active');
    }

    /**
     * Get the average rating for the product.
     */
    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating'), 1) ?: 0;
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
