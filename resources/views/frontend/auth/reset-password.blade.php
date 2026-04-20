@extends('frontend.master')
@section('content')
<main style="background: #f8f9fa; min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 60px 0;">
    <div style="width: 100%; max-width: 480px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 35px;">
            <h2 style="font-size: 28px; font-weight: 800; color: #222; margin-bottom: 8px;">Reset Password</h2>
            <p style="color: #888; font-size: 15px;">Create a new password for your account</p>
        </div>

        <div style="background: white; border-radius: 16px; padding: 40px 35px; box-shadow: 0 5px 30px rgba(0,0,0,0.05);">
            <form action="{{ route('customer.password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div style="margin-bottom: 20px;">
                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">EMAIL</label>
                    <input type="email" value="{{ $email }}" disabled
                           style="width: 100%; padding: 14px 18px; border: 2px solid #e0e0e0; border-radius: 12px; outline: none; 
                                  font-size: 15px; font-weight: 600; color: #888; background: #f5f5f5; cursor: not-allowed;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">NEW PASSWORD</label>
                    <input type="password" name="password" required placeholder="Minimum 6 characters"
                           style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; 
                                  font-size: 15px; font-weight: 600; color: #333; background: #fafafa; transition: 0.3s;"
                           onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                    @error('password') <span style="color: #dc3545; font-size: 13px; font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">CONFIRM PASSWORD</label>
                    <input type="password" name="password_confirmation" required placeholder="Re-enter password"
                           style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; 
                                  font-size: 15px; font-weight: 600; color: #333; background: #fafafa; transition: 0.3s;"
                           onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                </div>

                <button type="submit" 
                        style="width: 100%; background: #222; color: white; border: none; padding: 16px; 
                               border-radius: 10px; font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.3s;"
                        onmouseover="this.style.background='#e44d26'" onmouseout="this.style.background='#222'">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</main>
@endsection
