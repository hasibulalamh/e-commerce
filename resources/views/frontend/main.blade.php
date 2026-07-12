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
                        background-image: url('{{ asset('uploads/banners/' . $banner->image) }}');
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
                    <div class="category-card" style="
                        height: 320px; 
                        position: relative; 
                        overflow: hidden;
                        background: {{ $cat->image ? 'transparent' : $catColors[$index % 5] }};
                        border-radius: 12px;
                        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
                        transition: all 0.3s ease;
                    " onmouseenter="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.15)'"
                       onmouseleave="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.1)'">
                        
                        @if($cat->image)
                            <img src="{{ asset('uploads/' . $cat->image) }}"
                                 loading="lazy"
                                 style="width:100%; height:100%; object-fit:cover;">
                        @endif
                        
                        {{-- Dark Gradient Overlay --}}
                        <div style="position:absolute; inset:0; 
                                    background:linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 70%);">
                        </div>
 
                        {{-- Details --}}
                        <div style="position:absolute; bottom:30px; left:30px; right:30px;">
                            <h3 style="color:white; font-size:1.6rem; 
                                       font-weight:800; margin:0 0 8px 0;
                                       letter-spacing: -0.5px;">
                                {{ $cat->name }}
                            </h3>
                            <a href="{{ route('product.listview', ['category' => $cat->id]) }}"
                               style="color:rgba(255,255,255,0.9); 
                                      font-size:1rem; text-decoration:none;
                                      display:inline-block; border-bottom:1.5px solid rgba(255,255,255,0.6);
                                      padding-bottom:2px; font-weight:600; transition:all 0.3s ease;"
                               onmouseenter="this.style.color='#fff'; this.style.borderBottomColor='#fff'"
                               onmouseleave="this.style.color='rgba(255,255,255,0.9)'; this.style.borderBottomColor='rgba(255,255,255,0.6)'">
                                Shop Now →
                            </a>
                        </div>
                        
                        {{-- Clickable Area --}}
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
                    <div class="row">
                        @foreach($trendingProducts as $products)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                            <div class="product-card" style="
                                height: 320px; 
                                position: relative; 
                                overflow: hidden;
                                background: #f5f5f5;
                                border-radius: 12px;
                                box-shadow: 0 8px 20px rgba(0,0,0,0.1);
                                transition: all 0.3s ease;
                            " onmouseenter="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.15)'"
                               onmouseleave="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.1)'">
                                
                                {{-- Product Image --}}
                                @if($products->image)
                                    <img src="{{ asset('uploads/' . $products->image) }}" 
                                         alt="{{ $products->name }}"
                                         style="width:100%; height:100%; object-fit:cover;">
                                @else
                                    <div style="width:100%; height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; background:#f8f9fa; color:#ccc; border-radius:12px;">
                                        <i class="fas fa-image" style="font-size:3rem; margin-bottom:10px; opacity:0.5;"></i>
                                        <span style="font-size:0.9rem; font-weight:600; text-transform:uppercase; letter-spacing:1px;">No Image</span>
                                    </div>
                                @endif
                                
                                {{-- Dark Gradient Overlay --}}
                                <div style="position:absolute; inset:0; 
                                            background:linear-gradient(to top, rgba(0,0,0,0.75) 0%, transparent 70%);">
                                </div>
 
                                {{-- Badges (Top Left) --}}
                                @if($products->discount > 0)
                                    <div style="position:absolute; top:15px; left:15px; background:#e44d26; color:white; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700; z-index:2;">
                                        {{ round(($products->discount / $products->price) * 100) }}% OFF
                                    </div>
                                @endif
 
                                {{-- Icons (Top Right) --}}
                                <div style="position:absolute; top:15px; right:15px; display:flex; flex-direction:column; gap:8px; z-index:2;">
                                    <a href="{{ route('addto.cart', $products->id) }}" class="ajax-cart-btn" 
                                       style="background:white; color:#333; width:35px; height:35px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(0,0,0,0.1); text-decoration:none; transition:0.3s;"
                                       onmouseenter="this.style.background='#e44d26'; this.style.color='#fff'"
                                       onmouseleave="this.style.background='#fff'; this.style.color='#333'">
                                        <i class="fas fa-shopping-cart" style="font-size:12px;"></i>
                                    </a>
                                </div>
 
                                {{-- Product Details (Bottom) --}}
                                <div style="position:absolute; bottom:25px; left:25px; right:25px; z-index:2;">
                                    <h3 style="color:white; font-weight:800; font-size:1.4rem; margin-bottom:5px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; letter-spacing:-0.5px;">
                                        {{ $products->name }}
                                    </h3>
                                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                        <span style="color:#FFD700; font-weight:800; font-size:1.2rem;">৳{{ number_format($products->final_price, 0) }}</span>
                                        @if($products->discount > 0)
                                            <span style="color:rgba(255,255,255,0.6); text-decoration:line-through; font-size:0.9rem;">৳{{ number_format($products->price, 0) }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('product.details', $products->id) }}" 
                                       style="color:rgba(255,255,255,0.9); font-size:1rem; text-decoration:none; display:inline-block; border-bottom:1.5px solid rgba(255,255,255,0.6); padding-bottom:2px; font-weight:600; transition:0.3s;"
                                       onmouseenter="this.style.color='#fff'; this.style.borderBottomColor='#fff'">
                                        View Details →
                                    </a>
                                </div>
                                
                                {{-- Invisible Full Link --}}
                                <a href="{{ route('product.details', $products->id) }}" style="position:absolute; inset:0; z-index:1;"></a>
                            </div>
                        </div>
                        @endforeach
                    </div>

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
            <div class="row">
                @foreach($youMayLike as $item)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="product-card" style="
                        height: 320px; 
                        position: relative; 
                        overflow: hidden;
                        background: #f5f5f5;
                        border-radius: 12px;
                        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
                        transition: all 0.3s ease;
                    " onmouseenter="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.15)'"
                       onmouseleave="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.1)'">
                        
                        {{-- Product Image --}}
                        @if($item->image)
                            <img src="{{ asset('uploads/' . $item->image) }}" 
                                 alt="{{ $item->name }}"
                                 style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <div style="width:100%; height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; background:#f8f9fa; color:#ccc; border-radius:12px;">
                                <i class="fas fa-image" style="font-size:3rem; margin-bottom:10px; opacity:0.5;"></i>
                                <span style="font-size:0.9rem; font-weight:600; text-transform:uppercase; letter-spacing:1px;">No Image</span>
                            </div>
                        @endif
                        
                        {{-- Dark Gradient Overlay --}}
                        <div style="position:absolute; inset:0; 
                                    background:linear-gradient(to top, rgba(0,0,0,0.75) 0%, transparent 70%);">
                        </div>
 
                        {{-- Icons (Top Right) --}}
                        <div style="position:absolute; top:15px; right:15px; display:flex; flex-direction:column; gap:8px; z-index:2;">
                            <a href="{{ route('addto.cart', $item->id) }}" class="ajax-cart-btn" 
                               style="background:white; color:#333; width:35px; height:35px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(0,0,0,0.1); text-decoration:none; transition:0.3s;"
                               onmouseenter="this.style.background='#e44d26'; this.style.color='#fff'"
                               onmouseleave="this.style.background='#fff'; this.style.color='#333'">
                                <i class="fas fa-shopping-cart" style="font-size:12px;"></i>
                            </a>
                        </div>
 
                        {{-- Product Details (Bottom) --}}
                        <div style="position:absolute; bottom:25px; left:25px; right:25px; z-index:2;">
                            <h3 style="color:white; font-weight:800; font-size:1.4rem; margin-bottom:5px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; letter-spacing:-0.5px;">
                                {{ $item->name }}
                            </h3>
                            <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                <span style="color:#FFD700; font-weight:800; font-size:1.2rem;">৳{{ number_format($item->final_price, 0) }}</span>
                                @if($item->discount > 0)
                                    <span style="color:rgba(255,255,255,0.6); text-decoration:line-through; font-size:0.9rem;">৳{{ number_format($item->price, 0) }}</span>
                                @endif
                            </div>
                            <a href="{{ route('product.details', $item->id) }}" 
                               style="color:rgba(255,255,255,0.9); font-size:1rem; text-decoration:none; display:inline-block; border-bottom:1.5px solid rgba(255,255,255,0.6); padding-bottom:2px; font-weight:600; transition:0.3s;"
                               onmouseenter="this.style.color='#fff'; this.style.borderBottomColor='#fff'">
                                View Details →
                            </a>
                        </div>
                        
                        {{-- Invisible Full Link --}}
                        <a href="{{ route('product.details', $item->id) }}" style="position:absolute; inset:0; z-index:1;"></a>
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