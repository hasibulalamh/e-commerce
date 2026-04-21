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
                            <li style="margin-bottom: 12px;">
                                <a href="{{ route('customer.wishlist') }}" style="color: #555; text-decoration: none; font-weight: 500; transition: 0.2s;" onmouseover="this.style.color='#e44d26'" onmouseout="this.style.color='#555'">My Wishlist</a>
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
                    <h4 style="font-size: 24px; font-weight: 800; color: #222; margin: 0;">Address Book</h4>
                </div>

                <div style="display: flex; flex-direction: column; gap: 25px;">
                    
                    {{-- Addresses Table / Grid --}}
                    <div style="background: white; padding: 35px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); border-radius: 16px; overflow: hidden;">
                        <div class="table-responsive">
                            <table style="width: 100%; border-collapse: collapse; font-size: 15px;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #f0f0f0;">
                                        <th style="padding: 15px 0; font-weight: 700; color: #666; text-align: left; font-size: 13px; letter-spacing: 0.5px;">FULL NAME</th>
                                        <th style="padding: 15px 0; font-weight: 700; color: #666; text-align: left; font-size: 13px; letter-spacing: 0.5px;">ADDRESS</th>
                                        <th style="padding: 15px 0; font-weight: 700; color: #666; text-align: left; font-size: 13px; letter-spacing: 0.5px;">POSTCODE</th>
                                        <th style="padding: 15px 0; font-weight: 700; color: #666; text-align: left; font-size: 13px; letter-spacing: 0.5px;">PHONE</th>
                                        <th style="padding: 15px 0; font-weight: 700; color: #666; text-align: right; font-size: 13px; letter-spacing: 0.5px;">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($addresses as $address)
                                    <tr style="border-bottom: 1px solid #f0f0f0; transition: 0.2s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">
                                        <td style="padding: 20px 0; color: #222; font-weight: 600;">
                                            {{ $address->name }}
                                            @if($address->is_default)
                                                <span style="background: rgba(228,77,38,0.1); color: #e44d26; font-size: 11px; padding: 4px 8px; border-radius: 6px; margin-left: 8px; font-weight: 700;">DEFAULT</span>
                                            @endif
                                        </td>
                                        <td style="padding: 20px 0; color: #555; max-width: 250px; line-height: 1.5;">
                                            {{ $address->address }}<br>
                                            <span style="color: #888; font-size: 13px;">{{ $address->city }}</span>
                                        </td>
                                        <td style="padding: 20px 0; color: #555; font-weight: 500;">{{ $address->zip_code ?: '-' }}</td>
                                        <td style="padding: 20px 0; color: #555; font-weight: 500;">{{ $address->phone }}</td>
                                        <td style="padding: 20px 0; text-align: right;">
                                            <a href="{{ route('customer.address.edit', $address->id) }}" style="color: #1a73e8; text-decoration: none; margin-right: 15px; font-weight: 600; background: #e8f4fd; padding: 6px 12px; border-radius: 6px;">Edit</a>
                                            <form action="{{ route('customer.address.delete', $address->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this address?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: #fdf3f4; border: none; color: #dc3545; cursor: pointer; padding: 6px 12px; font-weight: 600; font-size: 14px; border-radius: 6px;">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" style="padding: 50px 0; text-align: center; color: #888; font-weight: 500;">
                                            You haven't added any shipping addresses yet.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Add New Address Box --}}
                    @if($addresses->count() < 5)
                    <div style="background: white; padding: 35px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); border-radius: 16px;">
                        <h5 style="font-size: 18px; font-weight: 700; color: #222; margin-bottom: 25px;">Add New Address</h5>
                        <form action="{{ route('customer.address.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">FULL NAME</label>
                                    <input type="text" name="name" placeholder="Enter first and last name" required
                                           style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                           onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">EMAIL ADDRESS (OPTIONAL)</label>
                                    <input type="email" name="email" placeholder="Enter your email"
                                           style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                           onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">PHONE NUMBER</label>
                                    <input type="text" name="phone" placeholder="Enter your phone number" required
                                           style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                           onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">CITY</label>
                                    <input type="text" name="city" placeholder="E.g. Dhaka, Chittagong" required
                                           style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                           onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">POSTCODE (OPTIONAL)</label>
                                    <input type="text" name="zip_code" placeholder="E.g. 1200"
                                           style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa;"
                                           onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';">
                                </div>
                                <div class="col-12 mb-4">
                                    <label style="font-weight: 700; font-size: 13px; color: #666; margin-bottom: 8px; display: block;">DETAILED ADDRESS</label>
                                    <textarea name="address" placeholder="House no. / building / street / area" required rows="3"
                                              style="width: 100%; padding: 14px 18px; border: 2px solid #f0f0f0; border-radius: 12px; outline: none; transition: 0.3s; font-weight: 600; font-size: 15px; color: #333; background: #fafafa; resize: none;"
                                              onfocus="this.style.border='2px solid #e44d26'; this.style.background='white';"></textarea>
                                </div>
                                <div class="col-12 text-right">
                                    <button type="submit" 
                                            style="background: #e44d26; color: white; border: none; padding: 14px 35px; 
                                                   border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 15px rgba(228, 77, 38, 0.2);"
                                            onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                        Save Address
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @else
                    <div style="background: #fff3cd; color: #856404; padding: 20px; border-radius: 12px; border: 1px solid #ffeeba; font-size: 15px; font-weight: 600; text-align: center;">
                        ⚠️ You have reached the maximum limit of 5 addresses. Please delete an address to add a new one.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
