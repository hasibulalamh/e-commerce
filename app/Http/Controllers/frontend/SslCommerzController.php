<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SslCommerzController extends Controller
{
    /**
     * Initiate SSLCommerz payment session.
     * Creates order in DB, then redirects to SSLCommerz gateway.
     */
    public function initiatePayment(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:500',
            'city'           => 'required|string|max:100',
            'postal_code'    => 'nullable|string|max:20',
            'payment_method' => 'required|in:online',
            'delivery_zone'  => 'required|in:inside_dhaka,outside_dhaka',
        ]);

        $mycart = Session::get('cart');
        if (empty($mycart)) {
            toastr()->title('Payment Error')->error('Your cart is empty!');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            // Calculate totals (same logic as OrderController)
            $subtotal = 0;
            foreach ($mycart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $shipping_charge_dhaka = \App\Models\Setting::get('shipping_charge_dhaka', 70);
            $shipping_charge_outside = \App\Models\Setting::get('shipping_charge_outside', 130);
            $shipping_cost = ($request->delivery_zone === 'inside_dhaka') ? $shipping_charge_dhaka : $shipping_charge_outside;

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
                    auth('customerg')->user()->coupons()->updateExistingPivot($coupon->id, ['is_used' => true]);
                }
            }

            $total = ($subtotal + $shipping_cost) - $discount;
            $transaction_id = 'CS-' . uniqid() . '-' . time();

            // Create the order with pending payment
            $order = Order::create([
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
                'delivery_zone'    => $request->delivery_zone,
                'subtotal'         => $subtotal,
                'shipping_cost'    => $shipping_cost,
                'tax'              => 0,
                'coupon_code'      => $coupon_code,
                'discount_amount'  => $discount,
                'total'            => $total,
                'payment_method'   => 'SSL',
                'payment_status'   => false,
                'transaction_id'   => $transaction_id,
                'status'           => 'pending',
            ]);

            // Create order details + decrement stock
            foreach ($mycart as $cartdata) {
                $product = Product::find($cartdata['id']);
                if (!$product || $product->stock < $cartdata['quantity']) {
                    throw new \Exception("Product '{$cartdata['name']}' is out of stock.");
                }
                $product->decrement('stock', $cartdata['quantity']);

                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $cartdata['id'],
                    'quantity'   => $cartdata['quantity'],
                    'price'      => $cartdata['price'],
                ]);
            }

            DB::commit();

            // Build product name list for SSLCommerz
            $productNames = collect($mycart)->pluck('name')->implode(', ');

            // SSLCommerz Session API payload
            $postData = [
                'store_id'          => config('sslcommerz.store_id'),
                'store_passwd'      => config('sslcommerz.store_password'),
                'total_amount'      => $total,
                'currency'          => 'BDT',
                'tran_id'           => $transaction_id,
                'success_url'       => route('payment.success'),
                'fail_url'          => route('payment.fail'),
                'cancel_url'        => route('payment.cancel'),
                'ipn_url'           => route('payment.ipn'),

                // Customer Info
                'cus_name'          => $request->name,
                'cus_email'         => $request->email,
                'cus_phone'         => $request->phone,
                'cus_add1'          => $request->address,
                'cus_city'          => $request->city,
                'cus_postcode'      => $request->postal_code ?? '1000',
                'cus_country'       => 'Bangladesh',

                // Shipping Info
                'shipping_method'   => 'Courier',
                'ship_name'         => $request->name,
                'ship_add1'         => $request->address,
                'ship_city'         => $request->city,
                'ship_postcode'     => $request->postal_code ?? '1000',
                'ship_country'      => 'Bangladesh',
                'num_of_item'       => count($mycart),

                // Product Info
                'product_name'      => substr($productNames, 0, 255),
                'product_category'  => 'E-Commerce',
                'product_profile'   => 'general',
            ];

            // Call SSLCommerz Session API
            $response = Http::asForm()->post(config('sslcommerz.session_url'), $postData);
            $result = $response->json();

            if (isset($result['GatewayPageURL']) && $result['GatewayPageURL'] != '') {
                // Clear cart & coupon before redirect
                Session::forget(['cart', 'coupon']);
                return redirect()->away($result['GatewayPageURL']);
            }

            // If SSLCommerz fails, delete the order and restore stock
            $this->rollbackOrder($order);
            toastr()->title('Payment Error')->error('Could not connect to payment gateway. Please try again.');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('SSLCommerz Init Error: ' . $e->getMessage());
            toastr()->title('Payment Error')->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Payment SUCCESS callback from SSLCommerz.
     */
    public function paymentSuccess(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $val_id = $request->input('val_id');
        $amount = $request->input('amount');

        $order = Order::where('transaction_id', $tran_id)->first();
        if (!$order) {
            Log::error("SSLCommerz Success: Order not found for tran_id: {$tran_id}");
            return redirect()->route('Home')->with('error', 'Order not found.');
        }

        // Validate with SSLCommerz
        if ($this->validateTransaction($val_id, $tran_id, $amount, $order)) {
            $order->update([
                'payment_status' => true,
            ]);

            // Re-login the user to ensure session is active
            auth('customerg')->loginUsingId($order->customer_id);

            // Send confirmation email
            try {
                $order->customer->notify(new \App\Notifications\OrderConfirmationNotification($order));
            } catch (\Exception $e) {
                Log::error('SSLCommerz Mail Error: ' . $e->getMessage());
            }

            toastr()->title('Payment Successful')->success('Your payment has been completed successfully!');
            return redirect()->route('order.confirmation', $order->id);
        }

        // Validation failed
        toastr()->title('Payment Issue')->warning('Payment received but verification pending. Contact support if needed.');
        return redirect()->route('order.confirmation', $order->id);
    }

    /**
     * Payment FAIL callback from SSLCommerz.
     */
    public function paymentFail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $order = Order::where('transaction_id', $tran_id)->first();

        if ($order && $order->payment_status == false) {
            $this->rollbackOrder($order);
            toastr()->title('Payment Failed')->error('Your payment could not be processed. Your order has been cancelled.');
        }

        return redirect()->route('cart.checkout');
    }

    /**
     * Payment CANCEL callback from SSLCommerz.
     */
    public function paymentCancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $order = Order::where('transaction_id', $tran_id)->first();

        if ($order && $order->payment_status == false) {
            $this->rollbackOrder($order);
            toastr()->title('Payment Cancelled')->warning('You cancelled the payment. Your order has been removed.');
        }

        return redirect()->route('cart.checkout');
    }

    /**
     * IPN (Instant Payment Notification) - Server-to-server callback.
     */
    public function ipn(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $val_id = $request->input('val_id');
        $amount = $request->input('amount');
        $status = $request->input('status');

        Log::info("SSLCommerz IPN received: tran_id={$tran_id}, status={$status}");

        $order = Order::where('transaction_id', $tran_id)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($status === 'VALID' || $status === 'VALIDATED') {
            if ($this->validateTransaction($val_id, $tran_id, $amount, $order)) {
                $order->update(['payment_status' => true]);
            }
        } elseif ($status === 'FAILED') {
            if (!$order->payment_status) {
                $this->rollbackOrder($order);
            }
        }

        return response()->json(['message' => 'IPN processed']);
    }

    /**
     * Validate transaction with SSLCommerz Order Validation API.
     */
    private function validateTransaction($val_id, $tran_id, $amount, $order)
    {
        try {
            $response = Http::get(config('sslcommerz.validation_url'), [
                'val_id'       => $val_id,
                'store_id'     => config('sslcommerz.store_id'),
                'store_passwd' => config('sslcommerz.store_password'),
                'format'       => 'json',
            ]);

            $result = $response->json();

            if (isset($result['status']) && ($result['status'] === 'VALID' || $result['status'] === 'VALIDATED')) {
                // Verify amount matches
                if (abs((float)$result['amount'] - (float)$order->total) < 1) {
                    return true;
                }
                Log::warning("SSLCommerz amount mismatch: expected {$order->total}, got {$result['amount']}");
            }
        } catch (\Exception $e) {
            Log::error('SSLCommerz Validation Error: ' . $e->getMessage());
        }

        return false;
    }

    /**
     * Rollback order: restore stock, cancel order, delete if needed.
     */
    private function rollbackOrder($order)
    {
        // Restore stock
        foreach ($order->orderDetails as $detail) {
            $product = $detail->product;
            if ($product) {
                $product->increment('stock', $detail->quantity);
            }
        }

        // Cancel the order
        $order->update(['status' => 'cancelled']);
    }
}
