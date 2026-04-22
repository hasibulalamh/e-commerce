@extends('frontend.master')

@section('title', 'Secure Checkout | Capital Shop')

@section('content')
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-color: #f85606; /* Daraz Orange */
        --secondary-color: #2b3445;
        --bg-light: #f4f6f9;
        --border-radius: 12px;
        --card-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-light);
    }

    .checkout-container {
        padding-top: 40px;
        padding-bottom: 80px;
    }

    .card-modern {
        background: #fff;
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .card-header-modern {
        background: #fff;
        padding: 20px 24px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-header-modern h5 {
        margin: 0;
        font-weight: 700;
        color: var(--secondary-color);
        font-size: 1.1rem;
    }

    .header-icon {
        width: 36px;
        height: 36px;
        background: rgba(248, 86, 6, 0.1);
        color: var(--primary-color);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    /* Form Styles */
    .form-group-modern {
        margin-bottom: 20px;
    }

    .form-label-modern {
        font-weight: 600;
        font-size: 0.85rem;
        color: #4b5563;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-modern {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.95rem;
        transition: all 0.2s;
        background: #fff;
    }

    .form-control-modern:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(248, 86, 6, 0.1);
        outline: none;
    }

    /* Payment Methods */
    .payment-option-modern {
        position: relative;
        padding: 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .payment-option-modern:hover {
        border-color: var(--primary-color);
        background: rgba(248, 86, 6, 0.02);
    }

    .payment-option-modern.active {
        border-color: var(--primary-color);
        background: rgba(248, 86, 6, 0.05);
    }

    .payment-icon {
        width: 48px;
        height: 48px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    /* Voucher / Ticket Styles (Daraz Style) */
    .voucher-card {
        background: #fff;
        border-radius: 10px;
        display: flex;
        overflow: hidden;
        margin-bottom: 15px;
        border: 1px solid #ffefe0;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .voucher-card:hover {
        transform: scale(1.02);
    }

    .voucher-left {
        background: var(--primary-color);
        color: #fff;
        padding: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 80px;
        position: relative;
    }

    .voucher-left::after {
        content: '';
        position: absolute;
        right: -5px;
        top: 0;
        bottom: 0;
        width: 10px;
        background-image: radial-gradient(circle, #fff 50%, transparent 50%);
        background-size: 10px 10px;
    }

    .voucher-right {
        flex: 1;
        padding: 15px;
        background: #fff9f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .voucher-code {
        font-weight: 700;
        font-size: 1rem;
        color: var(--secondary-color);
        letter-spacing: 1px;
    }

    /* Sticky Summary */
    .summary-sidebar {
        position: sticky;
        top: 100px;
    }

    .btn-place-order {
        background: var(--primary-color);
        border: none;
        padding: 16px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        color: #fff;
        width: 100%;
        transition: transform 0.2s, background 0.2s;
        box-shadow: 0 10px 20px rgba(248, 86, 6, 0.2);
    }

    .btn-place-order:hover {
        background: #e04b00;
        transform: translateY(-2px);
    }

    .total-amount {
        font-size: 1.5rem;
        color: var(--primary-color);
        font-weight: 800;
    }
</style>

<div class="checkout-container container">
    <form action="{{ route('placeorder.store') }}" method="POST" id="checkout-form">
        @csrf
        <div class="row g-4">
            {{-- Main Content --}}
            <div class="col-lg-8">
                {{-- Shipping Information --}}
                <div class="card-modern">
                    <div class="card-header-modern">
                        <div class="header-icon"><i class="fas fa-truck"></i></div>
                        <h5>Shipping Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">FULL NAME</label>
                                    <input type="text" name="name" class="form-control-modern" value="{{ old('name', Auth::guard('customerg')->user()->name) }}" placeholder="Enter your full name" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">PHONE NUMBER</label>
                                    <input type="text" name="phone" class="form-control-modern" value="{{ old('phone') }}" placeholder="01XXXXXXXXX" required>
                                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">EMAIL ADDRESS</label>
                                    <input type="email" name="email" class="form-control-modern" value="{{ old('email', Auth::guard('customerg')->user()->email) }}" placeholder="yourname@example.com" required>
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">STREET ADDRESS</label>
                                    <input type="text" name="address" class="form-control-modern" value="{{ old('address') }}" placeholder="Apartment, suite, unit, etc." required>
                                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">CITY</label>
                                    <input type="text" name="city" class="form-control-modern" value="{{ old('city') }}" placeholder="e.g. Dhaka" required>
                                    @error('city') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">DELIVERY ZONE</label>
                                    <select name="delivery_zone" id="delivery_zone" class="form-select form-control-modern" style="background: #f8f9fa;" required>
                                        <option value="inside_dhaka">Inside Dhaka (৳70)</option>
                                        <option value="outside_dhaka">Outside Dhaka (৳130)</option>
                                    </select>
                                    @error('delivery_zone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">ZIP CODE</label>
                                    <input type="text" name="postal_code" class="form-control-modern" value="{{ old('postal_code') }}" placeholder="1200">
                                    @error('postal_code') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Available Vouchers (BOX List) --}}
                <div class="card-modern" id="available_vouchers_section" style="{{ session('coupon') ? 'display:none;' : 'display:block;' }}">
                    <div class="card-header-modern">
                        <div class="header-icon"><i class="fas fa-ticket-alt"></i></div>
                        <h5>Available Vouchers</h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted small mb-4">Click on a voucher to apply it to your order.</p>
                        <div class="row g-3">
                            @forelse($availableCoupons as $coupon)
                                <div class="col-md-6">
                                    <div class="voucher-card shadow-sm" onclick="applyVoucher('{{ $coupon->code }}')">
                                        <div class="voucher-left">
                                            <i class="fas fa-percentage"></i>
                                            <small class="fw-bold mt-1" style="font-size: 8px;">GET</small>
                                        </div>
                                        <div class="voucher-right">
                                            <div>
                                                <div class="voucher-code text-uppercase">{{ $coupon->code }}</div>
                                                <small class="text-muted d-block" style="font-size: 10px;">
                                                    @if($coupon->type == 'percent')
                                                        {{ $coupon->value }}% OFF
                                                    @else
                                                        ৳{{ $coupon->value }} OFF
                                                    @endif
                                                    (Min. ৳{{ $coupon->min_purchase }})
                                                </small>
                                            </div>
                                            <div class="btn btn-sm btn-outline-primary py-0" style="font-size: 10px; border-radius: 20px;">APPLY</div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-4">
                                    <div class="text-muted opacity-50 mb-2"><i class="fas fa-ticket-alt fa-3x"></i></div>
                                    <p class="text-muted">No vouchers available at the moment.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="card-modern">
                    <div class="card-header-modern">
                        <div class="header-icon"><i class="fas fa-wallet"></i></div>
                        <h5>Payment Method</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="payment-options">
                            <label class="payment-option-modern active">
                                <input type="radio" name="payment_method" value="cod" class="d-none" checked>
                                <div class="payment-icon">💵</div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">Cash on Delivery</h6>
                                    <p class="text-muted small mb-0">Pay when you receive the product.</p>
                                </div>
                                <div class="check-icon text-primary"><i class="fas fa-check-circle"></i></div>
                            </label>

                            <label class="payment-option-modern">
                                <input type="radio" name="payment_method" value="online" class="d-none">
                                <div class="payment-icon">💳</div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">SSLCommerz</h6>
                                    <p class="text-muted small mb-0">Pay securely with Cards or Mobile Banking.</p>
                                </div>
                                <div class="check-icon text-muted"><i class="far fa-circle"></i></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="summary-sidebar">
                    <div class="card-modern">
                        <div class="card-header-modern">
                            <h5>Order Summary</h5>
                        </div>
                        <div class="card-body p-4">
                            {{-- Products --}}
                            <div class="mb-4">
                                @php $subtotal = 0; @endphp
                                @if(session('cart'))
                                    @foreach(session('cart') as $item)
                                        @php $subtotal += $item['price'] * $item['quantity']; @endphp
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="position-relative">
                                                <img src="{{ asset('upload/products/' . ($item['image'] ?? 'default.jpg')) }}" 
                                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" style="font-size: 9px;">
                                                    {{ $item['quantity'] }}
                                                </span>
                                            </div>
                                            <div class="ms-3 flex-grow-1">
                                                <p class="mb-0 small fw-bold text-truncate" style="max-width: 150px;">{{ $item['name'] }}</p>
                                                <small class="text-muted">৳{{ number_format($item['price'], 2) }}</small>
                                            </div>
                                            <div class="fw-bold small">৳{{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <hr class="my-4" style="border-style: dashed;">

                            {{-- Applied Coupon Card (BOX) --}}
                            <div id="applied_coupon_area" style="{{ session('coupon') ? 'display:block;' : 'display:none;' }}" class="mb-4">
                                <div class="voucher-card shadow-sm">
                                    <div class="voucher-left">
                                        <i class="fas fa-percentage"></i>
                                        <small class="fw-bold mt-1" style="font-size: 8px;">OFFER</small>
                                    </div>
                                    <div class="voucher-right">
                                        <div>
                                            <div class="voucher-code text-uppercase" id="display_coupon_code">
                                                {{ session('coupon')['code'] ?? '' }}
                                            </div>
                                            <small class="text-success fw-bold" style="font-size: 10px;">Voucher Applied Successfully!</small>
                                        </div>
                                        <a href="{{ route('customer.coupon.remove') }}" class="text-danger p-2" title="Remove Voucher">
                                            <i class="fas fa-times-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Calculations --}}
                            <div class="space-y-3">
                                <div class="d-flex justify-content-between text-muted mb-2">
                                    <span class="small">Merchandise Subtotal</span>
                                    <span class="small fw-bold">৳<span id="display_subtotal">{{ number_format($subtotal, 2, '.', '') }}</span></span>
                                </div>
                                <div class="d-flex justify-content-between text-muted mb-2">
                                    <span class="small">Shipping Fee</span>
                                    <span class="small fw-bold">৳<span id="display_shipping">70.00</span></span>
                                </div>
                                <div id="discount_row" class="justify-content-between mb-2" style="{{ session('coupon') ? 'display:flex;' : 'display:none;' }}">
                                    <span class="small text-success">Voucher Discount</span>
                                    <span class="small fw-bold text-success">- ৳<span id="display_discount">{{ number_format(session('coupon')['discount'] ?? 0, 2, '.', '') }}</span></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <span class="fw-bold" style="color: #333;">Total Payment</span>
                                    <span class="total-amount">
                                        ৳<span id="display_total">{{ number_format(($subtotal + 70) - (session('coupon')['discount'] ?? 0), 2, '.', '') }}</span>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn-place-order mt-4">
                                PLACE ORDER
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('js')
<script>
    function applyVoucher(code) {
        $.ajax({
            url: "{{ route('customer.coupon.apply') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                code: code
            },
            success: function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                    $('#available_vouchers_section').fadeOut();
                    $('#display_coupon_code').text(code.toUpperCase());
                    $('#applied_coupon_area').fadeIn().css('display', 'block');
                    $('#display_discount').text(response.discount.toFixed(2));
                    $('#discount_row').css('display', 'flex');
                    $('#display_total').text('৳' + response.new_total.toLocaleString('en-US', {minimumFractionDigits: 2}));
                } else {
                    showToast(response.message, 'error');
                }
            },
            error: function() {
                showToast('Connection error. Please try again.', 'error');
            }
        });
    }

    $('.payment-option-modern').on('click', function() {
        $('.payment-option-modern').removeClass('active');
        $('.payment-option-modern .check-icon').html('<i class="far fa-circle text-muted"></i>');
        
        $(this).addClass('active');
        $(this).find('.check-icon').html('<i class="fas fa-check-circle text-primary"></i>');
        $(this).find('input[name="payment_method"]').prop('checked', true);

        // Update form action based on payment method
        const method = $(this).find('input[name="payment_method"]').val();
        if (method === 'online') {
            $('#checkout-form').attr('action', "{{ route('payment.sslcommerz') }}");
        } else {
            $('#checkout-form').attr('action', "{{ route('placeorder.store') }}");
        }
    });

    // Handle Delivery Zone Change
    $('#delivery_zone').on('change', function() {
        updateTotal();
    });

    function updateTotal() {
        const shippingInsideDhaka = {{ \App\Models\Setting::get('shipping_charge_dhaka', 70) }};
        const shippingOutsideDhaka = {{ \App\Models\Setting::get('shipping_charge_outside', 130) }};
        const zone = $('#delivery_zone').val();
        let shipping = (zone === 'inside_dhaka') ? shippingInsideDhaka : shippingOutsideDhaka;
        
        // Check if free delivery coupon is active
        const isFreeDelivery = @json(session('coupon')['is_free_delivery'] ?? false);
        if (isFreeDelivery) {
            shipping = 0;
        }

        $('#display_shipping').text(shipping.toFixed(2));
        
        const subtotal = parseFloat($('#display_subtotal').text());
        const discount = parseFloat($('#display_discount').text() || 0);
        const total = (subtotal + shipping) - discount;
        
        $('#display_total').text(total.toFixed(2));
    }

    // Initialize on load
    updateTotal();
</script>
@endpush
@endsection
