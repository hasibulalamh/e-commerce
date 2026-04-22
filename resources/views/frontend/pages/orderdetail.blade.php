@extends('frontend.master')

@section('content')
<main style="background: #f8f9fa; min-height: 80vh; padding-bottom: 50px;">
    {{-- Hero/Breadcrumb Section --}}
    <div style="background: linear-gradient(135deg, #222 0%, #444 100%); padding: 60px 0; margin-bottom: 40px;">
        <div class="container">
            <h2 style="color: white; font-weight: 700; margin: 0; font-size: 2rem;">📦 Order Details #{{ $order->id }}</h2>
            <p style="color: rgba(255,255,255,0.7); margin-top: 10px;">Placed on {{ $order->created_at->format('M d, Y') }} at {{ $order->created_at->format('h:i A') }}</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-lg-3 mb-4">
                <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); overflow: hidden;">
                    <div style="padding: 25px; background: #fafafa; border-bottom: 1px solid #eee; text-align: center;">
                        <div style="width: 70px; height: 70px; background: #e44d26; color: white; 
                                    border-radius: 50%; display: flex; align-items:center; justify-content:center;
                                    margin: 0 auto 15px; font-size: 1.8rem; font-weight: 700;">
                            {{ substr(auth('customerg')->user()->name, 0, 1) }}
                        </div>
                        <h5 style="margin: 0; font-weight: 700; color: #333;">{{ auth('customerg')->user()->name }}</h5>
                        <p style="margin: 5px 0 0; font-size: 13px; color: #888;">{{ auth('customerg')->user()->email }}</p>
                    </div>
                    
                    <div style="padding: 15px 0;">
                        <a href="{{ route('customer.profile') }}" 
                           style="display: flex; align-items: center; padding: 12px 25px; color: #555; text-decoration: none;
                                  transition: 0.2s; font-weight: 600; font-size: 14px;">
                            <span style="margin-right: 12px;">👤</span> Profile Settings
                        </a>
                        <a href="{{ route('customer.addresses') }}" 
                           style="display: flex; align-items: center; padding: 12px 25px; color: #555; text-decoration: none;
                                  transition: 0.2s; font-weight: 600; font-size: 14px;">
                            <span style="margin-right: 12px;">🏠</span> My Addresses
                        </a>
                        <a href="{{ route('customer.orders') }}" 
                           style="display: flex; align-items: center; padding: 12px 25px; color: #e44d26; text-decoration: none;
                                  background: rgba(228, 77, 38, 0.05); border-left: 4px solid #e44d26;
                                  transition: 0.2s; font-weight: 700; font-size: 14px;">
                            <span style="margin-right: 12px;">📦</span> Order History
                        </a>
                        <a href="{{ route('customer.wishlist') }}" 
                           style="display: flex; align-items: center; padding: 12px 25px; color: #555; text-decoration: none;
                                  transition: 0.2s; font-weight: 600; font-size: 14px;">
                            <span style="margin-right: 12px;">❤️</span> My Wishlist
                        </a>
                        <form action="{{ route('customer.logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    style="display: flex; align-items: center; padding: 12px 25px; color: #dc3545; 
                                           background: none; border: none; width: 100%; text-align: left;
                                           transition: 0.2s; font-weight: 600; font-size: 14px; cursor: pointer;">
                                <span style="margin-right: 12px;">🚪</span> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Content Area --}}
            <div class="col-lg-9">
                <div class="row">
                    {{-- Daraz-Style Tracking Stepper --}}
                    <div class="col-12 mb-4">
                        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 40px 25px;">
                            <div style="display: flex; justify-content: space-between; position: relative;">
                                {{-- Progress Line Background --}}
                                <div style="position: absolute; top: 25px; left: 5%; right: 5%; height: 4px; background: #eee; z-index: 1;"></div>
                                {{-- Active Progress Line --}}
                                @php
                                    $progressWidth = match($order->status) {
                                        'pending'    => '0%',
                                        'confirmed'  => '33%',
                                        'shipped'    => '66%',
                                        'delivered', 'completed' => '100%',
                                        'cancelled'  => '0%',
                                        default      => '0%'
                                    };
                                    $isCancelled = ($order->status == 'cancelled');
                                @endphp
                                <div style="position: absolute; top: 25px; left: 5%; width: calc({{ $progressWidth }} * 0.9); height: 4px; background: {{ $isCancelled ? '#ff4d4f' : '#e44d26' }}; z-index: 2; transition: 0.5s;"></div>

                                {{-- Steps --}}
                                @foreach(['pending' => 'Placed', 'confirmed' => 'Confirmed', 'shipped' => 'Shipped', 'delivered' => 'Delivered'] as $key => $label)
                                    @php
                                        $isDone = false;
                                        if($order->status == 'delivered' || $order->status == 'completed') $isDone = true;
                                        elseif($order->status == 'shipped' && in_array($key, ['pending', 'confirmed', 'shipped'])) $isDone = true;
                                        elseif($order->status == 'confirmed' && in_array($key, ['pending', 'confirmed'])) $isDone = true;
                                        elseif($order->status == 'pending' && $key == 'pending') $isDone = true;
                                        
                                        $isActive = ($order->status == $key);
                                        if($order->status == 'completed' && $key == 'delivered') $isActive = true;
                                    @endphp
                                    <div style="z-index: 3; text-align: center; width: 80px;">
                                        <div style="width: 50px; height: 50px; background: {{ $isDone ? ($isCancelled ? '#ff4d4f' : '#e44d26') : 'white' }}; 
                                                    border: 4px solid {{ $isDone ? ($isCancelled ? '#ff4d4f' : '#e44d26') : '#eee' }};
                                                    border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center;
                                                    color: {{ $isDone ? 'white' : '#ccc' }}; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                            @if($isDone)
                                                <i class="fas fa-check" style="font-size: 18px;"></i>
                                            @else
                                                <i class="fas fa-circle" style="font-size: 10px;"></i>
                                            @endif
                                        </div>
                                        <p style="margin: 0; font-size: 12px; font-weight: {{ $isActive ? '800' : '600' }}; color: {{ $isActive ? '#222' : '#888' }};">
                                            {{ $label }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($isCancelled)
                                <div style="margin-top: 30px; padding: 15px; background: #fff1f0; border: 1px solid #ffccc7; border-radius: 8px; color: #ff4d4f; text-align: center; font-weight: 700;">
                                    ⚠️ This order has been cancelled.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Items List --}}
                    <div class="col-lg-8 mb-4">
                        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 30px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                                <h5 style="margin: 0; font-weight: 700; color: #222;">Order Items</h5>
                                <span style="font-size: 13px; color: #888;">Order ID: <strong style="color: #444;">#{{ $order->id }}</strong></span>
                            </div>
                            
                            <div class="table-responsive">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #f0f0f0;">
                                            <th style="padding: 10px 0; font-size: 11px; color: #aaa; text-transform: uppercase; letter-spacing: 1px;">Product</th>
                                            <th style="padding: 10px 0; font-size: 11px; color: #aaa; text-transform: uppercase; letter-spacing: 1px; text-align: center;">Price</th>
                                            <th style="padding: 10px 0; font-size: 11px; color: #aaa; text-transform: uppercase; letter-spacing: 1px; text-align: center;">Qty</th>
                                            <th style="padding: 10px 0; font-size: 11px; color: #aaa; text-transform: uppercase; letter-spacing: 1px; text-align: right;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderDetails as $item)
                                        <tr style="border-bottom: 1px solid #f5f5f5;">
                                            <td style="padding: 20px 0;">
                                                <div style="display: flex; align-items: center; gap: 15px;">
                                                    <div style="position: relative;">
                                                        <img src="{{ asset('upload/products/' . ($item->product->image ?? 'default.jpg')) }}" 
                                                             style="width: 60px; height: 60px; border-radius: 10px; object-fit: cover; background: #f9f9f9; border: 1px solid #eee;">
                                                    </div>
                                                    <div>
                                                        <p style="margin: 0; font-weight: 700; color: #333; font-size: 14px;">{{ $item->product->name ?? 'Deleted Product' }}</p>
                                                        <small style="color: #999;">Category: {{ $item->product->category->name ?? 'General' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="padding: 20px 0; text-align: center; color: #555; font-size: 14px; font-weight: 600;">
                                                ৳{{ number_format($item->unit_price, 2) }}
                                            </td>
                                            <td style="padding: 20px 0; text-align: center;">
                                                <span style="background: #f0f2f5; padding: 4px 12px; border-radius: 20px; font-weight: 700; color: #444; font-size: 13px;">
                                                    × {{ $item->pro_quentity }}
                                                </span>
                                            </td>
                                            <td style="padding: 20px 0; text-align: right; font-weight: 800; color: #e44d26; font-size: 15px;">
                                                ৳{{ number_format($item->subtotal, 2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div style="margin-top: 30px; background: #fafafa; border-radius: 10px; padding: 20px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #666;">
                                    <span>Subtotal</span>
                                    <span style="font-weight: 600; color: #333;">৳{{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #666;">
                                    <span>Shipping Fee</span>
                                    <span style="font-weight: 600; color: #333;">৳100.00</span>
                                </div>
                                @if($order->discount_amount > 0)
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #28a745;">
                                    <span>Discount ({{ $order->coupon_code }})</span>
                                    <span style="font-weight: 600;">- ৳{{ number_format($order->discount_amount, 2) }}</span>
                                </div>
                                @endif
                                <div style="display: flex; justify-content: space-between; margin-top: 15px; padding-top: 15px; border-top: 1px dashed #ddd; font-size: 1.3rem; font-weight: 900; color: #e44d26;">
                                    <span>Grand Total</span>
                                    <span>৳{{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar Info --}}
                    <div class="col-lg-4">
                        {{-- Detailed Status History --}}
                        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 25px; margin-bottom: 25px;">
                            <h6 style="font-weight: 800; margin-bottom: 25px; color: #222; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px;">Status History</h6>
                            <div style="position: relative; padding-left: 25px;">
                                {{-- Timeline Line --}}
                                <div style="position: absolute; left: 6px; top: 5px; bottom: 5px; width: 2px; background: #f0f0f0;"></div>
                                
                                @forelse($order->statusHistories()->latest()->get() as $history)
                                <div style="margin-bottom: 25px; position: relative;">
                                    <div style="position: absolute; left: -24px; top: 4px; width: 10px; height: 10px; 
                                                background: white; border: 2px solid #e44d26; border-radius: 50%; z-index: 2;"></div>
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                        <p style="margin: 0; font-weight: 700; color: #333; font-size: 13px; text-transform: capitalize;">{{ $history->status }}</p>
                                        <small style="color: #aaa; font-size: 10px;">{{ $history->created_at->diffForHumans() }}</small>
                                    </div>
                                    <small style="color: #999; display: block; font-size: 11px; margin-bottom: 5px;">{{ $history->created_at->format('d M Y, h:i A') }}</small>
                                    @if($history->notes)
                                        <p style="margin: 8px 0 0; font-size: 12px; color: #666; background: #f8f9fa; padding: 10px; border-radius: 6px; border-left: 3px solid #e44d26;">
                                            {{ $history->notes }}
                                        </p>
                                    @endif
                                </div>
                                @empty
                                    <div style="text-align: center; padding: 20px 0;">
                                        <p style="color: #ccc; font-size: 13px; margin: 0;">No history logs found.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- Payment & Shipping Combined --}}
                        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 25px;">
                            <div style="margin-bottom: 25px; border-bottom: 1px solid #f5f5f5; padding-bottom: 15px;">
                                <h6 style="font-weight: 800; margin-bottom: 15px; color: #222; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px;">Payment Info</h6>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="background: #e44d26; color: white; padding: 2px 10px; border-radius: 4px; font-size: 11px; font-weight: 700;">{{ strtoupper($order->payment_method) }}</span>
                                    <span style="color: {{ $order->payment_status ? '#28a745' : '#ffc107' }}; font-weight: 700; font-size: 13px;">
                                        {{ $order->payment_status ? 'PAID' : 'PENDING' }}
                                    </span>
                                </div>
                            </div>

                            <h6 style="font-weight: 800; margin-bottom: 15px; color: #222; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px;">Delivery Address</h6>
                            <div style="font-size: 14px; line-height: 1.6;">
                                <p style="margin: 0 0 10px; color: #333; font-weight: 600;">{{ $order->receiver_name }}</p>
                                <p style="margin: 0 0 10px; color: #555;"><i class="fas fa-phone-alt" style="width: 20px; color: #888;"></i> {{ $order->receiver_mobile }}</p>
                                <p style="margin: 0; color: #555;"><i class="fas fa-map-marker-alt" style="width: 20px; color: #888;"></i> {{ $order->receiver_address }}, {{ $order->receiver_city }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
