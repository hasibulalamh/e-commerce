@extends('frontend.master')

@section('content')
<main style="background: #f8f9fa; min-height: 80vh; padding-bottom: 50px;">
    {{-- Hero/Breadcrumb Section --}}
    <div style="background: linear-gradient(135deg, #222 0%, #444 100%); padding: 60px 0; margin-bottom: 40px;">
        <div class="container">
            <h2 style="color: white; font-weight: 700; margin: 0; font-size: 2rem;">✏️ Edit Address</h2>
            <p style="color: rgba(255,255,255,0.7); margin-top: 10px;">Update your delivery location details</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-lg-3 mb-4">
                <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); overflow: hidden;">
                    <div style="padding: 25px; background: #fafafa; border-bottom: 1px solid #eee; text-align: center;">
                        <div style="width: 70px; height: 70px; background: #e44d26; color: white; 
                                    border-radius: 50%; display: flex; align-items:center; justify-content:center;
                                    margin: 0 auto 15px; font-size: 1.8rem; font-weight: 700;">
                            {{ substr(auth('customerg')->user()->name, 0, 1) }}
                        </div>
                        <h5 style="margin: 0; font-weight: 700; color: #333;">{{ auth('customerg')->user()->name }}</h5>
                        <p style="margin: 5px 0 0; font-size: 13px; color: #888;">{{ auth('customerg')->user()->email }}</p>
                    </div>
                    
                    <div style="padding: 15px 0;">
                        <a href="{{ route('customer.profile') }}" 
                           style="display: flex; align-items: center; padding: 12px 25px; color: #555; text-decoration: none;
                                  transition: 0.2s; font-weight: 600; font-size: 14px;">
                            <span style="margin-right: 12px;">👤</span> Profile Settings
                        </a>
                        <a href="{{ route('customer.addresses') }}" 
                           style="display: flex; align-items: center; padding: 12px 25px; color: #e44d26; text-decoration: none;
                                  background: rgba(228, 77, 38, 0.05); border-left: 4px solid #e44d26;
                                  transition: 0.2s; font-weight: 700; font-size: 14px;">
                            <span style="margin-right: 12px;">🏠</span> My Addresses
                        </a>
                        <a href="{{ route('customer.orders') }}" 
                           style="display: flex; align-items: center; padding: 12px 25px; color: #555; text-decoration: none;
                                  transition: 0.2s; font-weight: 600; font-size: 14px;">
                            <span style="margin-right: 12px;">📦</span> Order History
                        </a>
                        <form action="{{ route('customer.logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    style="display: flex; align-items: center; padding: 12px 25px; color: #dc3545; 
                                           background: none; border: none; width: 100%; text-align: left;
                                           transition: 0.2s; font-weight: 600; font-size: 14px; cursor: pointer;">
                                <span style="margin-right: 12px;">🚪</span> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Content Area --}}
            <div class="col-lg-9">
                <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                        <h4 style="margin: 0; font-weight: 700; color: #222;">Edit Address</h4>
                        <a href="{{ route('customer.addresses') }}" style="color: #e44d26; font-weight: 700; text-decoration: none; font-size: 14px;">← Back</a>
                    </div>
                    
                    <form action="{{ route('customer.address.update', $address->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 600; font-size: 13px; color: #555; margin-bottom: 6px; display: block;">Recipient Name *</label>
                                <input type="text" name="name" value="{{ old('name', $address->name) }}" required
                                       style="width: 100%; padding: 10px 15px; border: 2px solid #eee; border-radius: 8px; outline: none; transition: 0.2s;"
                                       onfocus="this.style.border='2px solid #e44d26'">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 600; font-size: 13px; color: #555; margin-bottom: 6px; display: block;">Email Address (Optional)</label>
                                <input type="email" name="email" value="{{ old('email', $address->email) }}"
                                       style="width: 100%; padding: 10px 15px; border: 2px solid #eee; border-radius: 8px; outline: none; transition: 0.2s;"
                                       onfocus="this.style.border='2px solid #e44d26'">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 600; font-size: 13px; color: #555; margin-bottom: 6px; display: block;">Phone Number *</label>
                                <input type="text" name="phone" value="{{ old('phone', $address->phone) }}" required
                                       style="width: 100%; padding: 10px 15px; border: 2px solid #eee; border-radius: 8px; outline: none; transition: 0.2s;"
                                       onfocus="this.style.border='2px solid #e44d26'">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 600; font-size: 13px; color: #555; margin-bottom: 6px; display: block;">City *</label>
                                <input type="text" name="city" value="{{ old('city', $address->city) }}" required
                                       style="width: 100%; padding: 10px 15px; border: 2px solid #eee; border-radius: 8px; outline: none; transition: 0.2s;"
                                       onfocus="this.style.border='2px solid #e44d26'">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 600; font-size: 13px; color: #555; margin-bottom: 6px; display: block;">Zip/Postal Code</label>
                                <input type="text" name="zip_code" value="{{ old('zip_code', $address->zip_code) }}"
                                       style="width: 100%; padding: 10px 15px; border: 2px solid #eee; border-radius: 8px; outline: none; transition: 0.2s;"
                                       onfocus="this.style.border='2px solid #e44d26'">
                            </div>
                            <div class="col-12 mb-3">
                                <label style="font-weight: 600; font-size: 13px; color: #555; margin-bottom: 6px; display: block;">Detailed Address *</label>
                                <textarea name="address" required rows="3"
                                          style="width: 100%; padding: 10px 15px; border: 2px solid #eee; border-radius: 8px; outline: none; transition: 0.2s;"
                                          onfocus="this.style.border='2px solid #e44d26'">{{ old('address', $address->address) }}</textarea>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" 
                                        style="background: #e44d26; color: white; border: none; padding: 12px 35px; 
                                               border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer;
                                               transition: 0.2s; box-shadow: 0 4px 15px rgba(228, 77, 38, 0.2);"
                                        onmouseover="this.style.transform='translateY(-2px)'"
                                        onmouseout="this.style.transform='translateY(0)'">
                                    Update Address
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
