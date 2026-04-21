<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        if (!auth('customerg')->check()) {
            toastr()->error('Please login to submit a review.');
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|numeric|min:0.5|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            toastr()->error($validator->errors()->first());
            return redirect()->back();
        }

        /* 
        // TEMPORARILY DISABLED FOR TESTING: Check if customer bought the product and it is delivered
        $hasBought = Order::where('customer_id', auth('customerg')->id())
            ->whereHas('orderDetails', function($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })->where('status', 'delivered')->exists();

        if (!$hasBought) {
            toastr()->warning('You can only review products you have purchased and received.');
            return redirect()->back();
        }
        */

        // Check if already reviewed
        $exists = Review::where('customer_id', auth('customerg')->id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            toastr()->error('You have already reviewed this product.');
            return redirect()->back();
        }

        Review::create([
            'customer_id' => auth('customerg')->id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'active'
        ]);

        toastr()->success('Review submitted successfully! Thank you.');
        return redirect()->back();
    }
}
