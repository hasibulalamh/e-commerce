<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function view($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();
        return view('frontend.pages.Productdetails', compact('product', 'relatedProducts'));
    }

    public function listview(Request $request)
    {
        $categoryId = $request->input('category');
        $products = Product::where('status', 'active')
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->paginate(12);

        $categories = \App\Models\Category::where('status', 'active')
            ->orderBy('display_order')
            ->get();
        return view('frontend.pages.productpage', compact('products', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = Product::where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->paginate(12);
        return view('frontend.pages.search', compact('products', 'query'));
    }
}
