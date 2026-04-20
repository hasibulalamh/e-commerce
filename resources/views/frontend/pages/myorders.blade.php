@extends('frontend.master')

@section('content')
<main style="background: #f8f9fa; min-height: 80vh; padding-bottom: 50px;">
    {{-- Hero/Breadcrumb Section --}}
    <div style="background: linear-gradient(135deg, #222 0%, #444 100%); padding: 60px 0; margin-bottom: 40px;">
        <div class="container">
            <h2 style="color: white; font-weight: 700; margin: 0; font-size: 2rem;">📦 My Account</h2>
            <p style="color: rgba(255,255,255,0.7); margin-top: 10px;">Manage your orders and profile settings</p>
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
                <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                        <h4 style="margin: 0; font-weight: 700; color: #222;">Order History</h4>
                        <span style="background: #e8f4fd; color: #1a73e8; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                            Total {{ $orders->total() }} Orders
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #f0f0f0;">
                                    <th style="padding: 15px 10px; text-align: left; font-size: 12px; text-transform: uppercase; color: #888;">Order ID</th>
                                    <th style="padding: 15px 10px; text-align: left; font-size: 12px; text-transform: uppercase; color: #888;">Date</th>
                                    <th style="padding: 15px 10px; text-align: left; font-size: 12px; text-transform: uppercase; color: #888;">Total</th>
                                    <th style="padding: 15px 10px; text-align: center; font-size: 12px; text-transform: uppercase; color: #888;">Status</th>
                                    <th style="padding: 15px 10px; text-align: right; font-size: 12px; text-transform: uppercase; color: #888;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr style="border-bottom: 1px solid #f5f5f5; transition: 0.2s;" 
                                    onmouseover="this.style.background='#fafafa'" 
                                    onmouseout="this.style.background='transparent'">
                                    <td style="padding: 20px 10px;">
                                        <span style="font-weight: 700; color: #333;">#{{ $order->id }}</span>
                                    </td>
                                    <td style="padding: 20px 10px; color: #666; font-size: 14px;">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                    <td style="padding: 20px 10px; font-weight: 700; color: #222;">
                                        ৳{{ number_format($order->total, 2) }}
                                    </td>
                                    <td style="padding: 20px 10px; text-align: center;">
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
                                        <span style="background: {{ $sc['bg'] }}; color: {{ $sc['color'] }}; 
                                                     padding: 4px 12px; border-radius: 20px; font-size: 11px; 
                                                     font-weight: 700; text-transform: capitalize;">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td style="padding: 20px 10px; text-align: right;">
                                        <a href="{{ route('customer.order.detail', $order->id) }}" 
                                           style="background: #222; color: white; padding: 6px 15px; 
                                                  border-radius: 6px; text-decoration: none; font-size: 12px;
                                                  font-weight: 600; transition: 0.2s;"
                                           onmouseover="this.style.background='#e44d26'"
                                           onmouseout="this.style.background='#222'">
                                            Details
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" style="padding: 60px 20px; text-align: center;">
                                        <div style="font-size: 3rem; margin-bottom: 15px;">📦</div>
                                        <h5 style="color: #888; font-weight: 600;">You haven't placed any orders yet.</h5>
                                        <a href="{{ route('product.listview') }}" 
                                           style="display: inline-block; margin-top: 15px; color: #e44d26; font-weight: 700; text-decoration: none;">
                                            Start Shopping →
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div style="margin-top: 30px;">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
