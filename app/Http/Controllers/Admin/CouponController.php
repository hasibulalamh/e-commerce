<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with('product')->latest()->paginate(10);
        return view('backend.features.coupon.index', compact('coupons'));
    }

    public function create()
    {
        $products = \App\Models\Product::orderBy('name')->get();
        return view('backend.features.coupon.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date|after_or_equal:today',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
            'product_id' => 'nullable|exists:products,id',
        ]);

        Coupon::create($request->all());

        toastr()->success('Coupon created successfully!');
        return redirect()->route('coupons.index');
    }

    public function edit(Coupon $coupon)
    {
        $products = \App\Models\Product::orderBy('name')->get();
        return view('backend.features.coupon.edit', compact('coupon', 'products'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
            'product_id' => 'nullable|exists:products,id',
        ]);

        $coupon->update($request->all());

        toastr()->success('Coupon updated successfully!');
        return redirect()->route('coupons.index');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        toastr()->success('Coupon deleted successfully!');
        return redirect()->route('coupons.index');
    }
}
