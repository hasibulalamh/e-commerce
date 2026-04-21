@extends('frontend.master')

@section('content')
<main style="background: #f8f9fa; min-height: 80vh; padding: 50px 0;">
    <div class="container">
        <div class="row">
            {{-- Daraz Style Sidebar but with Theme Colors --}}
            <div class="col-lg-3 mb-4">
                <div style="background: white; border-radius: 16px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.03);">
                    <div style="font-size: 16px; margin-bottom: 30px; display: flex; align-items: center; gap: 15px;">
                        <div style="width: 55px; height: 55px; flex-shrink: 0; background: #e44d26; color: white; border-radius: 12px; display: flex; align-items:center; justify-content:center; font-size: 1.5rem; font-weight: 800;
                            {{ auth('customerg')->user()->image ? "background-image: url('".asset(auth('customerg')->user()->image)."'); background-size: cover; background-position: top center; color: transparent;" : "" }}">
                            {{ substr(auth('customerg')->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <span style="font-size: 13px; color: #888; display: block;">Hello,</span>
                            <strong style="color: #222;">{{ explode(' ', auth('customerg')->user()->name)[0] }}</strong>
                        </div>
                    </div>

                    <div style="margin-bottom: 25px;">
                        <h6 style="font-weight: 700; font-size: 15px; color: #222; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 0.5px;">Manage Account</h6>
                        <ul style="list-style: none; padding: 0; margin: 0; font-size: 15px;">
                            <li style="margin-bottom: 12px;">
                                <a href="{{ route('customer.profile') }}" style="color: #e44d26; text-decoration: none; font-weight: 700;">My Profile</a>
                            </li>
                            <li style="margin-bottom: 12px;">
                                <a href="{{ route('customer.addresses') }}" style="color: #555; text-decoration: none; font-weight: 500; transition: 0.2s;" onmouseover="this.style.color='#e44d26'" onmouseout="this.style.color='#555'">Address Book</a>
                            </li>
                            <li style="margin-bottom: 12px;">
                                <a href="{{ route('customer.wishlist') }}" style="color: #555; text-decoration: none; font-weight: 500; transition: 0.2s;" onmouseover="this.style.color='#e44d26'" onmouseout="this.style.color='#555'">My Wishlist</a>
                            </li>
                            <li style="margin-bottom: 12px;">
                                <a href="{{ route('customer.vouchers') }}" style="color: #555; text-decoration: none; font-weight: 500; transition: 0.2s;" onmouseover="this.style.color='#e44d26'" onmouseout="this.style.color='#555'">My Vouchers</a>
                            </li>
                        </ul>
                    </div>

                    <div style="margin-bottom: 25px;">
                        <h6 style="font-weight: 700; font-size: 15px; color: #222; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 0.5px;">Orders</h6>
                        <ul style="list-style: none; padding: 0; margin: 0; font-size: 15px;">
                            <li style="margin-bottom: 12px;">
                                <a href="{{ route('customer.orders') }}" style="color: #555; text-decoration: none; font-weight: 500; transition: 0.2s;" onmouseover="this.style.color='#e44d26'" onmouseout="this.style.color='#555'">Order History</a>
                            </li>
                        </ul>
                    </div>

                    <div style="border-top: 1px solid #f0f0f0; padding-top: 20px; margin-top: 10px;">
                        <form action="{{ route('customer.logout') }}" method="POST">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: #dc3545; font-size: 15px; font-weight: 600; padding: 0; cursor: pointer; text-align: left; transition: 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Main Content - Daraz Layout with Theme Styling --}}
            <div class="col-lg-9">
                <h4 style="font-size: 24px; font-weight: 800; color: #222; margin-bottom: 25px;">My Profile</h4>

                <div style="display: flex; flex-direction: column; gap: 25px;">
                    
                    {{-- Profile Picture Box --}}
                    <div style="background: white; padding: 35px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); border-radius: 16px;">
                        <h5 style="font-size: 18px; font-weight: 700; color: #222; margin-bottom: 20px;">Profile Picture</h5>
                        <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" style="display: flex; align-items: center; gap: 30px;">
                            @csrf
                            <div style="width: 100px; height: 100px; flex-shrink: 0; background: #e44d26; border-radius: 16px; display: flex; align-items:center; justify-content:center;
                                        font-size: 2.5rem; font-weight: 800; color: white; background-size: cover; background-position: top center; box-shadow: 0 8px 20px rgba(228, 77, 38, 0.2);
                                        {{ auth('customerg')->user()->image ? "background-image: url('".asset(auth('customerg')->user()->image)."'); color: transparent;" : "" }}">
                                {{ substr(auth('customerg')->user()->name, 0, 1) }}
                            </div>
                            <div style="flex-grow: 1;">
                                <input type="file" name="image" accept="image/*" required
                                       style="width: 100%; padding: 12px 15px; border: 2px dashed #e0e0e0; border-radius: 12px; outline: none; font-size: 15px; font-weight: 600; color: #555; background: #fafafa; cursor: pointer; margin-bottom: 15px; transition: 0.3s;"
                                       onfocus="this.style.border='2px dashed #e44d26';">
                                @error('image') <span style="color: #dc3545; font-size: 13px; font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
                                <button type="submit" 
                                        style="background: #222; color: white; border: none; padding: 12px 25px; 
                                               border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; transition: 0.3s;"
                                        onmouseover="this.style.background='#e44d26'" onmouseout="this.style.background='#222'">
                                    Upload Avatar
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Basic Info Box --}}
                    <div style="background: white; padding: 35px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); border-radius: 16px;">
                        <h5 style="font-size: 18px; font-weight: 700; color: #222; margin-bottom: 20px;">Basic Information</h5>
                        <form action="{{ route('customer.profile.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: flex; justify-content: space-between;">
                                        FULL NAME
                                        <span style="color: #dc3545; font-size: 10px; background: rgba(220,53,69,0.1); padding: 2px 6px; border-radius: 4px;">🔒 LOCKED</span>
                                    </label>
                                    <input type="text" name="name" value="{{ auth('customerg')->user()->name }}" readonly
                                           style="width: 100%; padding: 14px 18px; border: 2px solid #e0e0e0; border-radius: 12px; outline: none; font-weight: 600; font-size: 15px; color: #888; background: #f5f5f5; cursor: not-allowed;">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: flex; justify-content: space-between;">
                                        EMAIL ADDRESS
                                        <span style="color: #dc3545; font-size: 10px; background: rgba(220,53,69,0.1); padding: 2px 6px; border-radius: 4px;">🔒 LOCKED</span>
                                    </label>
                                    <input type="email" name="email" value="{{ auth('customerg')->user()->email }}" readonly
                                           style="width: 100%; padding: 14px 18px; border: 2px solid #e0e0e0; border-radius: 12px; outline: none; font-weight: 600; font-size: 15px; color: #888; background: #f5f5f5; cursor: not-allowed;">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">MOBILE NUMBER</label>
                                    <input type="text" name="phone" value="{{ old('phone', auth('customerg')->user()->phone) }}"
                                           style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                           onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                                    @error('phone') <span style="color: #dc3545; font-size: 13px; font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">DEFAULT ADDRESS</label>
                                    <select name="default_address_id" 
                                           style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa; cursor: pointer;"
                                           onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                                        <option value="">Select an address</option>
                                        @foreach($addresses as $addr)
                                            <option value="{{ $addr->id }}" {{ $addr->is_default ? 'selected' : '' }}>
                                                {{ $addr->address }}, {{ $addr->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($addresses->isEmpty())
                                        <small style="color: #888; font-size: 12px; margin-top: 5px; display: block;">
                                            <a href="{{ route('customer.addresses') }}" style="color: #1a73e8; font-weight: 600; text-decoration: none;">Add an address first</a>
                                        </small>
                                    @endif
                                </div>
                                <div class="col-12 mt-2 text-right">
                                    <button type="submit" 
                                            style="background: #222; color: white; border: none; padding: 14px 35px; 
                                                   border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; transition: 0.3s;"
                                            onmouseover="this.style.background='#e44d26'" onmouseout="this.style.background='#222'">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Security Box --}}
                    <div style="background: white; padding: 35px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); border-radius: 16px;">
                        <h5 style="font-size: 18px; font-weight: 700; color: #222; margin-bottom: 20px;">Change Password</h5>
                        <form action="{{ route('customer.profile.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">NEW PASSWORD</label>
                                    <input type="password" name="password" placeholder="Minimum 6 characters" required
                                           style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                           onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                                    @error('password') <span style="color: #dc3545; font-size: 13px; font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">CONFIRM NEW PASSWORD</label>
                                    <input type="password" name="password_confirmation" placeholder="Re-enter new password" required
                                           style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                           onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                                </div>
                                <div class="col-12 text-right">
                                    <button type="submit" 
                                            style="background: #222; color: white; border: none; padding: 14px 35px; 
                                                   border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; transition: 0.3s;"
                                            onmouseover="this.style.background='#e44d26'" onmouseout="this.style.background='#222'">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Two-Factor Authentication Box --}}
                    <div style="background: white; padding: 35px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); border-radius: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                            <div>
                                <h5 style="font-size: 18px; font-weight: 700; color: #222; margin-bottom: 5px;">Two-Factor Authentication (2FA)</h5>
                                <p style="color: #888; font-size: 14px; margin: 0;">Add an extra layer of security. A verification code will be sent to your email on each login.</p>
                            </div>
                            <form action="{{ route('customer.profile.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="two_factor_enabled" value="{{ auth('customerg')->user()->two_factor_enabled ? '0' : '1' }}">
                                @if(auth('customerg')->user()->two_factor_enabled)
                                    <button type="submit" 
                                            style="background: #dc3545; color: white; border: none; padding: 12px 25px; 
                                                   border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; transition: 0.3s;"
                                            onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                                        🔓 Disable 2FA
                                    </button>
                                @else
                                    <button type="submit" 
                                            style="background: #28a745; color: white; border: none; padding: 12px 25px; 
                                                   border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; transition: 0.3s;"
                                            onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                                        🔒 Enable 2FA
                                    </button>
                                @endif
                            </form>
                        </div>
                        @if(auth('customerg')->user()->two_factor_enabled)
                            <div style="margin-top: 15px; background: rgba(40,167,69,0.08); padding: 12px 18px; border-radius: 8px; border-left: 4px solid #28a745;">
                                <span style="color: #28a745; font-weight: 700; font-size: 14px;">✅ 2FA is currently ENABLED</span>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
