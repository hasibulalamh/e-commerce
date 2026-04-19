<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $trendingProducts = Product::where('status', 'active')->latest()->take(8)->get();
        $youMayLike = Product::where('status', 'active')->inRandomOrder()->take(6)->get();

        return view('frontend.main', compact('trendingProducts', 'youMayLike'));
    }
}
