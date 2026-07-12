<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'description',
        'logo',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * অটোমেটিক আপলোডস ফোল্ডারসহ ব্র্যান্ড লোগোর ফুল লাইভ URL তৈরি করার অ্যাক্সেসর
     * (এখন এটি ক্লাসের ভেতরে সঠিক জায়গায় আছে)
     */
    public function getLogoAttribute($value)
    {
        if ($value) {
            // ১. যদি ডাটাবেজে অলরেডি 'uploads/brands/filename.png' এভাবে সেভ থাকে
            if (str_contains($value, 'uploads/brands/')) {
                return asset($value);
            }
            
            // ২. যদি ডাটাবেজে শুধু 'brands/filename.png' থাকে, তবে সামনে uploads/ যোগ করবে
            if (str_contains($value, 'brands/')) {
                return asset('uploads/' . $value);
            }

            // ৩. যদি ডাটাবেজে শুধু ফাইলের নাম (যেমন: 'apple_logo.png') থাকে
            return asset('uploads/brands/' . $value);
        }
        
        // কোনো ইমেজ না থাকলে ভাঙা আইকন এড়াতে একটি ডিফল্ট প্লেসহোল্ডার ইমেজ পাথ
        return asset('uploads/brands/default.png'); 
    }
} // এই মেইন ব্র্যাকেটের ভেতরেই সব ফাংশন থাকতে হবে