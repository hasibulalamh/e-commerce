@extends('frontend.master')
@section('content')

<div style="background:#f8f9fa; min-height:60vh; padding:40px 0;">
<div class="container">

    {{-- Page Header --}}
    <div style="margin-bottom:30px;">
        <h2 style="font-weight:700; color:#222;">🛒 Shopping Cart</h2>
        <p style="color:#888;">
            {{ count(session('cart', [])) }} item(s) in your cart
        </p>
    </div>

    @if(session('cart') && count(session('cart')) > 0)
    <div class="row">
        
        {{-- Cart Items --}}
        <div class="col-lg-8">
            <div style="background:white; border-radius:12px;
                        box-shadow:0 2px 15px rgba(0,0,0,0.08);
                        overflow:hidden; margin-bottom:20px;">
                
                {{-- Header Row --}}
                <div style="background:#f8f9fa; padding:15px 25px;
                            border-bottom:1px solid #eee;
                            display:grid; 
                            grid-template-columns:2fr 1fr 1fr 1fr auto;
                            gap:10px; font-weight:600; 
                            color:#555; font-size:13px;
                            text-transform:uppercase; letter-spacing:0.5px;">
                    <span>Product</span>
                    <span style="text-align:center;">Price</span>
                    <span style="text-align:center;">Quantity</span>
                    <span style="text-align:center;">Total</span>
                    <span></span>
                </div>

                <form action="{{ route('cart.update') }}" method="POST">
                @csrf
                @foreach(session('cart') as $cartId => $cartData)
                <div style="padding:20px 25px; border-bottom:1px solid #f5f5f5;
                            display:grid;
                            grid-template-columns:2fr 1fr 1fr 1fr auto;
                            gap:10px; align-items:center;">
                    
                    {{-- Product Info --}}
                    <div style="display:flex; align-items:center; gap:15px;">
                        <div style="width:80px; height:80px; flex-shrink:0;
                                    border-radius:8px; overflow:hidden;
                                    background:#f5f5f5;">
                            @if(isset($cartData['image']) && $cartData['image'])
                                <img src="{{ asset('upload/products/' . $cartData['image']) }}"
                                     style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <div style="width:100%; height:100%; display:flex;
                                            align-items:center; justify-content:center;
                                            font-size:2rem;">📦</div>
                            @endif
                        </div>
                        <div>
                            <p style="margin:0; font-weight:600; color:#222;
                                      font-size:0.95rem; line-height:1.3;">
                                {{ $cartData['name'] }}
                            </p>
                            @if(isset($cartData['discount']) && $cartData['discount'] > 0)
                            <span style="background:#fff3cd; color:#856404;
                                         padding:2px 8px; border-radius:20px;
                                         font-size:11px; font-weight:600;">
                                {{ $cartData['discount'] }}% OFF applied
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Price --}}
                    <div style="text-align:center;">
                        <span style="font-weight:600; color:#444;">
                            ৳{{ number_format($cartData['price'], 2) }}
                        </span>
                        @if(isset($cartData['original_price']) && $cartData['original_price'] != $cartData['price'])
                        <br>
                        <del style="color:#aaa; font-size:12px;">
                            ৳{{ number_format($cartData['original_price'], 2) }}
                        </del>
                        @endif
                    </div>

                    {{-- Quantity --}}
                    <div style="text-align:center;">
                        <input type="number" 
                               name="quantities[{{ $cartId }}]"
                               value="{{ $cartData['quantity'] }}"
                               min="1" max="100"
                               style="width:70px; text-align:center;
                                      border:2px solid #eee; border-radius:8px;
                                      padding:6px; font-weight:600;
                                      font-size:14px; outline:none;">
                    </div>

                    {{-- Total --}}
                    <div style="text-align:center;">
                        <span style="font-weight:700; color:#e44d26; font-size:1rem;">
                            ৳{{ number_format($cartData['price'] * $cartData['quantity'], 2) }}
                        </span>
                    </div>

                    {{-- Remove --}}
                    <div>
                        <a href="{{ route('cart.remove', $cartId) }}"
                           onclick="return confirm('Remove this item?')"
                           style="background:none; border:none; 
                                  color:#dc3545; font-size:1.3rem;
                                  cursor:pointer; padding:5px;
                                  text-decoration:none;"
                           title="Remove">
                            🗑
                        </a>
                    </div>
                </div>
                @endforeach

                {{-- Update Cart --}}
                <div style="padding:15px 25px; background:#f8f9fa;">
                    <button type="submit"
                            style="background:white; color:#333;
                                   border:2px solid #ddd; padding:10px 25px;
                                   border-radius:8px; font-weight:600;
                                   cursor:pointer; font-size:13px;">
                        🔄 Update Cart
                    </button>
                </div>
                </form>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="col-lg-4">
            <div style="background:white; border-radius:12px;
                        box-shadow:0 2px 15px rgba(0,0,0,0.08);
                        padding:25px; position:sticky; top:20px;">
                
                <h5 style="font-weight:700; margin-bottom:20px;
                            padding-bottom:15px; border-bottom:2px solid #f0f0f0;">
                    Order Summary
                </h5>
                
                @php
                    $subtotal = 0;
                    foreach(session('cart') as $item) {
                        $subtotal += $item['price'] * $item['quantity'];
                    }
                    $shipping = 100;
                    $total = $subtotal + $shipping;
                @endphp

                <div style="display:flex; justify-content:space-between;
                            margin-bottom:12px; color:#555;">
                    <span>Subtotal</span>
                    <span style="font-weight:600;">
                        ৳{{ number_format($subtotal, 2) }}
                    </span>
                </div>

                <div style="display:flex; justify-content:space-between;
                            margin-bottom:12px; color:#555;">
                    <span>Shipping</span>
                    <span style="font-weight:600;">৳100.00</span>
                </div>

                <div style="border-top:2px solid #f0f0f0; margin:15px 0;
                            padding-top:15px; display:flex;
                            justify-content:space-between;">
                    <span style="font-weight:700; font-size:1.1rem;">Total</span>
                    <span style="font-weight:700; font-size:1.2rem; color:#e44d26;">
                        ৳{{ number_format($total, 2) }}
                    </span>
                </div>

                <a href="{{ route('cart.checkout') }}"
                   style="display:block; background:#e44d26; color:white;
                          padding:15px; border-radius:8px; text-align:center;
                          text-decoration:none; font-weight:700;
                          font-size:1rem; margin-bottom:10px;
                          letter-spacing:0.5px;">
                    Proceed to Checkout →
                </a>

                <a href="{{ route('product.listview') }}"
                   style="display:block; background:#f8f9fa; color:#555;
                          padding:12px; border-radius:8px; text-align:center;
                          text-decoration:none; font-weight:600;
                          font-size:0.9rem; border:1px solid #eee;">
                    ← Continue Shopping
                </a>
            </div>
        </div>
    </div>

    @else
    {{-- Empty Cart --}}
    <div style="background:white; border-radius:12px; padding:80px 40px;
                text-align:center; box-shadow:0 2px 15px rgba(0,0,0,0.08);">
        <div style="font-size:5rem; margin-bottom:20px;">🛒</div>
        <h4 style="color:#333; font-weight:700; margin-bottom:10px;">
            Your cart is empty!
        </h4>
        <p style="color:#888; margin-bottom:30px;">
            Add some products to get started.
        </p>
        <a href="{{ route('product.listview') }}"
           style="background:#e44d26; color:white; padding:14px 35px;
                  border-radius:8px; text-decoration:none;
                  font-weight:700; font-size:1rem;">
            Start Shopping
        </a>
    </div>
    @endif

</div>
</div>

@endsection