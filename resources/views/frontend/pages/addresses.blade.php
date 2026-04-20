@extends('frontend.master')

@section('content')
<main style="background: #f8f9fa; min-height: 80vh; padding-bottom: 50px;">
    {{-- Hero/Breadcrumb Section --}}
    <div style="background: linear-gradient(135deg, #222 0%, #444 100%); padding: 60px 0; margin-bottom: 40px;">
        <div class="container">
            <h2 style="color: white; font-weight: 700; margin: 0; font-size: 2rem;">🏠 Shipping Addresses</h2>
            <p style="color: rgba(255,255,255,0.7); margin-top: 10px;">Manage your delivery locations (Max 5)</p>
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
                {{-- Addresses List --}}
                <div class="row mb-4">
                    @forelse($addresses as $address)
                    <div class="col-md-6 mb-3">
                        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 20px; position: relative;
                                    border: 2px solid {{ $address->is_default ? '#e44d26' : 'transparent' }};">
                            @if($address->is_default)
                                <span style="position: absolute; top: 10px; right: 10px; background: #e44d26; color: white; 
                                             padding: 2px 10px; border-radius: 20px; font-size: 10px; font-weight: 700;">DEFAULT</span>
                            @endif
                            
                            <h6 style="font-weight: 700; color: #333; margin-bottom: 5px;">{{ $address->name }}</h6>
                            <p style="font-size: 13px; color: #666; margin-bottom: 2px;">📞 {{ $address->phone }}</p>
                            <p style="font-size: 13px; color: #666; margin-bottom: 10px;">📍 {{ $address->address }}, {{ $address->city }} {{ $address->zip_code }}</p>
                            
                            <div style="display: flex; gap: 10px; margin-top: 15px;">
                                <a href="{{ route('customer.address.edit', $address->id) }}" style="font-size: 12px; color: #1a73e8; text-decoration: none; font-weight: 600;">Edit</a>
                                
                                @if(!$address->is_default)
                                    <form action="{{ route('customer.address.default', $address->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="background: none; border: none; font-size: 12px; color: #28a745; cursor: pointer; font-weight: 600; padding: 0;">Set Default</button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('customer.address.delete', $address->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; font-size: 12px; color: #dc3545; cursor: pointer; font-weight: 600; padding: 0;">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 40px; text-align: center; color: #888;">
                            <div style="font-size: 3rem; margin-bottom: 10px;">🏠</div>
                            <p>No addresses found. Add one below.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                {{-- Add New Address Form --}}
                @if($addresses->count() < 5)
                <div style="background: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 30px;">
                    <h4 style="margin-bottom: 25px; font-weight: 700; color: #222;">Add New Address</h4>
                    <form action="{{ route('customer.address.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 600; font-size: 13px; color: #555; margin-bottom: 6px; display: block;">Recipient Name *</label>
                                <input type="text" name="name" required
                                       style="width: 100%; padding: 10px 15px; border: 2px solid #eee; border-radius: 8px; outline: none; transition: 0.2s;"
                                       onfocus="this.style.border='2px solid #e44d26'">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 600; font-size: 13px; color: #555; margin-bottom: 6px; display: block;">Email Address (Optional)</label>
                                <input type="email" name="email"
                                       style="width: 100%; padding: 10px 15px; border: 2px solid #eee; border-radius: 8px; outline: none; transition: 0.2s;"
                                       onfocus="this.style.border='2px solid #e44d26'">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 600; font-size: 13px; color: #555; margin-bottom: 6px; display: block;">Phone Number *</label>
                                <input type="text" name="phone" required
                                       style="width: 100%; padding: 10px 15px; border: 2px solid #eee; border-radius: 8px; outline: none; transition: 0.2s;"
                                       onfocus="this.style.border='2px solid #e44d26'">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 600; font-size: 13px; color: #555; margin-bottom: 6px; display: block;">City *</label>
                                <input type="text" name="city" required
                                       style="width: 100%; padding: 10px 15px; border: 2px solid #eee; border-radius: 8px; outline: none; transition: 0.2s;"
                                       onfocus="this.style.border='2px solid #e44d26'">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 600; font-size: 13px; color: #555; margin-bottom: 6px; display: block;">Zip/Postal Code</label>
                                <input type="text" name="zip_code"
                                       style="width: 100%; padding: 10px 15px; border: 2px solid #eee; border-radius: 8px; outline: none; transition: 0.2s;"
                                       onfocus="this.style.border='2px solid #e44d26'">
                            </div>
                            <div class="col-12 mb-3">
                                <label style="font-weight: 600; font-size: 13px; color: #555; margin-bottom: 6px; display: block;">Detailed Address *</label>
                                <textarea name="address" required rows="3"
                                          style="width: 100%; padding: 10px 15px; border: 2px solid #eee; border-radius: 8px; outline: none; transition: 0.2s;"
                                          onfocus="this.style.border='2px solid #e44d26'"></textarea>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" 
                                        style="background: #222; color: white; border: none; padding: 12px 35px; 
                                               border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer;
                                               transition: 0.2s;"
                                        onmouseover="this.style.background='#e44d26'; this.style.transform='translateY(-2px)'"
                                        onmouseout="this.style.background='#222'; this.style.transform='translateY(0)'">
                                    Save Address
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <div style="background: #fff3cd; color: #856404; padding: 20px; border-radius: 12px; font-weight: 600; text-align: center;">
                    ⚠️ You have reached the maximum limit of 5 addresses. Please delete an address to add a new one.
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
