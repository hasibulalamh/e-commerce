<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function addtocart($product_id)
    {
        $product = Product::find($product_id);
        if (!$product) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Product not found']);
            }
            return redirect()->back();
        }

        if ($product->stock < 1) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Out of stock!']);
            }
            toastr()->error('Out of stock!');
            return redirect()->back();
        }

        $mycart = Session::get('cart', []);
        $currentQty = isset($mycart[$product_id]) ? $mycart[$product_id]['quantity'] : 0;

        if ($currentQty + 1 > $product->stock) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Not enough stock!']);
            }
            toastr()->error('Not enough stock!');
            return redirect()->back();
        }

        if (isset($mycart[$product_id])) {
            $mycart[$product_id]['quantity']++;
            $mycart[$product_id]['subtotal'] = $mycart[$product_id]['price'] * $mycart[$product_id]['quantity'];
        } else {
            $mycart[$product_id] = [
                'id'             => $product->id,
                'name'           => $product->name,
                'price'          => $product->final_price,
                'original_price' => $product->price,
                'discount'       => $product->discount,
                'quantity'       => 1,
                'image'          => $product->image,
                'subtotal'       => $product->final_price,
            ];
        }

        Session::put('cart', $mycart);
        $cartCount = count($mycart);

        if (request()->ajax()) {
            return response()->json([
                'success'    => true,
                'message'    => $product->name . ' added to cart!',
                'cart_count' => $cartCount,
            ]);
        }

        toastr()->success('Item added to cart');
        return redirect()->back();
    }

    public function view(){
        $mycart = Session::get('cart') ?? [];

        return view('frontend.shopping.cart',compact('mycart'));

    }



    public function checkout(){
        $mycart = Session::get('cart') ?? [];
        $addresses = auth('customerg')->user()->addresses()->get();
        
        $productIds = collect($mycart)->pluck('id')->toArray();
        
        // Fetch coupons the customer has collected
        $customer = auth('customerg')->user();
        $collectedCouponIds = $customer->coupons()->wherePivot('is_used', false)->pluck('coupons.id')->toArray();

        // Filter active coupons that are collected and applicable
        $availableCoupons = \App\Models\Coupon::where('status', 'active')
            ->whereIn('id', $collectedCouponIds)
            ->where(function($query) use ($productIds) {
                $query->whereNull('product_id')
                      ->orWhereIn('product_id', $productIds);
            })
            ->where(function($query) {
                $query->whereNull('expiry_date')
                      ->orWhereDate('expiry_date', '>=', now());
            })
            ->get();

        return view('frontend.shopping.checkout', compact('mycart', 'addresses', 'availableCoupons'));
    }

    public function storeaddorder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'payment_method' => 'required|in:cod,online',
            'delivery_zone' => 'required|in:inside_dhaka,outside_dhaka',
        ]);

        $mycart = Session::get('cart');
        if (empty($mycart)) {
            toastr()->title('Order Error')->error('Your cart is empty!');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            // Server-side calculation to prevent price manipulation
            $subtotal = 0;
            foreach ($mycart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            
            // Calculate shipping cost based on zone and coupon
            $shipping_cost = 0;
            $is_free_delivery = session()->get('coupon.is_free_delivery', false);

            if (!$is_free_delivery) {
                $shipping_charge_dhaka = \App\Models\Setting::get('shipping_charge_dhaka', 70);
                $shipping_charge_outside = \App\Models\Setting::get('shipping_charge_outside', 130);
                $shipping_cost = ($request->delivery_zone === 'inside_dhaka') ? $shipping_charge_dhaka : $shipping_charge_outside;
            }
            
            // Coupon logic
            $discount = 0;
            $coupon_code = null;
            if (Session::has('coupon')) {
                $coupon_session = Session::get('coupon');
                $coupon = \App\Models\Coupon::where('code', $coupon_session['code'])->first();
                if ($coupon && $coupon->isValid($subtotal, $mycart)) {
                    
                    if ($coupon->is_free_delivery) {
                        $shipping_cost = 0;
                    }
                    
                    $applicableSubtotal = 0;
                    if ($coupon->product_id) {
                        foreach ($mycart as $item) {
                            if ($item['id'] == $coupon->product_id) {
                                $applicableSubtotal += $item['price'] * $item['quantity'];
                            }
                        }
                    } else {
                        $applicableSubtotal = $subtotal;
                    }

                    $discount = $coupon->calculateDiscount($applicableSubtotal);
                    $coupon_code = $coupon->code;
                    $coupon->increment('used_count');

                    // Mark as used for customer
                    auth('customerg')->user()->coupons()->updateExistingPivot($coupon->id, ['is_used' => true]);
                }
            }

            $total = ($subtotal + $shipping_cost) - $discount;

            $myorder = Order::create([
                'customer_id'      => auth('customerg')->user()->id,
                'name'             => $request->name,
                'email'            => $request->email,
                'phone'            => $request->phone,
                'address'          => $request->address,
                'city'             => $request->city,
                'receiver_name'    => $request->name,
                'receiver_email'   => $request->email,
                'receiver_mobile'  => $request->phone,
                'receiver_address' => $request->address,
                'receiver_city'    => $request->city,
                'postal_code'      => $request->postal_code,
                'delivery_zone'    => $request->delivery_zone,
                'subtotal'         => $subtotal,
                'shipping_cost'    => $shipping_cost,
                'tax'              => 0,
                'coupon_code'      => $coupon_code,
                'discount_amount'  => $discount,
                'total'            => $total,
                'payment_method'   => $request->payment_method == 'cod' ? 'CASH' : 'SSL',
                'status'           => 'pending',
            ]);

            foreach ($mycart as $cartdata) {
                $product = Product::find($cartdata['id']);
                
                // Final stock check
                if (!$product || $product->stock < $cartdata['quantity']) {
                    throw new \Exception("Product '{$cartdata['name']}' is out of stock.");
                }

                // Decrement stock
                $product->decrement('stock', $cartdata['quantity']);

                OrderDetail::create([
                    'order_id' => $myorder->id,
                    'product_id' => $cartdata['id'],
                    'quantity' => $cartdata['quantity'],
                    'price' => $cartdata['price'],
                ]);
            }

            DB::commit();

            // Send Order Confirmation Email
            try {
                $myorder->customer->notify(new \App\Notifications\OrderConfirmationNotification($myorder));
            } catch (\Exception $e) {
                \Log::error('Mail Error: ' . $e->getMessage());
            }

            toastr()->title('Place Order')->success('Order placed successfully!');
            Session::forget(['cart', 'coupon']);
            return redirect()->route('order.confirmation', $myorder->id);

        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->title('Order Error')->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function removecart($id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            toastr()->success('Item removed from cart');
        }
        return redirect()->route('cart.view');
    }

    public function updatecart(Request $request)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1|max:100',
        ]);

        $cart = Session::get('cart', []);
        foreach ($request->quantities as $productId => $quantity) {
            if (isset($cart[$productId])) {
                // Stock validation
                $product = Product::find($productId);
                if ($product && $quantity > $product->stock) {
                    toastr()->error("Not enough stock for '{$product->name}'. Available: {$product->stock}");
                    continue;
                }

                $cart[$productId]['quantity'] = $quantity;
                $cart[$productId]['subtotal'] = $cart[$productId]['price'] * $quantity;
            }
        }
        Session::put('cart', $cart);
        toastr()->success('Cart updated successfully');
        return redirect()->route('cart.view');
    }

    public function myorders()
    {
        $orders = Order::where('customer_id', auth('customerg')->user()->id)
            ->with('orderDetails')
            ->latest()
            ->paginate(10);
        return view('frontend.pages.myorders', compact('orders'));
    }

    public function orderdetail($id)
    {
        $order = Order::where('id', $id)
            ->where('customer_id', auth('customerg')->user()->id)
            ->with(['orderDetails.product', 'statusHistories'])
            ->first();

        if (!$order) {
            abort(403, 'Unauthorized access.');
        }

        return view('frontend.pages.orderdetail', compact('order'));
    }

    public function orderConfirmation($id)
    {
        $order = Order::with(['orderDetails.product'])->findOrFail($id);
        
        return view('frontend.pages.order-confirmation', compact('order'));
    }
}
