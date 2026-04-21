@extends('frontend.master')

@section('content')
<main style="background: #f8f9fa; min-height: 80vh; padding: 50px 0;">
    <div class="container">
        <div class="row">
            {{-- Daraz Style Sidebar --}}
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
                                <a href="{{ route('customer.profile') }}" style="color: #555; text-decoration: none; font-weight: 500; transition: 0.2s;" onmouseover="this.style.color='#e44d26'" onmouseout="this.style.color='#555'">My Profile</a>
                            </li>
                            <li style="margin-bottom: 12px;">
                                <a href="{{ route('customer.addresses') }}" style="color: #555; text-decoration: none; font-weight: 500; transition: 0.2s;" onmouseover="this.style.color='#e44d26'" onmouseout="this.style.color='#555'">Address Book</a>
                            </li>
                            <li style="margin-bottom: 12px;">
                                <a href="{{ route('customer.wishlist') }}" style="color: #555; text-decoration: none; font-weight: 500; transition: 0.2s;" onmouseover="this.style.color='#e44d26'" onmouseout="this.style.color='#555'">My Wishlist</a>
                            </li>
                            <li style="margin-bottom: 12px;">
                                <a href="{{ route('customer.vouchers') }}" style="color: #e44d26; text-decoration: none; font-weight: 700;">My Vouchers</a>
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

            {{-- Main Content --}}
            <div class="col-lg-9">
                <h4 style="font-size: 24px; font-weight: 800; color: #222; margin-bottom: 25px;">My Vouchers</h4>

                <div class="row g-4">
                    @forelse($vouchers as $voucher)
                        <div class="col-md-6">
                            <div style="background: white; border-radius: 16px; display: flex; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.03); border: 1px solid #eee; position: relative;">
                                {{-- Left Side --}}
                                <div style="background: #e44d26; color: white; padding: 25px; width: 100px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
                                    <i class="fas fa-percentage" style="font-size: 2rem; opacity: 0.5;"></i>
                                    <div style="font-size: 18px; font-weight: 800; margin-top: 5px;">
                                        {{ $voucher->value }}{{ $voucher->type == 'percent' ? '%' : '' }}
                                    </div>
                                    <small style="font-size: 10px; font-weight: 700;">OFF</small>
                                    
                                    {{-- Scalloped Edge Effect --}}
                                    <div style="position: absolute; right: -5px; top: 0; bottom: 0; width: 10px; background-image: radial-gradient(circle, white 50%, transparent 50%); background-size: 10px 10px;"></div>
                                </div>

                                {{-- Right Side --}}
                                <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column; justify-content: center;">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                        <div>
                                            <h6 style="font-size: 16px; font-weight: 800; color: #222; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px;">{{ $voucher->code }}</h6>
                                            <p style="font-size: 12px; color: #666; margin-bottom: 0;">Min. spend ৳{{ number_format($voucher->min_purchase, 2) }}</p>
                                        </div>
                                        @if($voucher->pivot->is_used)
                                            <span style="background: #f8f9fa; color: #6c757d; font-size: 10px; font-weight: 700; padding: 4px 10px; border-radius: 20px; border: 1px solid #ddd;">USED</span>
                                        @else
                                            <span style="background: rgba(40,167,69,0.1); color: #28a745; font-size: 10px; font-weight: 700; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(40,167,69,0.2);">ACTIVE</span>
                                        @endif
                                    </div>
                                    
                                    <div style="margin-top: 15px; border-top: 1px dashed #eee; padding-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                                        <small style="font-size: 10px; color: #888;">Collected: {{ \Carbon\Carbon::parse($voucher->pivot->collected_at)->format('d M Y') }}</small>
                                        @if(!$voucher->pivot->is_used)
                                            <a href="{{ route('Home') }}" style="font-size: 12px; color: #e44d26; font-weight: 700; text-decoration: none;">Use Now →</a>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($voucher->product_id)
                                    <div style="position: absolute; top: 0; right: 0; background: #222; color: white; font-size: 8px; font-weight: 800; padding: 2px 8px; border-bottom-left-radius: 8px; text-transform: uppercase;">
                                        Product Specific
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <div style="font-size: 4rem; color: #eee; margin-bottom: 20px;"><i class="fas fa-ticket-alt"></i></div>
                            <h5 style="color: #888;">You haven't collected any vouchers yet.</h5>
                            <p style="color: #aaa; margin-bottom: 25px;">Check product pages to collect available vouchers!</p>
                            <a href="{{ route('Home') }}" style="background: #e44d26; color: white; padding: 12px 30px; border-radius: 8px; font-weight: 700; text-decoration: none; display: inline-block;">Start Shopping</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .voucher-card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: 0.3s;
    }
</style>
@endsection
