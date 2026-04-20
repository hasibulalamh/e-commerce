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
                    {{-- Order Status Card --}}
                    <div class="col-12 mb-4">
                        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 25px;
                                    display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin: 0; color: #888; font-size: 12px; text-transform: uppercase; font-weight: 600;">Current Status</p>
                                @php
                                    $statusColors = [
                                        'pending'    => ['bg' => '#fff3cd', 'color' => '#856404'],
                                        'confirmed'  => ['bg' => '#cce5ff', 'color' => '#004085'],
                                        'processing' => ['bg' => '#e8f4fd', 'color' => '#1a73e8'],
                                        'shipped'    => ['bg' => '#d4edda', 'color' => '#155724'],
                                        'delivered'  => ['bg' => '#d1ecf1', 'color' => '#0c5460'],
                                        'completed'  => ['bg' => '#d4edda', 'color' => '#155724'],
                                        'cancelled'  => ['bg' => '#f8d7da', 'color' => '#721c24'],
                                    ];
                                    $sc = $statusColors[$order->status] ?? ['bg' => '#e2e3e5', 'color' => '#383d41'];
                                @endphp
                                <h3 style="margin: 5px 0 0; color: {{ $sc['color'] }}; font-weight: 800; text-transform: capitalize;">
                                    {{ $order->status }}
                                </h3>
                            </div>
                            <div style="text-align: right;">
                                <p style="margin: 0; color: #888; font-size: 12px; text-transform: uppercase; font-weight: 600;">Payment Method</p>
                                <h5 style="margin: 5px 0 0; color: #333; font-weight: 700;">{{ strtoupper($order->payment_method) }}</h5>
                            </div>
                        </div>
                    </div>

                    {{-- Items List --}}
                    <div class="col-lg-8 mb-4">
                        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 30px;">
                            <h5 style="margin-bottom: 25px; font-weight: 700; color: #222;">Order Items</h5>
                            
                            <div class="table-responsive">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #f0f0f0;">
                                            <th style="padding: 10px 0; font-size: 12px; color: #888; text-transform: uppercase;">Product</th>
                                            <th style="padding: 10px 0; font-size: 12px; color: #888; text-transform: uppercase; text-align: center;">Price</th>
                                            <th style="padding: 10px 0; font-size: 12px; color: #888; text-transform: uppercase; text-align: center;">Qty</th>
                                            <th style="padding: 10px 0; font-size: 12px; color: #888; text-transform: uppercase; text-align: right;">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderDetails as $item)
                                        <tr style="border-bottom: 1px solid #f5f5f5;">
                                            <td style="padding: 15px 0;">
                                                <div style="display: flex; align-items: center; gap: 12px;">
                                                    <img src="{{ asset('upload/products/' . ($item->product->image ?? 'default.jpg')) }}" 
                                                         style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover; background: #f9f9f9;">
                                                    <div>
                                                        <p style="margin: 0; font-weight: 600; color: #333; font-size: 14px;">{{ $item->product->name ?? 'Deleted Product' }}</p>
                                                        @if($item->product && $item->product->discount > 0)
                                                            <small style="color: #e44d26;">{{ $item->product->discount }}% Off</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="padding: 15px 0; text-align: center; color: #555; font-size: 14px;">
                                                ৳{{ number_format($item->unit_price, 2) }}
                                            </td>
                                            <td style="padding: 15px 0; text-align: center; font-weight: 600; color: #333;">
                                                {{ $item->pro_quentity }}
                                            </td>
                                            <td style="padding: 15px 0; text-align: right; font-weight: 700; color: #222;">
                                                ৳{{ number_format($item->subtotal, 2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div style="margin-top: 25px; border-top: 2px solid #f8f9fa; padding-top: 20px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; color: #666;">
                                    <span>Subtotal</span>
                                    <span>৳{{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; color: #666;">
                                    <span>Shipping Cost</span>
                                    <span>৳100.00</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-top: 15px; font-size: 1.2rem; font-weight: 800; color: #e44d26;">
                                    <span>Grand Total</span>
                                    <span>৳{{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar Info --}}
                    <div class="col-lg-4">
                        {{-- Status History --}}
                        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 25px; margin-bottom: 25px;">
                            <h6 style="font-weight: 700; margin-bottom: 20px; color: #222;">Status Timeline</h6>
                            <div style="position: relative; padding-left: 20px; border-left: 2px solid #eee;">
                                @forelse($order->statusHistories as $history)
                                <div style="margin-bottom: 20px; position: relative;">
                                    <div style="position: absolute; left: -26px; top: 0; width: 10px; height: 10px; 
                                                background: #e44d26; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 0 2px #e44d26;"></div>
                                    <p style="margin: 0; font-weight: 700; color: #333; font-size: 13px; text-transform: capitalize;">{{ $history->status }}</p>
                                    <small style="color: #999; display: block; font-size: 11px;">{{ $history->created_at->format('M d, h:i A') }}</small>
                                    @if($history->notes)
                                        <p style="margin: 5px 0 0; font-size: 12px; color: #666; background: #f9f9f9; padding: 5px 10px; border-radius: 4px;">{{ $history->notes }}</p>
                                    @endif
                                </div>
                                @empty
                                    <p style="color: #888; font-size: 13px;">No history available.</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- Shipping Info --}}
                        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 25px;">
                            <h6 style="font-weight: 700; margin-bottom: 20px; color: #222;">Shipping Address</h6>
                            <div style="font-size: 14px; line-height: 1.6;">
                                <p style="margin: 0 0 10px; color: #333;"><strong style="color: #888; font-weight: 600; font-size: 12px; display: block;">RECEIVER</strong> {{ $order->receiver_name }}</p>
                                <p style="margin: 0 0 10px; color: #333;"><strong style="color: #888; font-weight: 600; font-size: 12px; display: block;">PHONE</strong> {{ $order->receiver_mobile }}</p>
                                <p style="margin: 0 0 10px; color: #333;"><strong style="color: #888; font-weight: 600; font-size: 12px; display: block;">ADDRESS</strong> {{ $order->receiver_address }}, {{ $order->receiver_city }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
