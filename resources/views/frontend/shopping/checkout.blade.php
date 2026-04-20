@extends('frontend.master')
@section('content')

<div style="background:#f8f9fa; min-height:70vh; padding:40px 0;">
<div class="container">

    <div class="row">

        {{-- LEFT: Billing Form --}}
        <div class="col-lg-7 mb-4">
            <div style="background:white; border-radius:12px;
                        box-shadow:0 2px 15px rgba(0,0,0,0.08); padding:30px;">
                
                <h4 style="font-weight:700; margin-bottom:25px; 
                            padding-bottom:15px; border-bottom:2px solid #f0f0f0;
                            color:#222;">
                    📋 Billing Details
                </h4>

                <form action="{{ route('placeorder.store') }}" method="POST">
                @csrf

                {{-- Saved Addresses Selector --}}
                @if($addresses->count() > 0)
                <div class="mb-4" style="background:#f9f9f9; padding:15px; border-radius:10px; border:1px dashed #ccc;">
                    <label style="font-weight:700; font-size:12px; color:#e44d26; text-transform:uppercase; margin-bottom:10px; display:block;">
                        🚀 Quick Select Saved Address
                    </label>
                    <select id="saved_address_selector" class="form-control" style="height:45px; border-radius:8px; border:2px solid #eee;">
                        <option value="">-- Choose a saved address --</option>
                        @foreach($addresses as $addr)
                            <option value="{{ $addr->id }}" 
                                    data-name="{{ $addr->name }}"
                                    data-email="{{ $addr->email }}"
                                    data-phone="{{ $addr->phone }}"
                                    data-address="{{ $addr->address }}"
                                    data-city="{{ $addr->city }}"
                                    data-zip="{{ $addr->zip_code }}">
                                {{ $addr->name }} ({{ $addr->city }}) {{ $addr->is_default ? '[DEFAULT]' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <script>
                    document.getElementById('saved_address_selector').addEventListener('change', function() {
                        const option = this.options[this.selectedIndex];
                        if (option.value) {
                            document.getElementsByName('name')[0].value = option.getAttribute('data-name');
                            document.getElementsByName('email')[0].value = option.getAttribute('data-email');
                            document.getElementsByName('number')[0].value = option.getAttribute('data-phone');
                            document.getElementsByName('address')[0].value = option.getAttribute('data-address');
                            document.getElementsByName('city')[0].value = option.getAttribute('data-city');
                            document.getElementsByName('zip_code')[0].value = option.getAttribute('data-zip');
                            
                            // Visual feedback
                            this.style.borderColor = '#28a745';
                            setTimeout(() => { this.style.borderColor = '#eee'; }, 1000);
                        }
                    });
                </script>
                @endif

                {{-- Name + Phone --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label style="font-weight:600; font-size:13px; 
                                      color:#555; margin-bottom:6px; display:block;">
                            Full Name *
                        </label>
                        <input type="text" name="name" 
                               value="{{ auth('customerg')->user()->name }}"
                               placeholder="Your full name"
                               style="width:100%; padding:12px 15px; border:2px solid #eee;
                                      border-radius:8px; font-size:14px; outline:none;
                                      transition:border 0.2s;"
                               onfocus="this.style.border='2px solid #e44d26'"
                               onblur="this.style.border='2px solid #eee'">
                        @error('name')
                            <span style="color:#dc3545; font-size:12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label style="font-weight:600; font-size:13px;
                                      color:#555; margin-bottom:6px; display:block;">
                            Phone Number *
                        </label>
                        <input type="text" name="number"
                               value="{{ old('number') }}"
                               placeholder="01XXXXXXXXX"
                               style="width:100%; padding:12px 15px; border:2px solid #eee;
                                      border-radius:8px; font-size:14px; outline:none;
                                      transition:border 0.2s;"
                               onfocus="this.style.border='2px solid #e44d26'"
                               onblur="this.style.border='2px solid #eee'">
                        @error('number')
                            <span style="color:#dc3545; font-size:12px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label style="font-weight:600; font-size:13px;
                                  color:#555; margin-bottom:6px; display:block;">
                        Email Address *
                    </label>
                    <input type="email" name="email"
                           value="{{ auth('customerg')->user()->email }}"
                           placeholder="your@email.com"
                           style="width:100%; padding:12px 15px; border:2px solid #eee;
                                  border-radius:8px; font-size:14px; outline:none;
                                  transition:border 0.2s;"
                           onfocus="this.style.border='2px solid #e44d26'"
                           onblur="this.style.border='2px solid #eee'">
                    @error('email')
                        <span style="color:#dc3545; font-size:12px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="mb-3">
                    <label style="font-weight:600; font-size:13px;
                                  color:#555; margin-bottom:6px; display:block;">
                        Street Address *
                    </label>
                    <input type="text" name="address"
                           value="{{ old('address') }}"
                           placeholder="House no, Road no, Area"
                           style="width:100%; padding:12px 15px; border:2px solid #eee;
                                  border-radius:8px; font-size:14px; outline:none;
                                  transition:border 0.2s;"
                           onfocus="this.style.border='2px solid #e44d26'"
                           onblur="this.style.border='2px solid #eee'">
                    @error('address')
                        <span style="color:#dc3545; font-size:12px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- City + ZIP --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label style="font-weight:600; font-size:13px;
                                      color:#555; margin-bottom:6px; display:block;">
                            City *
                        </label>
                        <input type="text" name="city"
                               value="{{ old('city') }}"
                               placeholder="Dhaka"
                               style="width:100%; padding:12px 15px; border:2px solid #eee;
                                      border-radius:8px; font-size:14px; outline:none;
                                      transition:border 0.2s;"
                               onfocus="this.style.border='2px solid #e44d26'"
                               onblur="this.style.border='2px solid #eee'">
                        @error('city')
                            <span style="color:#dc3545; font-size:12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label style="font-weight:600; font-size:13px;
                                      color:#555; margin-bottom:6px; display:block;">
                            ZIP Code
                        </label>
                        <input type="text" name="zip_code"
                               value="{{ old('zip_code') }}"
                               placeholder="1200"
                               style="width:100%; padding:12px 15px; border:2px solid #eee;
                                      border-radius:8px; font-size:14px; outline:none;
                                      transition:border 0.2s;"
                               onfocus="this.style.border='2px solid #e44d26'"
                               onblur="this.style.border='2px solid #eee'">
                        @error('zip_code')
                            <span style="color:#dc3545; font-size:12px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Payment Method --}}
                <div style="background:#f8f9fa; border-radius:10px; padding:20px; margin-bottom:20px;">
                    <h6 style="font-weight:700; margin-bottom:15px; color:#333;">
                        💳 Payment Method
                    </h6>

                    <label style="display:flex; align-items:center; gap:12px;
                                  padding:15px; border:2px solid #eee; border-radius:8px;
                                  margin-bottom:10px; cursor:pointer; background:white;
                                  transition:border 0.2s;"
                           onclick="this.style.border='2px solid #e44d26'">
                        <input type="radio" name="pay" value="CASH" {{ old('pay') == 'CASH' || !old('pay') ? 'checked' : '' }}
                               style="width:18px; height:18px; accent-color:#e44d26;">
                        <div>
                            <div style="font-weight:600; color:#333;">💵 Cash on Delivery</div>
                            <div style="font-size:12px; color:#888;">Pay when your order arrives</div>
                        </div>
                    </label>

                    <label style="display:flex; align-items:center; gap:12px;
                                  padding:15px; border:2px solid #eee; border-radius:8px;
                                  cursor:pointer; background:white; transition:border 0.2s;"
                           onclick="this.style.border='2px solid #e44d26'">
                        <input type="radio" name="pay" value="SSL" {{ old('pay') == 'SSL' ? 'checked' : '' }}
                               style="width:18px; height:18px; accent-color:#e44d26;">
                        <div>
                            <div style="font-weight:600; color:#333;">🔒 SSLCommerz</div>
                            <div style="font-size:12px; color:#888;">Secure online payment</div>
                        </div>
                    </label>
                    @error('pay')
                        <span style="color:#dc3545; font-size:12px; display:block; mt-2;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Hidden total --}}
                <input type="hidden" name="total_amount" 
                       value="{{ array_sum(array_column(session('cart', []), 'subtotal')) }}">

                {{-- Place Order Button --}}
                <button type="submit"
                        style="width:100%; background:#e44d26; color:white;
                               padding:16px; border:none; border-radius:8px;
                               font-size:1.1rem; font-weight:700; cursor:pointer;
                               letter-spacing:0.5px;">
                    🛍️ Place Order
                </button>

                </form>
            </div>
        </div>

        {{-- RIGHT: Order Summary --}}
        <div class="col-lg-5">
            <div style="background:white; border-radius:12px;
                        box-shadow:0 2px 15px rgba(0,0,0,0.08);
                        padding:25px; position:sticky; top:20px;">
                
                <h5 style="font-weight:700; margin-bottom:20px;
                            padding-bottom:15px; border-bottom:2px solid #f0f0f0;">
                    🛒 Your Order
                </h5>

                {{-- Items --}}
                @php $subtotal = 0; @endphp
                @if(session('cart'))
                @foreach(session('cart') as $item)
                @php $subtotal += $item['price'] * $item['quantity']; @endphp
                <div style="display:flex; align-items:center; gap:12px;
                            margin-bottom:15px; padding-bottom:15px;
                            border-bottom:1px solid #f5f5f5;">
                    <div style="width:55px; height:55px; border-radius:8px;
                                overflow:hidden; background:#f5f5f5; flex-shrink:0;">
                        @if(isset($item['image']) && $item['image'])
                            <img src="{{ asset('upload/products/' . $item['image']) }}"
                                 style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <div style="width:100%; height:100%; display:flex;
                                        align-items:center; justify-content:center;">📦</div>
                        @endif
                    </div>
                    <div style="flex:1;">
                        <p style="margin:0; font-weight:600; font-size:0.88rem; color:#333;">
                            {{ $item['name'] }}
                        </p>
                        <p style="margin:0; font-size:12px; color:#888;">
                            Qty: {{ $item['quantity'] }}
                        </p>
                    </div>
                    <div style="font-weight:700; color:#e44d26; white-space:nowrap;">
                        ৳{{ number_format($item['price'] * $item['quantity'], 2) }}
                    </div>
                </div>
                @endforeach
                @endif

                {{-- Totals --}}
                <div style="border-top:2px solid #f0f0f0; padding-top:15px;">
                    <div style="display:flex; justify-content:space-between;
                                margin-bottom:8px; color:#555; font-size:14px;">
                        <span>Subtotal</span>
                        <span style="font-weight:600;">৳{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between;
                                margin-bottom:15px; color:#555; font-size:14px;">
                        <span>Shipping (Flat Rate)</span>
                        <span style="font-weight:600;">৳100.00</span>
                    </div>
                    <div style="display:flex; justify-content:space-between;
                                padding:15px; background:#fff3f0; border-radius:8px;">
                        <span style="font-weight:700; font-size:1rem;">Total</span>
                        <span style="font-weight:700; font-size:1.2rem; color:#e44d26;">
                            ৳{{ number_format($subtotal + 100, 2) }}
                        </span>
                    </div>
                </div>

                <div style="margin-top:15px; padding:12px; background:#f0fff4;
                            border-radius:8px; border-left:4px solid #28a745;">
                    <p style="margin:0; font-size:12px; color:#155724;">
                        🔒 Your order information is secure and encrypted.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

@endsection