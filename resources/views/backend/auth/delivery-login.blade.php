<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delivery Staff Login - Capital Shop</title>
</head>
<body style="font-family:Arial,sans-serif;background:#f5f5f5;">
    <div style="max-width:360px;margin:80px auto;background:#fff;padding:24px;border-radius:8px;">
        <h3 style="text-align:center;">Delivery Staff Login</h3>

        <form action="{{ route('delivery.login.submit') }}" method="POST">
            @csrf
            <label>Email</label>
            <input type="email" name="email" style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;margin-bottom:12px;" required>

            <label>Password</label>
            <input type="password" name="password" style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;margin-bottom:16px;" required>

            <button type="submit" style="background:#2563eb;color:#fff;border:none;padding:12px;border-radius:6px;width:100%;">
                Login
            </button>
        </form>
    </div>
</body>
</html>
