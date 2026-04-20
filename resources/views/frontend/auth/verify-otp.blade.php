@extends('frontend.master')
@section('content')
<main style="background: #f8f9fa; min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 60px 0;">
    <div style="width: 100%; max-width: 480px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 35px;">
            <h2 style="font-size: 28px; font-weight: 800; color: #222; margin-bottom: 8px;">Verify Your Email</h2>
            <p style="color: #888; font-size: 15px;">We sent a 6-digit code to <strong style="color: #e44d26;">{{ $email }}</strong></p>
        </div>

        <div style="background: white; border-radius: 16px; padding: 40px 35px; box-shadow: 0 5px 30px rgba(0,0,0,0.05);">
            <form action="{{ route('customer.verify.otp.submit') }}" method="POST">
                @csrf
                <div style="margin-bottom: 25px;">
                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">ENTER OTP CODE</label>
                    <input type="text" name="otp" maxlength="6" required autofocus placeholder="000000"
                           style="width: 100%; padding: 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; 
                                  font-size: 28px; font-weight: 800; text-align: center; letter-spacing: 12px; color: #222; background: #fafafa; transition: 0.3s;"
                           onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';"
                           onblur="this.style.border='2px solid #f0f0f0'; this.style.background='#fafafa';">
                </div>

                <button type="submit" 
                        style="width: 100%; background: #222; color: white; border: none; padding: 16px; 
                               border-radius: 10px; font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.3s;"
                        onmouseover="this.style.background='#e44d26'" onmouseout="this.style.background='#222'">
                    Verify Email
                </button>
            </form>

            <div style="text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #f0f0f0;">
                <p style="color: #888; font-size: 14px; margin-bottom: 10px;">Didn't receive the code?</p>
                <a href="{{ route('customer.resend.otp') }}" 
                   style="color: #e44d26; font-weight: 700; text-decoration: none; font-size: 15px;">
                    Resend OTP
                </a>
            </div>
        </div>
    </div>
</main>
@endsection
