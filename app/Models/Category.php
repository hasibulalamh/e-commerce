<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'display_order',
        'status',
    ];

    /**
     * ক্যাটাগরি ইমেজের ফুল লাইভ URL জেনারেট করার ক্লিন অ্যাক্সেসর।
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return ''; 
        }

        // সরাসরি লাইভ ডোমেইনের এসেট পাথ রিটার্ন করবে যেন শেয়ার্ড হোস্টিংয়ের 
        // ইন্টারনাল সিমলিংক জটিলতায় ব্ল্যাংক ইউআরএল পাস না হয়।
        return asset('uploads/' . $this->image);
    }
}