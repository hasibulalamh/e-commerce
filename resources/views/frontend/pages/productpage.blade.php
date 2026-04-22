@extends('frontend.master')
@section('content')
<main>
    <!-- Hero area Start-->
    <div class="hero-area section-bg2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="slider-area">
                        <div class="slider-height2 slider-bg4 d-flex align-items-center justify-content-center">
                            <div class="hero-caption hero-caption2">
                                <h2>Products</h2>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb justify-content-center">
                                        <li class="breadcrumb-item"><a href="#">Products</a></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="listing-area pt-50 pb-50">
        <div class="container">
            <div class="row">
                <!-- Left sidebar filters -->
                <div class="col-xl-3 col-lg-4 col-md-4">
                    <div class="category-listing mb-50">
                                <div style="background:white; border-radius:8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow:hidden;">
                                    <div style="background:#333; color:white; padding:15px 20px; font-weight:700; font-size:1.1rem;">
                                        Category
                                    </div>
                                    
                                    <a href="{{ route('product.listview') }}"
                                       style="display:block; padding:12px 20px;
                                              color: {{ !request('category') ? '#fff' : '#333' }};
                                              background: {{ !request('category') ? '#e44d26' : 'transparent' }};
                                              border-bottom:1px solid #f0f0f0;
                                              text-decoration:none; font-weight:500;">
                                        All Categories
                                    </a>
                                    
                                    @foreach($categories as $cat)
                                    <a href="{{ route('product.listview', ['category' => $cat->id]) }}"
                                       style="display:block; padding:12px 20px;
                                              color: {{ request('category') == $cat->id ? '#fff' : '#333' }};
                                              background: {{ request('category') == $cat->id ? '#e44d26' : 'transparent' }};
                                              border-bottom:1px solid #f0f0f0;
                                              text-decoration:none; font-weight:500;">
                                        {{ $cat->name }}
                                    </a>
                                    @endforeach
                                </div>
                    </div>
                </div>

                <!--Products grid -->
                <div class="col-xl-9 col-lg-8 col-md-8">
                    <div class="latest-items latest-items2">
                        <div class="row">
                            @foreach($products as $product)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="properties pb-30">
                                    <div class="properties-card">
                                        <div class="properties-img">
                                            <a href="{{route('product.details',$product->id)}}">
                                                <div style="height: 250px; overflow: hidden; position: relative; background: #f5f5f5;">
                                                    @if($product->image)
                                                        <img src="{{ asset('upload/products/' . $product->image) }}" 
                                                             alt="{{ $product->name }}"
                                                             loading="lazy"
                                                             style="width:100%; height:100%; object-fit:cover;">
                                                    @else
                                                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#f0f0f0; color:#999;">
                                                            <span>No Image</span>
                                                        </div>
                                                    @endif

                                                    {{-- Action Buttons --}}
                                                    <div style="position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%); display: flex; flex-direction: row; align-items: center; gap: 6px; white-space: nowrap;">
                                                        <a href="{{ route('addto.cart', $product->id) }}" class="ajax-cart-btn" title="Add to Cart" style="background:#e44d26; color:white; padding:8px 16px; border-radius:4px; text-decoration:none; font-size:13px; font-weight:600; display:inline-block;">
                                                            🛒 Add to Cart
                                                        </a>
                                                        {{-- Wishlist --}}
                                                        <button class="wishlist-toggle-btn" data-id="{{ $product->id }}" 
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
                                                            <i class="{{ auth('customerg')->check() && auth('customerg')->user()->wishlists()->where('product_id', $product->id)->exists() ? 'fas' : 'far' }} fa-heart"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="properties-caption properties-caption2">
                                            <h3><a href="{{route('product.details',$product->id)}}"><span>{{$product->name}}</span></a></h3>
                                            <div class="properties-footerproduct.view">
                                                <div class="price">
                                                    <span>৳{{ number_format($product->final_price, 2) }}</span>
                                                    @if($product->discount > 0)
                                                        <span style="text-decoration: line-through; color: #888; margin-left: 10px; font-size: 0.9em;">৳{{ number_format($product->price, 2) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="row">
                            <div class="col-12">
                                @if(method_exists($products, 'links'))
                                    {{ $products->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Scroll Up -->
<div id="back-top">
    <a class="wrapper" title="Go to Top" href="#">
        <div class="arrows-container">
            <div class="arrow arrow-one">
            </div>
            <div class="arrow arrow-two">
            </div>
        </div>
    </a>
</div>

@endsection
