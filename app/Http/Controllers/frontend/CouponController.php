<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function collect($id)
    {
        if (!auth('customerg')->check()) {
            return response()->json(['success' => false, 'message' => 'Please login to collect vouchers.']);
        }

        $coupon = Coupon::where('id', $id)->where('status', 'active')->first();
        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Voucher not found or inactive.']);
        }

        $customer = auth('customerg')->user();
        
        // Check if already collected
        if ($customer->coupons()->where('coupon_id', $id)->exists()) {
            return response()->json(['success' => false, 'message' => 'You have already collected this voucher.']);
        }

        $customer->coupons()->attach($id, ['collected_at' => now()]);

        return response()->json(['success' => true, 'message' => 'Voucher collected! You can use it at checkout.']);
    }

    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->where('status', 'active')
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code.']);
        }

        $customer = auth('customerg')->user();
        if (!$customer || !$customer->coupons()->where('coupon_id', $coupon->id)->exists()) {
            return response()->json(['success' => false, 'message' => 'You must collect this voucher first.']);
        }

        $mycart = Session::get('cart', []);
        if (empty($mycart)) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.']);
        }

        $subtotal = 0;
        $applicableSubtotal = 0;
        $isProductInCart = false;

        foreach ($mycart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
            
            if ($coupon->product_id) {
                if ($item['id'] == $coupon->product_id) {
                    $applicableSubtotal += $itemTotal;
                    $isProductInCart = true;
                }
            } else {
                $applicableSubtotal += $itemTotal;
            }
        }

        if ($coupon->product_id && !$isProductInCart) {
            $productName = $coupon->product->name ?? 'the linked product';
            return response()->json(['success' => false, 'message' => "This coupon is only valid for '{$productName}'."]);
        }

        if (!$coupon->isValid($subtotal, $mycart)) {
            if ($subtotal < $coupon->min_purchase) {
                return response()->json(['success' => false, 'message' => "Minimum purchase of {$coupon->min_purchase} BDT required."]);
            }
            return response()->json(['success' => false, 'message' => 'Coupon is expired or usage limit reached.']);
        }

        $discount = $coupon->calculateDiscount($applicableSubtotal);
        
        Session::put('coupon', [
            'code' => $coupon->code,
            'discount' => $discount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount' => $discount,
            'discount_text' => number_format($discount, 2) . ' BDT',
            'new_total' => ($subtotal - $discount) + 100, // 100 is shipping
        ]);
    }

    public function remove()
    {
        Session::forget('coupon');
        toastr()->success('Coupon removed.');
        return redirect()->back();
    }
}
