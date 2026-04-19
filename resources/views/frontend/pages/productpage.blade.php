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
                        <div class="single-listing">
                            <div class="select-job-items2 mb-30">
                                <div class="select-categories">
                                    <h4 class="mb-20">Category</h4>
                                    <div class="list-group">
                                        <a href="{{ route('product.listview') }}" class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                                            All Categories
                                        </a>
                                        @foreach($categories as $cat)
                                        <a href="{{ route('product.listview', ['category' => $cat->id]) }}" class="list-group-item list-group-item-action {{ request('category') == $cat->id ? 'active' : '' }}">
                                            {{ $cat->name }}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Products grid -->
                <div class="col-xl-9 col-lg-8 col-md-8">
                    <div class="latest-items latest-items2">
                        <div class="row">
                            @foreach($products as $product)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="properties pb-30">
                                    <div class="properties-card">
                                        <div class="properties-img">
                                            <a href="{{ route('product.details', $product->id) }}">
                                                <img src="{{ asset('uploads/products/'.$product->image) }}" alt="{{ $product->name }}">
                                            </a>
                                            <div class="socal_icon">
                                                <a href="{{route('addto.cart',$product->id)}}"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
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
                                            </div>
                                        </div>
                                        <div class="properties-caption properties-caption2">
                                            <h3><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></h3>
                                            <div class="properties-footer">
                                                <div class="price">
                                                    @if($product->discount > 0)
                                                        <span class="text-muted" style="text-decoration: line-through; font-size: 0.9rem;">
                                                            {{ number_format($product->price, 2) }} BDT
                                                        </span>
                                                        <span class="badge bg-danger text-white ml-1" style="font-size: 0.7rem;">{{ $product->discount }}% OFF</span>
                                                        <br>
                                                    @endif
                                                    <span class="text-primary font-weight-bold" style="font-size: 1.1rem;">
                                                        {{ number_format($product->final_price, 2) }} BDT
                                                    </span>
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
