@extends('backend.master')

@section('content')
<div style="max-width:480px;margin:0 auto;padding:16px;">
    <h3>My Delivery List</h3>

    <div style="display:flex;gap:10px;margin-bottom:16px;">
        <div style="flex:1;background:#eff6ff;border-radius:8px;padding:12px;text-align:center;">
            <div style="font-size:24px;font-weight:bold;color:#2563eb;">{{ $todayDelivered }}</div>
            <div style="font-size:12px;color:#555;">Delivered Today</div>
        </div>
        <div style="flex:1;background:#fef3c7;border-radius:8px;padding:12px;text-align:center;">
            <div style="font-size:24px;font-weight:bold;color:#d97706;">{{ $totalPending }}</div>
            <div style="font-size:12px;color:#555;">Pending</div>
        </div>
    </div>

    <div style="text-align:right;margin-bottom:12px;">
        <a href="{{ route('delivery.profile') }}" style="color:#2563eb;font-size:14px;">My Profile →</a>
    </div>

    @if(session('success'))
        <div style="background:#d1fae5;color:#065f46;padding:10px;border-radius:6px;margin-bottom:12px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:10px;border-radius:6px;margin-bottom:12px;">
            {{ session('error') }}
        </div>
    @endif

    @forelse ($orders as $order)
        <div style="border:1px solid #ddd;border-radius:8px;padding:14px;margin-bottom:12px;">
            <strong>Order #{{ $order->id }}</strong>
            <p style="margin:4px 0;color:#555;">{{ $order->customer_name }} — {{ $order->shipping_address ?? '' }}</p>

            <form action="{{ route('delivery.send-otp', $order) }}" method="POST" style="margin-bottom:8px;">
                @csrf
                <button type="submit" style="background:#2563eb;color:#fff;border:none;padding:10px 16px;border-radius:6px;width:100%;">
                    Send OTP
                </button>
            </form>

            <form action="{{ route('delivery.verify-otp', $order) }}" method="POST" style="display:flex;gap:8px;">
                @csrf
                <input type="text" name="otp" maxlength="6" placeholder="6-digit OTP"
                    style="flex:1;padding:10px;border:1px solid #ccc;border-radius:6px;" required>
                <button type="submit" style="background:#16a34a;color:#fff;border:none;padding:10px 16px;border-radius:6px;">
                    Confirm
                </button>
            </form>
        </div>
    @empty
        <p>No deliveries assigned right now.</p>
    @endforelse
</div>
@endsection
