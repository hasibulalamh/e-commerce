@extends('frontend.master')

@section('content')
<main style="background: #f8f9fa; min-height: 80vh; padding: 50px 0;">
    <div class="container">
        <div class="row">
            {{-- Daraz Style Sidebar but with Theme Colors --}}
            <div class="col-lg-3 mb-4">
                <div style="background: white; border-radius: 16px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.03);">
                    <div style="font-size: 16px; margin-bottom: 30px; display: flex; align-items: center; gap: 15px;">
                        <div style="width: 50px; height: 50px; background: #e44d26; color: white; border-radius: 12px; display: flex; align-items:center; justify-content:center; font-size: 1.5rem; font-weight: 800;
                            {{ auth('customerg')->user()->image ? "background-image: url('".asset(auth('customerg')->user()->image)."'); background-size: cover; background-position: center; color: transparent;" : "" }}">
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
                                <a href="{{ route('customer.profile') }}" style="color: #555; text-decoration: none; font-weight: 500; transition: 0.2s;" onmouseover="this.style.color='#e44d26'" onmouseout="this.style.color='#555'">My Profile</a>
                            </li>
                            <li style="margin-bottom: 12px;">
                                <a href="{{ route('customer.addresses') }}" style="color: #e44d26; text-decoration: none; font-weight: 700;">Address Book</a>
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
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h4 style="font-size: 24px; font-weight: 800; color: #222; margin: 0;">Edit Address</h4>
                    <a href="{{ route('customer.addresses') }}" style="color: #e44d26; text-decoration: none; font-size: 15px; font-weight: 600;">← Back</a>
                </div>

                <div style="background: white; padding: 35px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); border-radius: 16px;">
                    <form action="{{ route('customer.address.update', $address->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">FULL NAME</label>
                                <input type="text" name="name" value="{{ old('name', $address->name) }}" required
                                       style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                       onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">EMAIL ADDRESS (OPTIONAL)</label>
                                <input type="email" name="email" value="{{ old('email', $address->email) }}"
                                       style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                       onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">PHONE NUMBER</label>
                                <input type="text" name="phone" value="{{ old('phone', $address->phone) }}" required
                                       style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                       onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">CITY</label>
                                <input type="text" name="city" value="{{ old('city', $address->city) }}" required
                                       style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                       onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                            </div>
                            <div class="col-md-12 mb-4">
                                <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">POSTCODE (OPTIONAL)</label>
                                <input type="text" name="zip_code" value="{{ old('zip_code', $address->zip_code) }}"
                                       style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                       onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                            </div>
                            <div class="col-12 mb-4">
                                <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">DETAILED ADDRESS</label>
                                <textarea name="address" required rows="3"
                                          style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa; resize: none;"
                                          onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">{{ old('address', $address->address) }}</textarea>
                            </div>
                            <div class="col-12 text-right">
                                <button type="submit" 
                                        style="background: #e44d26; color: white; border: none; padding: 14px 35px; 
                                               border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 15px rgba(228, 77, 38, 0.2);"
                                        onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                    Update Details
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
