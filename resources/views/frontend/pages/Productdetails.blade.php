@extends('frontend.master')
@section('content')

<main class="product-details-area pt-50 pb-50">
    <div class="container">
        <div class="row">
            <!-- Product Images Column -->
            <div class="col-lg-6">
                <div class="product-image-wrapper">
                    <div class="main-image">
                        <img src="{{ ('/uploads/products/'.$product->image) }}"
                            alt="{{ $product->name }}"
                            class="img-fluid">

                    </div>
                </div>
            </div>

            <!-- Product Info Column -->
            <div class="col-lg-6">
                <div class="product-details-content">
                    <h2 class="product-title mb-3">{{ $product->name }}</h2>

                    <!-- Rating Section
                    <div class="rating-wrapper mb-3">
                        <div class="rating d-inline-block">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <=$product->rating)
                                <i class="fas fa-star text-warning"></i>
                                @else
                                <i class="fas fa-star-half-alt text-warning"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="review-count ml-2">({{ $product->reviews_count ?? 0 }} Reviews)</span>
                    </div> -->

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
                            <div class="mb-2">
                                <small class="text-success">You save: {{ number_format($product->discount_amount, 2) }} BDT</small>
                            </div>
                        @endif
                        <h3 class="current-price text-primary font-weight-bold">
                            {{ number_format($product->final_price, 2) }} BDT
                        </h3>
                    </div>

                    <!-- Description -->
                    <div class="product-description mb-4">
                        <h4>Description</h4>
                        <p>{{ $product->description }}</p>
                    </div>

                    <!-- Add to Cart Form -->
                    <div class="product-description mb-4">
                        <a href="{{route('addto.cart',$product->id)}}" 
                           class="btn btn-primary px-4 py-2" 
                           style="background-color: #007bff; color: white; text-decoration: none;">
                            Add to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Back to Top Button -->
<div id="back-top">
    <a class="wrapper" title="Go to Top" href="#">
        <div class="arrows-container">
            <div class="arrow arrow-one"></div>
            <div class="arrow arrow-two"></div>
        </div>
    </a>
</div>

@endsection