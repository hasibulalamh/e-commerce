@extends('frontend.master')
@section('content')

<main>
    <!-- slider Area Start-->
    <section class="slider-area ">
        <div class="slider-active">
            <!-- Single Slider -->
            <div class="single-slider slider-bg1 slider-height d-flex align-items-center">
                <div class="container">
                    <div class="rowr">
                        <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-8  col-sm-10">
                            <div class="hero-caption text-center">
                                <span>Fashion Sale</span>
                                <h1 data-animation="bounceIn" data-delay="0.2s">Minimal Menz Style</h1>
                                <p data-animation="fadeInUp" data-delay="0.4s">Consectetur adipisicing elit. Laborum fuga incidunt laboriosam voluptas iure, delectus dignissimos facilis neque nulla earum.</p>
                                <a href="#" class="btn_1 hero-btn" data-animation="fadeInUp" data-delay="0.7s">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Single Slider -->
            <div class="single-slider slider-bg2 slider-height d-flex align-items-center">
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-8 col-sm-10">
                            <div class="hero-caption text-center">
                                <span>Fashion Sale</span>
                                <h1 data-animation="bounceIn" data-delay="0.2s">Minimal Menz Style</h1>
                                <p data-animation="fadeInUp" data-delay="0.4s">Consectetur adipisicing elit. Laborum fuga incidunt laboriosam voluptas iure, delectus dignissimos facilis neque nulla earum.</p>
                                <a href="#" class="btn_1 hero-btn" data-animation="fadeInUp" data-delay="0.7s">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- slider Area End-->
    <!-- items Product 1  Start-->
    <section class="items-product1 pt-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="single-items mb-20">
                        <div class="items-img">
                            <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/items1.jpg.webp" alt="">
                        </div>
                        <div class="items-details">
                            <h4><a href="pro-details.html">Men's Fashion</a></h4>
                            <a href="pro-details.html" class="browse-btn">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="single-items mb-20">
                        <div class="items-img">
                            <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/items2.jpg.webp" alt="">
                        </div>
                        <div class="items-details">
                            <h4><a href="pro-details.html">Women's Fashion</a></h4>
                            <a href="pro-details.html" class="browse-btn">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="single-items mb-20">
                        <div class="items-img">
                            <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/items3.jpg.webp" alt="">
                        </div>
                        <div class="items-details">
                            <h4><a href="pro-details.html">Baby Fashion</a></h4>
                            <a href="pro-details.html" class="browse-btn">Shop Now</a>
                        </div>
                    </div>
                </div>
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
                                <a class="nav-link active" id="nav-one-tab" data-bs-toggle="tab" href="#nav-one" role="tab" aria-controls="nav-one" aria-selected="true">Men</a>
                                <a class="nav-link" id="nav-two-tab" data-bs-toggle="tab" href="#nav-two" role="tab" aria-controls="nav-two" aria-selected="false">Women</a>
                                <a class="nav-link" id="nav-three-tab" data-bs-toggle="tab" href="#nav-three" role="tab" aria-controls="nav-three" aria-selected="false">Baby</a>
                                <a class="nav-link" id="nav-four-tab" data-bs-toggle="tab" href="#nav-four" role="tab" aria-controls="nav-four" aria-selected="false">Fashion</a>
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
                <div class="tab-pane fade" id="nav-two" role="tabpanel" aria-labelledby="nav-two-tab">
                    <!-- Tab 2 -->
                    <div class="latest-items-active">
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest1.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest2.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest3.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest4.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest2.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest4.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-three" role="tabpanel" aria-labelledby="nav-three-tab">
                    <!-- Tab 3 -->
                    <div class="latest-items-active">
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest1.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest2.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest3.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest4.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest2.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest4.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-four" role="tabpanel" aria-labelledby="nav-four-tab">
                    <!-- Tab 4 -->
                    <div class="latest-items-active">
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest1.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest2.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest3.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest4.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest2.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single -->
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="pro-details.html"><img src="https://preview.colorlib.com/theme/capitalshop/assets/img/gallery/latest4.jpg.webp" alt=""></a>
                                    <div class="socal_icon">
                                        <a href="#"><i class="ti-shopping-cart"></i></a>
                                        <a href="#"><i class="ti-heart"></i></a>
                                        <a href="#"><i class="ti-zoom-in"></i></a>
                                    </div>
                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="pro-details.html">Cashmere Tank + Bag</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <span>$98.00 <span>$120.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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