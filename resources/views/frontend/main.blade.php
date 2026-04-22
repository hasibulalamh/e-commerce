@extends('frontend.master')
@section('content')

<main>
    <!-- slider Area Start-->
    <!-- slider Area Start-->
    <section class="slider_area">
        <div id="customSlider" class="owl-carousel owl-theme">
            @forelse($banners as $banner)
            <div class="item">
                <div style="
                    height: 600px;
                    position: relative;
                    overflow: hidden;
                    display: flex;
                    align-items: center;
                    @if($banner->image)
                        background-image: url('{{ asset('upload/banners/' . $banner->image) }}');
                        background-size: cover;
                        background-position: center;
                    @else
                        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
                    @endif
                ">
                    {{-- Dark overlay --}}
                    <div style="position:absolute; inset:0; 
                                background:rgba(0,0,0,0.45);"></div>
                    
                    {{-- Content --}}
                    <div style="position:relative; z-index:2; 
                                padding-left: 80px; max-width: 650px;">
                        @if($banner->subtitle)
                        <p style="color:#FFD700; font-size:1.3rem; 
                                  font-style:italic; margin-bottom:8px;
                                  font-family: Georgia, serif;">
                            {{ $banner->subtitle }}
                        </p>
                        @endif
                        
                        <h1 style="color:#ffffff; font-size:3.5rem; 
                                   font-weight:800; line-height:1.2;
                                   margin-bottom:15px; 
                                   text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
                            {{ $banner->title }}
                        </h1>
                        
                        @if($banner->description)
                        <p style="color:rgba(255,255,255,0.9); 
                                  font-size:1.1rem; margin-bottom:35px;
                                  line-height:1.6;">
                            {{ $banner->description }}
                        </p>
                        @endif
                        
                        <a href="{{ $banner->button_url ?? '#' }}"
                           style="display:inline-block;
                                  background:#000000; color:#ffffff;
                                  padding:16px 45px;
                                  font-size:0.9rem; font-weight:700;
                                  letter-spacing:3px;
                                  text-transform:uppercase;
                                  text-decoration:none;
                                  transition:all 0.3s ease;
                                  border: 2px solid #000;">
                            {{ $banner->button_text ?? 'SHOP NOW' }}
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="item">
                <div style="height:600px; background:linear-gradient(135deg,#667eea,#764ba2);
                            display:flex; align-items:center; padding-left:80px;">
                    <div>
                        <h1 style="color:#fff; font-size:3.5rem; font-weight:800;">
                            Welcome to Capital Shop
                        </h1>
                        <a href="{{ route('product.listview') }}"
                           style="display:inline-block; background:#000; color:#fff;
                                  padding:16px 45px; text-decoration:none;
                                  text-transform:uppercase; font-weight:700;
                                  letter-spacing:3px; margin-top:20px;">
                            SHOP NOW
                        </a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </section>
    <!-- slider Area End-->
    <!-- slider Area End-->
    <!-- items Product 1  Start-->
    <section class="items-product1 pt-30">
        <div class="container">
            @php
            $catColors = ['#e44d26', '#2c3e50', '#27ae60', '#8e44ad', '#e67e22'];
            @endphp
            <div class="row">
                @foreach($featuredCategories as $index => $cat)
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div style="
                        height: 300px; 
                        position: relative; 
                        overflow: hidden;
                        background: {{ $cat->image ? 'transparent' : $catColors[$index % 5] }};
                        border-radius: 8px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                    ">
                        @if($cat->image)
                            <img src="{{ asset('upload/categories/' . $cat->image) }}"
                                 loading="lazy" width="400" height="300"
                                 style="width:100%; height:100%; object-fit:cover;">
                        @endif
                        
                        {{-- Overlay --}}
                        <div style="position:absolute; inset:0; 
                                    background:rgba(0,0,0,0.35); transition: background 0.3s ease;"
                             onmouseenter="this.style.background='rgba(0,0,0,0.2)'"
                             onmouseleave="this.style.background='rgba(0,0,0,0.35)'">
                        </div>

                        {{-- Details --}}
                        <div style="position:absolute; bottom:25px; left:25px; right:25px;">
                            <h5 style="color:white; font-size:1.4rem; 
                                       font-weight:700; margin:0 0 5px 0;
                                       text-shadow:1px 1px 4px rgba(0,0,0,0.6);">
                                {{ $cat->name }}
                            </h5>
                            <a href="{{ route('product.listview', ['category' => $cat->id]) }}"
                               style="color:rgba(255,255,255,0.9); 
                                      font-size:0.9rem; text-decoration:none;
                                      display:inline-block; border-bottom:1px solid rgba(255,255,255,0.5);
                                      padding-bottom:2px; font-weight:500; transition:all 0.3s ease;"
                               onmouseenter="this.style.color='#fff'; this.style.borderBottomColor='#fff'"
                               onmouseleave="this.style.color='rgba(255,255,255,0.9)'; this.style.borderBottomColor='rgba(255,255,255,0.5)'">
                                Shop Now →
                            </a>
                        </div>
                        
                        {{-- Hidden Link for the whole card --}}
                        <a href="{{ route('product.listview', ['category' => $cat->id]) }}" 
                           style="position:absolute; inset:0; z-index:1;"></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--items Product  End -->
    <!-- Latest-items Start -->
    <div class="latest-items section-padding fix">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xl-12">
                    <div class="nav-button">
                        <!--Nav Button  -->
                        <nav>
                            <div class="nav-tittle">
                                <h2>Trending This Week</h2>
                            </div>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-link active" href="{{ route('product.listview') }}">All</a>
                                @foreach($featuredCategories as $cat)
                                    <a class="nav-link" href="{{ route('product.listview', ['category' => $cat->id]) }}">{{ $cat->name }}</a>
                                @endforeach
                            </div>
                        </nav>
                        <!--End Nav Button  -->
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <!-- Nav Card -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-one" role="tabpanel" aria-labelledby="nav-one-tab">
                    <!-- Tab 1 -->
                    <div class="latest-items-active">
                        <!-- Single -->
                        
                        @foreach($trendingProducts as $products)

                        <div class="properties pb-30">
                            <div class="properties-card">

                                <div class="properties-img">

                                    <a href="{{route('product.details',$products->id)}}">
                                        <div style="height: 250px; overflow: hidden; position: relative; background: #f5f5f5;">
                                            @if($products->image)
                                                <img src="{{ asset('upload/products/' . $products->image) }}" 
                                                     alt="{{ $products->name }}"
                                                     loading="lazy" width="400" height="250"
                                                     style="width:100%; height:100%; object-fit:cover;">
                                            @else
                                                <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#f0f0f0; color:#999;">
                                                    <span>No Image</span>
                                                </div>
                                            @endif

                                            {{-- Action Buttons --}}
                                            <div style="position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%); display: flex; flex-direction: row; align-items: center; gap: 6px; white-space: nowrap;">
                                                <a href="{{ route('addto.cart', $products->id) }}" class="ajax-cart-btn" title="Add to Cart" style="background:#e44d26; color:white; padding:8px 16px; border-radius:4px; text-decoration:none; font-size:13px; font-weight:600; display:inline-block;">
                                                    🛒 Add to Cart
                                                </a>
                                                {{-- Wishlist --}}
                                                <button class="wishlist-toggle-btn" data-id="{{ $products->id }}" 
                                                        style="background: white; 
                                                               color: #e44d26;
                                                               padding: 8px 12px; 
                                                               border-radius: 4px;
                                                               border: 2px solid #e44d26;
                                                               line-height: 1;
                                                               cursor: pointer;
                                                               transition: 0.3s;"
                                                        onmouseover="this.style.background='#e44d26'; this.querySelector('i').style.color='white';"
                                                        onmouseleave="this.style.background='white'; this.querySelector('i').style.color='#e44d26';">
                                                    <i class="{{ auth('customerg')->check() && auth('customerg')->user()->wishlists()->where('product_id', $products->id)->exists() ? 'fas' : 'far' }} fa-heart"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="{{route('product.details',$products->id)}}"><span>{{$products->name}}</span></a></h3>
                                    <div class="properties-footerproduct.view">
                                        <div class="price">
                                            <span>৳{{ number_format($products->final_price, 2) }}</span>
                                            @if($products->discount > 0)
                                                <span style="text-decoration: line-through; color: #888; margin-left: 10px; font-size: 0.9em;">৳{{ number_format($products->price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                {{-- Secondary tabs removed to maintain clean dynamic state. Only nav-one (dynamic) is used. --}}
            </div>
        </div>
    </div>
    <!-- Latest-items End -->
    <!-- Testimonial Start -->
    <div class="testimonial-area testimonial-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-10 col-md-11">
                    <div class="h1-testimonial-active">
                        <!-- Single Testimonial -->
                        <div class="single-testimonial text-center">
                            <div class="testimonial-caption ">
                                <div class="testimonial-top-cap">
                                    <h2>Customer Testimonial</h2>
                                    <p>Everybody is different, which is why we offer styles for every body. Laborum fuga incidunt laboriosam voluptas iure, delectus dignissimos facilis neque nulla earum.</p>
                                </div>
                                <!-- founder -->
                                <div class="testimonial-founder d-flex align-items-center justify-content-center">
                                    <div class="founder-img">
                                        <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/founder-img.png.webp" alt="" loading="lazy" width="80" height="80">
                                    </div>
                                    <div class="founder-text">
                                        <span>Petey Cruiser</span>
                                        <p>Designer at Colorlib</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single Testimonial -->
                        <div class="single-testimonial text-center">
                            <div class="testimonial-caption ">
                                <div class="testimonial-top-cap">
                                    <h2>Customer Testimonial</h2>
                                    <p>Everybody is different, which is why we offer styles for every body. Laborum fuga incidunt laboriosam voluptas iure, delectus dignissimos facilis neque nulla earum.</p>
                                </div>
                                <!-- founder -->
                                <div class="testimonial-founder d-flex align-items-center justify-content-center">
                                    <div class="founder-img">
                                        <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/founder-img.png.webp" alt="" loading="lazy">
                                    </div>
                                    <div class="founder-text">
                                        <span>Petey Cruiser</span>
                                        <p>Designer at Colorlib</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
    <!-- Latest-items 02 Start -->
    <section class="latest-items section-padding fix">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-tittle text-center mb-40">
                    <h2>You May Like</h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="latest-items-active">
                @foreach($youMayLike as $item)
                <!-- Single -->
                <div class="properties pb-30">
                    <div class="properties-card">
                        <div class="properties-img">
                            <a href="{{ route('product.details', $item->id) }}">
                                <div style="height: 250px; overflow: hidden; position: relative; background: #f5f5f5;">
                                    @if($item->image)
                                        <img src="{{ asset('upload/products/' . $item->image) }}" 
                                             alt="{{ $item->name }}"
                                             loading="lazy" width="400" height="250"
                                             style="width:100%; height:100%; object-fit:cover;">
                                    @else
                                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#f0f0f0; color:#999;">
                                            <span>No Image</span>
                                        </div>
                                    @endif

                                    {{-- Action Buttons --}}
                                    <div style="position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%); display: flex; flex-direction: row; align-items: center; gap: 6px; white-space: nowrap;">
                                        <a href="{{ route('addto.cart', $item->id) }}" title="Add to Cart" style="background:#e44d26; color:white; padding:8px 16px; border-radius:4px; text-decoration:none; font-size:13px; font-weight:600; display:inline-block;">
                                            🛒 Add to Cart
                                        </a>
                                        {{-- Wishlist --}}
                                        <button class="wishlist-toggle-btn" data-id="{{ $item->id }}" 
                                                style="background: white; 
                                                       color: #e44d26;
                                                       padding: 8px 12px; 
                                                       border-radius: 4px;
                                                       border: 2px solid #e44d26;
                                                       line-height: 1;
                                                       cursor: pointer;
                                                       transition: 0.3s;"
                                                onmouseover="this.style.background='#e44d26'; this.querySelector('i').style.color='white';"
                                                onmouseleave="this.style.background='white'; this.querySelector('i').style.color='#e44d26';">
                                            <i class="{{ auth('customerg')->check() && auth('customerg')->user()->wishlists()->where('product_id', $item->id)->exists() ? 'fas' : 'far' }} fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="properties-caption properties-caption2">
                            <h3><a href="{{ route('product.details', $item->id) }}">{{ $item->name }}</a></h3>
                            <div class="properties-footer">
                                <div class="price">
                                    <span>৳{{ number_format($item->final_price, 2) }}</span>
                                    @if($item->discount > 0)
                                        <span style="text-decoration: line-through; color: #888; font-size: 0.8em;">৳{{ number_format($item->price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Latest-items End -->

    <!-- Services Area Start -->
    <div class="categories-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-cat mb-50 wow fadeInUp text-center" data-wow-duration="1s" data-wow-delay=".2s">
                        <div class="cat-icon">
                            <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/icon/services1.svg" alt="" loading="lazy" width="40" height="40">
                        </div>
                        <div class="cat-cap">
                            <h5>Fast & Free Delivery</h5>
                            <p>Free delivery on all orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-cat mb-50 wow fadeInUp text-center" data-wow-duration="1s" data-wow-delay=".2s">
                        <div class="cat-icon">
                            <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/icon/services2.svg" alt="" loading="lazy" width="40" height="40">
                        </div>
                        <div class="cat-cap">
                            <h5>Secure Payment</h5>
                            <p>Free delivery on all orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-cat mb-50 wow fadeInUp text-center" data-wow-duration="1s" data-wow-delay=".4s">
                        <div class="cat-icon">
                            <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/icon/services3.svg" alt="" loading="lazy" width="40" height="40">
                        </div>
                        <div class="cat-cap">
                            <h5>Money Back Guarantee</h5>
                            <p>Free delivery on all orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-cat mb-50 wow fadeInUp text-center" data-wow-duration="1s" data-wow-delay=".5s">
                        <div class="cat-icon">
                            <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/icon/services4.svg" alt="" loading="lazy" width="40" height="40">
                        </div>
                        <div class="cat-cap">
                            <h5>Online Support</h5>
                            <p>Free delivery on all orders</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services Area End -->
</main>
@endsection

@push('js')
<!-- Owl Carousel Assets -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
    $(window).on('load', function() {
        if (typeof $.fn.owlCarousel !== 'undefined') {
            $("#customSlider").owlCarousel({
                loop: true,
                margin: 0,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                items: 1,
                navText: [
                    '<i class="ti-angle-left" style="color:#fff;font-size:20px;"></i>',
                    '<i class="ti-angle-right" style="color:#fff;font-size:20px;"></i>'
                ]
            });
        } else {
            console.error('OwlCarousel not loaded!');
        }
    });
</script>
@endpush