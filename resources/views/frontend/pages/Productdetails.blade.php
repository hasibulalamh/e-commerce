@extends('frontend.master')
@section('content')

<main class="product-details-area pt-50 pb-50">
    <div class="container">
        <div class="row">
            <!-- Product Images Column -->
            <div class="col-lg-6">
                <div class="product-image-wrapper">
                    <div class="main-image shadow-sm rounded overflow-hidden mb-3" style="border: 1px solid #eee; background: #fff;">
                        <img src="{{ asset('upload/products/'.$product->image) }}"
                            id="expandedImg"
                            alt="{{ $product->name }}"
                            class="img-fluid w-100" style="object-fit: contain; height: 500px;">
                    </div>
                    
                    @if($product->productImages->count() > 0)
                    <div class="product-gallery-thumbnails d-flex flex-wrap gap-2">
                        <div class="thumbnail-item active" onclick="changeImage(this, '{{ asset('upload/products/'.$product->image) }}')">
                            <img src="{{ asset('upload/products/'.$product->image) }}" alt="Thumbnail" class="img-fluid rounded border">
                        </div>
                        @foreach($product->productImages as $gallery)
                        <div class="thumbnail-item" onclick="changeImage(this, '{{ asset('upload/products/gallery/'.$gallery->image) }}')">
                            <img src="{{ asset('upload/products/gallery/'.$gallery->image) }}" alt="Thumbnail" class="img-fluid rounded border">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Info Column -->
            <div class="col-lg-6">
                <div class="product-details-content">
                    <h2 class="product-title mb-3">{{ $product->name }}</h2>

                    <!-- Rating Section -->
                    <div class="rating-wrapper mb-3">
                        <div class="rating d-inline-block">
                            @php $avgRating = $product->average_rating; @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($avgRating >= $i)
                                    <i class="fas fa-star text-warning"></i>
                                @elseif($avgRating >= $i - 0.5)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="review-count ml-2">({{ $product->reviews->count() }} Reviews)</span>
                    </div>

                    <!-- Product Details -->
                    <div class="product-info mb-4">
                        <ul class="list-unstyled">
                            <li><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</li>
                            <li><strong>Brand:</strong> {{ $product->brand->name ?? 'N/A' }}</li>
                            <li><strong>Stock Status:</strong>
                                @if($product->stock > 0)
                                <span class="text-success">In Stock ({{ $product->stock }} items)</span>
                                @else
                                <span class="text-danger">Out of Stock</span>
                                @endif
                            </li>
                        </ul>
                    </div>

                    <!-- Price Section -->
                    <div class="price-wrapper mb-4">
                        @if($product->discount > 0)
                            <div class="mb-1">
                                <span class="text-muted" style="text-decoration: line-through; font-size: 1.1rem;">
                                    {{ number_format($product->price, 2) }} BDT
                                </span>
                                <span class="badge bg-danger ml-2">{{ $product->discount }}% OFF</span>
                            </div>
                        @endif
                        <h3 class="current-price text-primary font-weight-bold">
                            {{ number_format($product->final_price, 2) }} BDT
                        </h3>
                    </div>

                    <!-- Available Vouchers -->
                    @if($coupons->count() > 0)
                    <div class="vouchers-section mb-4 p-3 rounded" style="background: #fff9f5; border: 1px dashed #f85606;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-ticket-alt text-primary mr-2" style="color: #f85606 !important;"></i>
                            <h6 class="mb-0 font-weight-bold" style="font-size: 0.9rem;">Available Vouchers</h6>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($coupons as $coupon)
                                @php 
                                    $isCollected = auth('customerg')->check() && auth('customerg')->user()->coupons()->where('coupon_id', $coupon->id)->exists();
                                @endphp
                                <div class="voucher-ticket {{ $isCollected ? 'collected' : '' }}" 
                                     id="voucher-{{ $coupon->id }}"
                                     onclick="{{ $isCollected ? '' : 'collectVoucher('.$coupon->id.')' }}" 
                                     title="{{ $isCollected ? 'Already Collected' : 'Click to Collect' }}">
                                    <div class="vt-left">৳{{ $coupon->value }}{{ $coupon->type == 'percent' ? '%' : '' }}</div>
                                    <div class="vt-right" id="voucher-text-{{ $coupon->id }}">
                                        {{ $isCollected ? 'COLLECTED' : 'COLLECT' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted mt-2 d-block" style="font-size: 10px;">* Vouchers must be collected to use at checkout.</small>
                    </div>
                    @endif

                    <!-- Description -->
                    <div class="product-description mb-4">
                        <h4>Description</h4>
                        <p>{{ $product->description }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="product-actions d-flex align-items-center mb-4">
                        <a href="{{route('addto.cart',$product->id)}}" 
                           class="btn btn-primary px-4 py-2 mr-3" 
                           style="background-color: #007bff; color: white; text-decoration: none;">
                            Add to Cart
                        </a>
                        
                        <button class="btn btn-outline-danger wishlist-toggle-btn" data-id="{{ $product->id }}">
                            <i class="{{ auth('customerg')->check() && auth('customerg')->user()->wishlists()->where('product_id', $product->id)->exists() ? 'fas' : 'far' }} fa-heart"></i>
                            Wishlist
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="row mt-50">
            <div class="col-12">
                <div class="reviews-wrapper border-top pt-40">
                    <h3 class="mb-30">Customer Reviews</h3>
                    
                    <div class="row">
                        <!-- Review List -->
                        <div class="col-lg-7">
                            @if($product->reviews->count() > 0)
                                @foreach($product->reviews as $review)
                                    <div class="single-review mb-30 p-3 border rounded">
                                        <div class="review-header d-flex justify-content-between mb-2">
                                            <h6 class="font-weight-bold mb-0">{{ $review->customer->name }}</h6>
                                            <div class="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-warning"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="mb-1">{{ $review->comment }}</p>
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted italic">No reviews yet. Be the first to review this product!</p>
                            @endif
                        </div>

                        <!-- Review Form -->
                        <div class="col-lg-5">
                            <div class="review-form-area p-4 bg-light rounded shadow-sm">
                                <h5 class="mb-3 font-weight-bold">Write a Review</h5>
                                <form action="{{ route('customer.product.review') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div class="form-group mb-4 text-center">
                                        <label class="d-block mb-2 font-weight-bold" style="font-size: 1.1rem;">Rate this Product</label>
                                        <div class="star-rating-input">
                                            @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" id="rate{{ $i }}" name="rating" value="{{ $i }}" required>
                                                <label for="rate{{ $i }}" title="{{ $i }} stars">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Share your experience</label>
                                        <textarea name="comment" class="form-control" rows="4" placeholder="Write your review here..." style="border-radius: 12px; border: 1px solid #ddd;"></textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary btn-block py-2 font-weight-bold" style="border-radius: 10px; background: #222; border: none;">
                                        Submit Review
                                    </button>
                                </form>
                                <p class="mt-3 small text-muted">* You can only review products you have purchased and received.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if($relatedProducts->count() > 0)
        <div class="row mt-60">
            <div class="col-12">
                <div class="section-tittle mb-40">
                    <h3 class="font-weight-bold">Related Products</h3>
                </div>
            </div>
            @foreach($relatedProducts as $rp)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="properties pb-30">
                    <div class="properties-card shadow-sm rounded overflow-hidden">
                        <div class="properties-img">
                            <a href="{{ route('product.details', $rp->id) }}">
                                <div style="height: 220px; overflow: hidden; background: #fff; border-bottom: 1px solid #eee;">
                                    <img src="{{ asset('upload/products/'.$rp->image) }}" alt="{{ $rp->name }}" style="width:100%; height:100%; object-fit:contain;">
                                </div>
                            </a>
                        </div>
                        <div class="properties-caption p-3">
                            <h3 style="font-size: 1rem; margin-bottom: 10px;">
                                <a href="{{ route('product.details', $rp->id) }}" class="text-dark">{{ $rp->name }}</a>
                            </h3>
                            <div class="price">
                                <span class="text-primary font-weight-bold">৳{{ number_format($rp->final_price, 2) }}</span>
                                @if($rp->discount > 0)
                                    <span class="text-muted small ml-2" style="text-decoration: line-through;">৳{{ number_format($rp->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</main>

<style>
    /* Star Rating Input Styles */
    .star-rating-input {
        display: inline-flex;
        flex-direction: row-reverse;
        font-size: 2.5rem;
    }

    .star-rating-input input {
        display: none;
    }

    .star-rating-input label {
        color: #ddd;
        cursor: pointer;
        padding: 0 5px;
        transition: all 0.2s ease;
    }

    .star-rating-input input:checked ~ label,
    .star-rating-input label:hover,
    .star-rating-input label:hover ~ label {
        color: #f5b301;
        transform: scale(1.1);
    }

    /* Animation for reviews */
    .single-review {
        transition: transform 0.3s ease;
    }
    .single-review:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    /* Voucher Ticket Styles */
    .voucher-ticket {
        display: flex;
        background: #fff;
        border-radius: 4px;
        overflow: hidden;
        font-size: 12px;
        cursor: pointer;
        border: 1px solid #ffefe0;
        margin-right: 10px;
        margin-bottom: 5px;
        box-shadow: 0 2px 4px rgba(248, 86, 6, 0.05);
        transition: 0.2s;
    }
    .voucher-ticket:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(248, 86, 6, 0.1);
    }
    .vt-left {
        background: #f85606;
        color: #fff;
        padding: 4px 8px;
        font-weight: 700;
        position: relative;
    }
    .vt-left::after {
        content: '';
        position: absolute;
        right: -3px;
        top: 0;
        bottom: 0;
        width: 6px;
        background-image: radial-gradient(circle, #fff9f5 50%, transparent 50%);
        background-size: 6px 6px;
    }
    .vt-right {
        padding: 4px 10px;
        font-weight: 600;
        color: #f85606;
        background: #fff;
    }
    .voucher-ticket.collected {
        cursor: default;
        opacity: 0.8;
        filter: grayscale(0.5);
    }
    .voucher-ticket.collected .vt-left {
        background: #6c757d;
    }
    .voucher-ticket.collected .vt-right {
        color: #6c757d;
    }
    .gap-2 { gap: 0.5rem; }
</style>

<script>
    function collectVoucher(id) {
        $.ajax({
            url: "{{ url('/coupon/collect') }}/" + id,
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                    $('#voucher-' + id).addClass('collected').attr('onclick', '').attr('title', 'Already Collected');
                    $('#voucher-text-' + id).text('COLLECTED');
                } else {
                    showToast(response.message, 'error');
                }
            },
            error: function() {
                showToast('Please login to collect vouchers.', 'error');
            }
        });
    }

    function changeImage(element, src) {
        var expandImg = document.getElementById("expandedImg");
        expandImg.src = src;
        
        // Update active class
        var thumbnails = document.getElementsByClassName("thumbnail-item");
        for (var i = 0; i < thumbnails.length; i++) {
            thumbnails[i].classList.remove("active");
        }
        element.classList.add("active");
    }
</script>

<style>
    .thumbnail-item {
        width: 80px;
        height: 80px;
        cursor: pointer;
        opacity: 0.6;
        transition: 0.3s;
    }
    .thumbnail-item:hover, .thumbnail-item.active {
        opacity: 1;
    }
    .thumbnail-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .thumbnail-item.active img {
        border-color: #f85606 !important;
        border-width: 2px !important;
    }
</style>

@endsection