@extends('backend.master')
@section('content')
<div class="container-fluid py-4">

    {{-- Stats Row --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div style="background:white; border-radius:10px; padding:20px;
                        box-shadow:0 2px 10px rgba(0,0,0,0.08);
                        border-left:4px solid #e44d26;">
                <p style="margin:0; color:#888; font-size:13px;">Total Orders</p>
                <h3 style="margin:0; font-weight:700; color:#333;">
                    {{ number_format($totalOrders) }}
                </h3>
            </div>
        </div>
        <div class="col-md-3">
            <div style="background:white; border-radius:10px; padding:20px;
                        box-shadow:0 2px 10px rgba(0,0,0,0.08);
                        border-left:4px solid #ffc107;">
                <p style="margin:0; color:#888; font-size:13px;">Pending</p>
                <h3 style="margin:0; font-weight:700; color:#333;">
                    {{ number_format($pendingOrders) }}
                </h3>
            </div>
        </div>
        <div class="col-md-3">
            <div style="background:white; border-radius:10px; padding:20px;
                        box-shadow:0 2px 10px rgba(0,0,0,0.08);
                        border-left:4px solid #28a745;">
                <p style="margin:0; color:#888; font-size:13px;">Completed</p>
                <h3 style="margin:0; font-weight:700; color:#333;">
                    {{ $orders->total() - $pendingOrders }}
                </h3>
            </div>
        </div>
        <div class="col-md-3">
            <div style="background:white; border-radius:10px; padding:20px;
                        box-shadow:0 2px 10px rgba(0,0,0,0.08);
                        border-left:4px solid #17a2b8;">
                <p style="margin:0; color:#888; font-size:13px;">Total Revenue</p>
                <h3 style="margin:0; font-weight:700; color:#e44d26;">
                    ৳{{ number_format($totalRevenue, 0) }}
                </h3>
            </div>
        </div>
    </div>

    {{-- Main Table --}}
    <div style="background:white; border-radius:12px;
                box-shadow:0 2px 15px rgba(0,0,0,0.08); overflow:hidden;">
        
        {{-- Header --}}
        <div style="padding:20px 25px; border-bottom:1px solid #f0f0f0;
                    display:flex; justify-content:space-between; align-items:center;">
            <h5 style="margin:0; font-weight:700; color:#333;">📦 Order Management</h5>
            <a href="{{ route('orders.export') }}" 
               style="background:#28a745; color:white; padding:8px 18px;
                      border-radius:6px; text-decoration:none; font-size:13px;
                      font-weight:600;">
                📥 Export All (Excel)
            </a>
        </div>

        <div class="table-responsive">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f8f9fa;">
                    <th style="padding:14px 20px; text-align:left; font-size:12px;
                               text-transform:uppercase; color:#666; letter-spacing:0.5px;
                               border-bottom:2px solid #eee;">#ID</th>
                    <th style="padding:14px 20px; text-align:left; font-size:12px;
                               text-transform:uppercase; color:#666; letter-spacing:0.5px;
                               border-bottom:2px solid #eee;">Customer</th>
                    <th style="padding:14px 20px; text-align:left; font-size:12px;
                               text-transform:uppercase; color:#666; letter-spacing:0.5px;
                               border-bottom:2px solid #eee;">Items</th>
                    <th style="padding:14px 20px; text-align:left; font-size:12px;
                               text-transform:uppercase; color:#666; letter-spacing:0.5px;
                               border-bottom:2px solid #eee;">Total</th>
                    <th style="padding:14px 20px; text-align:left; font-size:12px;
                               text-transform:uppercase; color:#666; letter-spacing:0.5px;
                               border-bottom:2px solid #eee;">Payment</th>
                    <th style="padding:14px 20px; text-align:left; font-size:12px;
                               text-transform:uppercase; color:#666; letter-spacing:0.5px;
                               border-bottom:2px solid #eee;">Status</th>
                    <th style="padding:14px 20px; text-align:left; font-size:12px;
                               text-transform:uppercase; color:#666; letter-spacing:0.5px;
                               border-bottom:2px solid #eee;">Date</th>
                    <th style="padding:14px 20px; text-align:center; font-size:12px;
                               text-transform:uppercase; color:#666; letter-spacing:0.5px;
                               border-bottom:2px solid #eee;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr style="border-bottom:1px solid #f5f5f5; 
                            transition:background 0.2s;"
                    onmouseover="this.style.background='#fafafa'"
                    onmouseout="this.style.background='white'">
                    
                    <td style="padding:15px 20px;">
                        <span style="font-weight:700; color:#e44d26;">#{{ $order->id }}</span>
                    </td>
                    
                    <td style="padding:15px 20px;">
                        <div style="font-weight:600; color:#333; font-size:14px;">
                            {{ $order->receiver_name ?? $order->name ?? 'N/A' }}
                        </div>
                        <div style="font-size:12px; color:#888;">
                            {{ $order->receiver_mobile ?? $order->phone ?? '' }}
                        </div>
                    </td>

                    <td style="padding:15px 20px;">
                        <span style="background:#e8f4fd; color:#1a73e8;
                                     padding:3px 10px; border-radius:20px;
                                     font-size:12px; font-weight:600;">
                            {{ $order->orderDetails->count() }} items
                        </span>
                    </td>

                    <td style="padding:15px 20px;">
                        <span style="font-weight:700; color:#333;">
                            ৳{{ number_format($order->total, 2) }}
                        </span>
                    </td>

                    <td style="padding:15px 20px;">
                        @php
                            $payMethod = $order->payment_method ?? 'CASH';
                            $payStatus = $order->pay_status ?? 'unpaid';
                        @endphp
                        <span style="background:{{ $payMethod === 'SSL' ? '#e8f4fd' : '#fff3cd' }};
                                     color:{{ $payMethod === 'SSL' ? '#1a73e8' : '#856404' }};
                                     padding:3px 10px; border-radius:20px; font-size:12px;
                                     font-weight:600;">
                            {{ $payMethod }}
                        </span>
                        <br>
                        <span style="font-size:11px; color:{{ $payStatus === 'paid' ? '#28a745' : '#dc3545' }};">
                            {{ ucfirst($payStatus) }}
                        </span>
                    </td>

                    <td style="padding:15px 20px;">
                        @php
                            $statusColors = [
                                'pending'    => ['bg' => '#fff3cd', 'color' => '#856404'],
                                'processing' => ['bg' => '#cce5ff', 'color' => '#004085'],
                                'shipped'    => ['bg' => '#d4edda', 'color' => '#155724'],
                                'delivered'  => ['bg' => '#d1ecf1', 'color' => '#0c5460'],
                                'completed'  => ['bg' => '#d4edda', 'color' => '#155724'],
                                'cancelled'  => ['bg' => '#f8d7da', 'color' => '#721c24'],
                            ];
                            $sc = $statusColors[$order->status] ?? ['bg' => '#e2e3e5', 'color' => '#383d41'];
                        @endphp
                        <span style="background:{{ $sc['bg'] }}; color:{{ $sc['color'] }};
                                     padding:5px 12px; border-radius:20px; font-size:12px;
                                     font-weight:600; text-transform:capitalize;">
                            {{ $order->status ?? 'pending' }}
                        </span>
                    </td>

                    <td style="padding:15px 20px; font-size:13px; color:#888;">
                        {{ $order->created_at->format('d M Y') }}<br>
                        <span style="font-size:11px;">{{ $order->created_at->format('h:i A') }}</span>
                    </td>

                    <td style="padding:15px 20px; text-align:center;">
                        <div style="display:flex; gap:6px; justify-content:center;">
                            {{-- View --}}
                            <a href="{{ route('order.view', $order->id) }}"
                               title="View Details"
                               style="background:#17a2b8; color:white;
                                      padding:6px 12px; border-radius:5px;
                                      text-decoration:none; font-size:12px;
                                      font-weight:600;">
                                👁 View
                            </a>
                            {{-- Invoice --}}
                            <a href="{{ route('order.invoice', $order->id) }}"
                               title="Download Invoice"
                               target="_blank"
                               style="background:#6c757d; color:white;
                                      padding:6px 12px; border-radius:5px;
                                      text-decoration:none; font-size:12px;
                                      font-weight:600;">
                                🧾 Invoice
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding:60px; text-align:center; color:#888;">
                        <div style="font-size:3rem;">📦</div>
                        <p>No orders found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        {{-- Pagination --}}
        <div style="padding:15px 25px; border-top:1px solid #f0f0f0;">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
