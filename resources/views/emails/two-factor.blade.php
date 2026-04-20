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
        .code-box { background: #f8f9fa; border: 2px dashed #e44d26; border-radius: 12px; padding: 25px; margin: 25px 0; }
        .code { font-size: 36px; font-weight: 800; color: #222; letter-spacing: 8px; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Capital Shop</h1>
        </div>
        <div class="body">
            <h2 style="color: #222; margin-bottom: 5px;">Login Verification</h2>
            <p>Hello <strong>{{ $customerName }}</strong>,</p>
            <p>A login attempt was made on your account. Enter this code to verify:</p>
            <div class="code-box">
                <div class="code">{{ $code }}</div>
            </div>
            <p style="color: #888; font-size: 13px;">This code expires in <strong>10 minutes</strong>. If you didn't try to log in, please change your password immediately.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Capital Shop. All rights reserved.
        </div>
    </div>
</body>
</html>
