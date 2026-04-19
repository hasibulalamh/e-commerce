<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $banners = \App\Models\Banner::where('is_active', true)->orderBy('sort_order')->get();
        $featuredCategories = \App\Models\Category::where('status', 'active')->orderBy('display_order')->take(3)->get();
        $trendingProducts = Product::where('status', 'active')->latest()->take(8)->get();
        $youMayLike = Product::where('status', 'active')->inRandomOrder()->take(6)->get();

        return view('frontend.main', compact('banners', 'featuredCategories', 'trendingProducts', 'youMayLike'));
    }
}
