<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delivery OTP</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <h2 style="color: #333333; text-align: center;">Your Delivery OTP</h2>
        <p style="color: #555555; font-size: 16px;">Hello {{ $order->name ?? $order->customer_name ?? 'Customer' }},</p>
        <p style="color: #555555; font-size: 16px;">Your order <strong>#{{ $order->id }}</strong> is out for delivery. To receive your package, please provide the following One-Time Password (OTP) to the delivery person:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #16a34a; background: #f0fdf4; padding: 15px 30px; border-radius: 8px; border: 2px dashed #16a34a;">{{ $otp }}</span>
        </div>

        <p style="color: #555555; font-size: 16px;">Please <strong>do not share</strong> this code with anyone else. It is valid for the next 30 minutes.</p>
        
        <hr style="border: 0; border-top: 1px solid #eeeeee; margin: 30px 0;">
        
        <p style="color: #888888; font-size: 14px; text-align: center;">
            Thank you for shopping with us!<br>
            <strong>Capital Shop</strong>
        </p>
    </div>
</body>
</html>
