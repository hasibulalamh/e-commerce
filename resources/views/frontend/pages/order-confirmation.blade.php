@extends('frontend.master')

@section('content')
<div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 70vh; padding: 60px 0;">
    <div class="container">
        <div style="max-width: 720px; margin: 0 auto; text-align: center;">

            {{-- Success Animation --}}
            <div style="width: 110px; height: 110px; background: linear-gradient(135deg, #d4edda, #c3e6cb);
                        border-radius: 50%; display: flex; align-items: center;
                        justify-content: center; margin: 0 auto 25px;
                        font-size: 3.5rem; box-shadow: 0 8px 30px rgba(40,167,69,0.15);
                        animation: scaleIn 0.5s ease-out;">
                ✅
            </div>

            <h2 style="font-weight: 800; color: #28a745; margin-bottom: 10px; font-size: 1.8rem;">
                Order Placed Successfully!
            </h2>
            <p style="color: #666; font-size: 1.1rem; margin-bottom: 35px;">
                Thank you for your order. We'll process it shortly and notify you via email.
            </p>

            {{-- Order ID Badge --}}
            <div style="background: white; border-radius: 16px; padding: 25px 35px;
                        box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 30px;
                        display: inline-block;">
                <span style="color: #999; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Order ID</span>
                <div style="font-size: 2.2rem; font-weight: 800; color: #e44d26; margin: 5px 0;">
                    #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                </div>
                <span style="background: #fff3cd; color: #856404; padding: 5px 16px;
                             border-radius: 20px; font-size: 13px; font-weight: 600;
                             display: inline-block;">
                    {{ ucfirst($order->status ?? 'pending') }}
                </span>
            </div>

            {{-- Order Items --}}
            <div style="background: white; border-radius: 16px; padding: 28px;
                        box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 25px;
                        text-align: left;">
                <h5 style="font-weight: 700; margin-bottom: 20px; color: #333; font-size: 1.1rem;">
                    📦 Order Summary
                </h5>

                @foreach($order->orderDetails as $detail)
                <div style="display: flex; align-items: center; gap: 15px;
                            padding: 14px 0; border-bottom: 1px solid #f0f0f0;">
                    <div style="width: 60px; height: 60px; border-radius: 10px;
                                overflow: hidden; background: #f5f5f5; flex-shrink: 0;">
                        @if($detail->product && $detail->product->image)
                            <img src="{{ asset('upload/products/' . $detail->product->image) }}"
                                 alt="{{ $detail->product->name ?? 'Product' }}"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="height: 100%; display: flex; align-items: center;
                                        justify-content: center; font-size: 1.5rem; color: #ccc;">📦</div>
                        @endif
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <p style="margin: 0; font-weight: 600; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $detail->product->name ?? 'Product #' . $detail->product_id }}
                        </p>
                        <p style="margin: 0; color: #999; font-size: 13px;">
                            Qty: {{ $detail->quantity }} × ৳{{ number_format($detail->price, 2) }}
                        </p>
                    </div>
                    <div style="font-weight: 700; color: #e44d26; white-space: nowrap;">
                        ৳{{ number_format($detail->price * $detail->quantity, 2) }}
                    </div>
                </div>
                @endforeach

                {{-- Totals --}}
                <div style="margin-top: 18px; padding-top: 15px; border-top: 2px solid #f0f0f0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px; color: #666;">
                        <span>Subtotal</span>
                        <span>৳{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px; color: #666;">
                        <span>Shipping</span>
                        <span>৳{{ number_format($order->shipping_cost ?? 100, 2) }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px; color: #28a745;">
                        <span>Coupon Discount</span>
                        <span>-৳{{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    <div style="display: flex; justify-content: space-between; margin-top: 10px;
                                font-size: 1.25rem; font-weight: 800; color: #e44d26;">
                        <span>Total</span>
                        <span>৳{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Delivery Info --}}
            <div style="background: white; border-radius: 16px; padding: 22px 28px;
                        box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 30px;
                        text-align: left;">
                <h5 style="font-weight: 700; margin-bottom: 15px; color: #333; font-size: 1rem;">
                    🚚 Delivery Information
                </h5>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 14px;">
                    <div>
                        <span style="color: #999;">Name:</span>
                        <span style="font-weight: 600; color: #333;"> {{ $order->receiver_name ?? $order->name }}</span>
                    </div>
                    <div>
                        <span style="color: #999;">Phone:</span>
                        <span style="font-weight: 600; color: #333;"> {{ $order->receiver_mobile ?? $order->phone }}</span>
                    </div>
                    <div style="grid-column: span 2;">
                        <span style="color: #999;">Address:</span>
                        <span style="font-weight: 600; color: #333;"> {{ $order->receiver_address ?? $order->address }}, {{ $order->receiver_city ?? $order->city }}</span>
                    </div>
                    <div>
                        <span style="color: #999;">Payment:</span>
                        <span style="font-weight: 600; color: #333;"> {{ $order->payment_method }}</span>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('customer.orders') }}"
                   style="background: #e44d26; color: white; padding: 14px 32px;
                          border-radius: 10px; text-decoration: none; font-weight: 700;
                          font-size: 15px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(228,77,38,0.3);"
                   onmouseover="this.style.background='#d4421e'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.background='#e44d26'; this.style.transform='translateY(0)'">
                    📋 View My Orders
                </a>
                <a href="{{ route('Home') }}"
                   style="background: white; color: #555; padding: 14px 32px;
                          border-radius: 10px; text-decoration: none; font-weight: 700;
                          font-size: 15px; border: 2px solid #e0e0e0; transition: all 0.3s;"
                   onmouseover="this.style.borderColor='#e44d26'; this.style.color='#e44d26'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.borderColor='#e0e0e0'; this.style.color='#555'; this.style.transform='translateY(0)'">
                    🛍️ Continue Shopping
                </a>
            </div>

        </div>
    </div>
</div>

<style>
    @keyframes scaleIn {
        0% { transform: scale(0); opacity: 0; }
        60% { transform: scale(1.1); }
        100% { transform: scale(1); opacity: 1; }
    }
</style>
@endsection
