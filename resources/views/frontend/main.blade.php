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
            <div class="row">
                @foreach($featuredCategories as $cat)
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="single-items mb-20">
                        <div class="items-img" style="height: 300px; overflow: hidden; background: #f5f5f5;">
                            @if($cat->image)
                                <img src="{{ asset('upload/categories/' . $cat->image) }}" alt="{{ $cat->name }}" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/items1.jpg.webp" alt="{{ $cat->name }}" style="width:100%; height:100%; object-fit:cover;">
                            @endif
                        </div>
                        <div class="items-details">
                            <h4 style="color:white; text-shadow: 1px 1px 3px rgba(0,0,0,0.5);"><a href="{{ route('product.listview', ['category' => $cat->id]) }}">{{ $cat->name }}</a></h4>
                            <a href="{{ route('product.listview', ['category' => $cat->id]) }}" class="browse-btn">Shop Now</a>
                        </div>
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
                                        <div style="height: 250px; overflow: hidden; background: #f5f5f5;">
                                            @if($products->image)
                                                <img src="{{ asset('upload/products/' . $products->image) }}" 
                                                     alt="{{ $products->name }}"
                                                     style="width:100%; height:100%; object-fit:cover;">
                                            @else
                                                <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#f0f0f0; color:#999;">
                                                    <span>No Image</span>
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="socal_icon">
                                        <a href="{{route('addto.cart',$products->id)}}"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708" />
                                            </svg></a>
                                        <a href="#"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                                            </svg>
                                        </a>
                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard2-data-fill" viewBox="0 0 16 16">
                                                <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5" />
                                                <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5M10 7a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm4-3a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0V9a1 1 0 0 1 1-1" />
                                            </svg></a>
                                        <a href="{{route('product.details',$products->id)}}"></a>
                                    </div>
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
                                        <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/founder-img.png.webp" alt="">
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
                                        <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/founder-img.png.webp" alt="">
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
                                <div style="height: 250px; overflow: hidden; background: #f5f5f5;">
                                    @if($item->image)
                                        <img src="{{ asset('upload/products/' . $item->image) }}" 
                                             alt="{{ $item->name }}"
                                             style="width:100%; height:100%; object-fit:cover;">
                                    @else
                                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#f0f0f0; color:#999;">
                                            <span>No Image</span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="socal_icon">
                                <a href="{{ route('addto.cart', $item->id) }}"><i class="ti-shopping-cart"></i></a>
                                <a href="#"><i class="ti-heart"></i></a>
                                <a href="{{ route('product.details', $item->id) }}"><i class="ti-zoom-in"></i></a>
                            </div>
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
                            <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/icon/services1.svg" alt="">
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
                            <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/icon/services2.svg" alt="">
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
                            <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/icon/services3.svg" alt="">
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
                            <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/icon/services4.svg" alt="">
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