@extends('frontend.master')

@section('content')
<main style="background: #f0f2f5; min-height: 80vh; padding-bottom: 60px;">
    {{-- Enhanced Hero Section with Glassmorphism Effect --}}
    <div style="background: linear-gradient(135deg, #1a1a1a 0%, #333 100%); padding: 80px 0 120px; position: relative; overflow: hidden;">
        {{-- Decorative background elements --}}
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(228, 77, 38, 0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -30px; left: 10%; width: 120px; height: 120px; background: rgba(255, 255, 255, 0.05); border-radius: 50%;"></div>
        
        <div class="container">
            <div style="display: flex; align-items: center; gap: 30px;">
                <div style="width: 100px; height: 100px; background: #e44d26; color: white; 
                            border-radius: 20px; display: flex; align-items:center; justify-content:center;
                            font-size: 2.5rem; font-weight: 800; box-shadow: 0 10px 30px rgba(228, 77, 38, 0.3);
                            border: 4px solid rgba(255,255,255,0.2);">
                    {{ substr(auth('customerg')->user()->name, 0, 1) }}
                </div>
                <div>
                    <h1 style="color: white; font-weight: 800; margin: 0; font-size: 2.2rem; letter-spacing: -0.5px;">
                        Hello, {{ explode(' ', auth('customerg')->user()->name)[0] }}!
                    </h1>
                    <p style="color: rgba(255,255,255,0.6); margin-top: 5px; font-size: 1.1rem;">
                        Member since {{ auth('customerg')->user()->created_at->format('M Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: -60px; position: relative; z-index: 10;">
        <div class="row">
            {{-- Modern Sidebar --}}
            <div class="col-lg-3 mb-4">
                <div style="background: white; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); overflow: hidden; border: 1px solid rgba(0,0,0,0.05);">
                    <div style="padding: 25px 0;">
                        <a href="{{ route('customer.profile') }}" 
                           style="display: flex; align-items: center; padding: 15px 25px; color: #e44d26; text-decoration: none;
                                  background: linear-gradient(to right, rgba(228, 77, 38, 0.08), transparent); 
                                  border-left: 5px solid #e44d26; transition: 0.3s; font-weight: 700; font-size: 15px;">
                            <span style="margin-right: 15px; font-size: 1.2rem;">👤</span> Personal Info
                        </a>
                        <a href="{{ route('customer.addresses') }}" 
                           style="display: flex; align-items: center; padding: 15px 25px; color: #555; text-decoration: none;
                                  transition: 0.3s; font-weight: 600; font-size: 15px;"
                           onmouseover="this.style.color='#e44d26'; this.style.paddingLeft='30px'" 
                           onmouseout="this.style.color='#555'; this.style.paddingLeft='25px'">
                            <span style="margin-right: 15px; font-size: 1.2rem;">🏠</span> My Addresses
                        </a>
                        <a href="{{ route('customer.orders') }}" 
                           style="display: flex; align-items: center; padding: 15px 25px; color: #555; text-decoration: none;
                                  transition: 0.3s; font-weight: 600; font-size: 15px;"
                           onmouseover="this.style.color='#e44d26'; this.style.paddingLeft='30px'" 
                           onmouseout="this.style.color='#555'; this.style.paddingLeft='25px'">
                            <span style="margin-right: 15px; font-size: 1.2rem;">📦</span> Order History
                        </a>
                        
                        <div style="margin: 15px 25px; border-top: 1px solid #f0f0f0; padding-top: 15px;">
                            <form action="{{ route('customer.logout') }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        style="display: flex; align-items: center; padding: 12px 20px; color: #dc3545; 
                                               background: rgba(220, 53, 69, 0.05); border: 1px solid rgba(220, 53, 69, 0.1); 
                                               width: 100%; text-align: left; border-radius: 12px;
                                               transition: 0.3s; font-weight: 700; font-size: 14px; cursor: pointer;">
                                    <span style="margin-right: 15px;">🚪</span> Logout Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content - Premium Form Card --}}
            <div class="col-lg-9">
                <div style="background: white; border-radius: 24px; box-shadow: 0 15px 50px rgba(0,0,0,0.1); padding: 40px; border: 1px solid rgba(0,0,0,0.05);">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 35px;">
                        <div>
                            <h3 style="margin: 0; font-weight: 800; color: #222; font-size: 1.6rem; letter-spacing: -0.5px;">Account Settings</h3>
                            <p style="margin: 5px 0 0; color: #888; font-size: 14px;">Update your personal details and secure your account</p>
                        </div>
                        <span style="background: #e8f4fd; color: #1a73e8; padding: 6px 16px; border-radius: 30px; font-size: 12px; font-weight: 700; text-transform: uppercase;">Verified Account</span>
                    </div>

                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            {{-- Section 1: Basic Information --}}
                            <div class="col-12 mb-4">
                                <h5 style="font-weight: 700; color: #444; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                                    <span style="width: 30px; height: 30px; background: #f0f4f8; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px;">📝</span>
                                    Basic Information
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">FULL NAME</label>
                                        <div style="position: relative;">
                                            <input type="text" name="name" 
                                                   value="{{ old('name', auth('customerg')->user()->name) }}"
                                                   style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 14px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                                   onfocus="this.style.border='2px solid #e44d26'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(228, 77, 38, 0.1)'"
                                                   onblur="this.style.border='2px solid #f0f0f0'; this.style.background='#fafafa'; this.style.boxShadow='none'">
                                        </div>
                                        @error('name') <span style="color: #dc3545; font-size: 12px; font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">EMAIL ADDRESS</label>
                                        <input type="email" name="email" 
                                               value="{{ old('email', auth('customerg')->user()->email) }}"
                                               style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 14px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                               onfocus="this.style.border='2px solid #e44d26'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(228, 77, 38, 0.1)'"
                                               onblur="this.style.border='2px solid #f0f0f0'; this.style.background='#fafafa'; this.style.boxShadow='none'">
                                        @error('email') <span style="color: #dc3545; font-size: 12px; font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">PHONE NUMBER</label>
                                        <input type="text" name="phone" 
                                               value="{{ old('phone', auth('customerg')->user()->phone) }}"
                                               placeholder="e.g. 01XXXXXXXXX"
                                               style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 14px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                               onfocus="this.style.border='2px solid #e44d26'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(228, 77, 38, 0.1)'"
                                               onblur="this.style.border='2px solid #f0f0f0'; this.style.background='#fafafa'; this.style.boxShadow='none'">
                                        @error('phone') <span style="color: #dc3545; font-size: 12px; font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">DEFAULT ADDRESS</label>
                                        <input type="text" name="address" 
                                               value="{{ old('address', auth('customerg')->user()->address) }}"
                                               placeholder="Your primary street address"
                                               style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 14px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                               onfocus="this.style.border='2px solid #e44d26'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(228, 77, 38, 0.1)'"
                                               onblur="this.style.border='2px solid #f0f0f0'; this.style.background='#fafafa'; this.style.boxShadow='none'">
                                        @error('address') <span style="color: #dc3545; font-size: 12px; font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Section 2: Security --}}
                            <div class="col-12 mb-5">
                                <div style="background: #fffcfb; border: 1px solid rgba(228, 77, 38, 0.1); border-radius: 20px; padding: 25px;">
                                    <h5 style="font-weight: 700; color: #e44d26; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                                        <span style="width: 30px; height: 30px; background: rgba(228, 77, 38, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px;">🔒</span>
                                        Security & Password
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">NEW PASSWORD</label>
                                            <input type="password" name="password" 
                                                   placeholder="••••••••"
                                                   style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 14px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: white;"
                                                   onfocus="this.style.border='2px solid #e44d26'; this.style.boxShadow='0 0 0 4px rgba(228, 77, 38, 0.1)'"
                                                   onblur="this.style.border='2px solid #f0f0f0'; this.style.boxShadow='none'">
                                            @error('password') <span style="color: #dc3545; font-size: 12px; font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">CONFIRM PASSWORD</label>
                                            <input type="password" name="password_confirmation" 
                                                   placeholder="••••••••"
                                                   style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 14px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: white;"
                                                   onfocus="this.style.border='2px solid #e44d26'; this.style.boxShadow='0 0 0 4px rgba(228, 77, 38, 0.1)'"
                                                   onblur="this.style.border='2px solid #f0f0f0'; this.style.boxShadow='none'">
                                        </div>
                                    </div>
                                    <p style="margin: 15px 0 0; font-size: 12px; color: #888; font-style: italic;">
                                        Tip: Leave these fields blank if you don't want to change your password.
                                    </p>
                                </div>
                            </div>

                            {{-- Form Actions --}}
                            <div class="col-12" style="display: flex; align-items: center; gap: 20px;">
                                <button type="submit" 
                                        style="background: #e44d26; color: white; border: none; padding: 16px 45px; 
                                               border-radius: 16px; font-weight: 800; font-size: 16px; cursor: pointer;
                                               transition: 0.4s; box-shadow: 0 8px 25px rgba(228, 77, 38, 0.3);
                                               display: flex; align-items: center; gap: 10px;"
                                        onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 35px rgba(228, 77, 38, 0.4)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(228, 77, 38, 0.3)'">
                                    💾 Save Profile Changes
                                </button>
                                <button type="reset" style="background: none; border: none; color: #888; font-weight: 700; cursor: pointer; font-size: 15px;">
                                    Discard Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
