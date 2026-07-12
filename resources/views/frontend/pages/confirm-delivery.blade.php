@extends('frontend.master')

@section('content')
<div style="max-width:480px;margin:40px auto;padding:20px;">
    <h3>Order #{{ $order->id }} — Delivery Confirmation</h3>

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

    <p style="color:#555;">
        Apni ki apnar package peyechen? Peye thakle, amra pathano OTP code ta niche boshan.
        Package na pele, ei code ta submit korben na.
    </p>

    <div style="background:#fef3c7;border-left:4px solid #f59e0b;padding:12px;border-radius:4px;margin:16px 0;">
        <strong>Security notice:</strong>
        <p style="margin:4px 0 0;font-size:13px;">
            Ei code ta apnar email e gechilo. Kono rider/delivery person ke ei code
            phone e bolben na — apni nijei ei page e boshiye confirm korben.
        </p>
    </div>

    <form action="{{ route('customer.confirm-delivery.submit', $order) }}" method="POST">
        @csrf
        <input type="text" name="otp" maxlength="6" placeholder="6 songkhar OTP"
            style="width:100%;padding:12px;border:1px solid #ccc;border-radius:6px;font-size:18px;text-align:center;letter-spacing:4px;margin-bottom:12px;"
            required>
        <button type="submit" style="background:#16a34a;color:#fff;border:none;padding:12px;border-radius:6px;width:100%;font-size:16px;">
            Confirm Delivery
        </button>
    </form>
</div>
@endsection
