@extends('frontend.master')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="card shadow-lg border-0" style="max-width: 520px; width: 100%; border-radius: 16px; overflow: hidden; background: #ffffff;">
        <!-- Header Gradient -->
        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 32px 24px; text-align: center; color: #ffffff;">
            <div style="font-size: 40px; margin-bottom: 12px;"><i class="fas fa-shipping-fast"></i></div>
            <h4 class="fw-bold mb-1" style="font-family: 'Inter', sans-serif;">Confirm Delivery</h4>
            <p class="mb-0 text-white-50 small">Order #{{ $order->id }}</p>
        </div>

        <div class="card-body p-4">
            <!-- Toast alerts inside card for focus -->
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center border-0 shadow-sm mb-3" style="border-radius: 10px; background: #ecfdf5; color: #065f46;">
                    <i class="fas fa-check-circle me-2 fs-5"></i>
                    <div class="small fw-semibold">{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center border-0 shadow-sm mb-3" style="border-radius: 10px; background: #fef2f2; color: #991b1b;">
                    <i class="fas fa-exclamation-circle me-2 fs-5"></i>
                    <div class="small fw-semibold">{{ session('error') }}</div>
                </div>
            @endif

            <p class="text-muted text-center mb-4" style="font-size: 14px; line-height: 1.6;">
                Apni ki apnar package peyechen? Peye thakle, amra pathano OTP code ta niche boshan. 
                <strong>Package na pele, ei code ta submit korben na.</strong>
            </p>

            <!-- Security Alert Box -->
            <div class="p-3 mb-4" style="background: #fffbeb; border-left: 4px solid #d97706; border-radius: 8px;">
                <div class="d-flex gap-2">
                    <span class="text-warning"><i class="fas fa-shield-alt"></i></span>
                    <div>
                        <strong style="color: #92400e; font-size: 13px; display: block;">Security Notice:</strong>
                        <p class="mb-0 text-muted" style="font-size: 12px; line-height: 1.4; margin-top: 2px;">
                            Ei code ta apnar email e gechilo. Kono rider/delivery person ke ei code phone e bolben na — apni nijei ei page e boshiye confirm korben.
                        </p>
                    </div>
                </div>
            </div>

            <!-- OTP Submission Form -->
            <form action="{{ route('customer.confirm-delivery.submit', $order) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <input type="text" name="otp" maxlength="6" placeholder="● ● ● ● ● ●" 
                           style="width: 100%; padding: 14px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 22px; text-align: center; letter-spacing: 6px; font-weight: 700; outline: none; transition: all 0.3s ease; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);" 
                           onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.15)';" 
                           onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
                           required>
                </div>

                <button type="submit" class="btn w-100 py-3 text-white fw-bold shadow-sm" 
                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; border-radius: 10px; font-size: 16px; transition: all 0.3s ease;"
                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(16, 185, 129, 0.25)';"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                    <i class="fas fa-check me-2"></i> Confirm Delivery
                </button>
            </form>

            <!-- Resend Form -->
            <div class="text-center mt-4">
                <form action="{{ route('customer.confirm-delivery.send-otp', $order) }}" method="POST">
                    @csrf
                    <p class="text-muted small mb-1">Didn't receive the email OTP?</p>
                    <button type="submit" class="btn btn-link text-decoration-none p-0 fw-bold small" 
                            style="color: #10b981; transition: color 0.2s;"
                            onmouseover="this.style.color='#059669';"
                            onmouseout="this.style.color='#10b981';">
                        <i class="fas fa-sync-alt me-1"></i> Resend Verification Code
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
