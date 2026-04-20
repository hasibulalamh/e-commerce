<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .container { max-width: 500px; margin: 40px auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: #222; padding: 30px; text-align: center; }
        .header h1 { color: #e44d26; margin: 0; font-size: 24px; }
        .body { padding: 40px 30px; text-align: center; }
        .body p { color: #555; font-size: 15px; line-height: 1.6; }
        .btn { display: inline-block; background: #e44d26; color: white !important; padding: 15px 40px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 16px; margin: 20px 0; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Capital Shop</h1>
        </div>
        <div class="body">
            <h2 style="color: #222; margin-bottom: 5px;">Reset Your Password</h2>
            <p>Hello <strong>{{ $customerName }}</strong>,</p>
            <p>You requested a password reset. Click the button below to create a new password:</p>
            <a href="{{ $resetUrl }}" class="btn">Reset Password</a>
            <p style="color: #888; font-size: 13px;">This link expires in <strong>60 minutes</strong>. If you didn't request this, ignore this email.</p>
            <p style="color: #aaa; font-size: 11px; word-break: break-all;">If the button doesn't work, copy this URL:<br>{{ $resetUrl }}</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Capital Shop. All rights reserved.
        </div>
    </div>
</body>
</html>
