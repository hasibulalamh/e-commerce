<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">
    <div style="max-width:480px;margin:0 auto;background:#fff;border-radius:8px;padding:24px;">
        <h2 style="color:#e11d1d;margin-top:0;">Capital Shop - Delivery Confirmation</h2>
        <p>Hi {{ $order->customer_name ?? 'Customer' }},</p>

        @if($channel === 'in_house')
            <p>Our delivery staff is on the way with order <strong>#{{ $order->id }}</strong>. Share this code with our delivery staff ONLY after you physically receive the package:</p>
        @else
            <p>Your order <strong>#{{ $order->id }}</strong> is out for delivery via Steadfast Courier. Once you receive your package, confirm it yourself using the code below on our website — <strong>do NOT share this code with the delivery rider or anyone over the phone.</strong></p>
        @endif

        <div style="font-size:32px;font-weight:bold;letter-spacing:8px;text-align:center;background:#f0f0f0;padding:16px;border-radius:6px;margin:20px 0;">
            {{ $otp }}
        </div>

        <div style="background:#fef3c7;border-left:4px solid #f59e0b;padding:12px;border-radius:4px;margin-bottom:16px;">
            <strong>⚠️ Security Notice:</strong>
            <p style="margin:6px 0 0;font-size:13px;">
                Capital Shop staff will NEVER call you asking for this code.
                @if($channel === 'steadfast')
                    You should enter this code yourself on our website — never read it out to anyone claiming to be a delivery rider.
                @else
                    Only share this code in person, after receiving the package, directly with our verified delivery staff.
                @endif
            </p>
        </div>

        <p style="color:#888;font-size:13px;">This code expires in 30 minutes and can only be used once.</p>
    </div>
</body>
</html>
