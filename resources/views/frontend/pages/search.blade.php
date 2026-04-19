@extends('frontend.master')
@section('content')
<main>
    <div class="hero-area section-bg2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="slider-area">
                        <div class="slider-height2 slider-bg4 d-flex align-items-center justify-content-center">
                            <div class="hero-caption hero-caption2">
                                <h2>Search Results</h2>
                                <p>Showing results for: "{{ $query }}"</p>
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
                <div class="col-12">
                    <div class="latest-items latest-items2">
                        <div class="row">
                            @forelse($products as $product)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <div class="properties pb-30">
                                    <div class="properties-card">
                                        <div class="properties-img">
                                            <a href="{{ route('product.details', $product->id) }}">
                                                <img src="{{ asset('uploads/products/'.$product->image) }}" alt="{{ $product->name }}">
                                            </a>
                                            <div class="socal_icon">
                                                <a href="{{route('addto.cart',$product->id)}}">
                                                    <i class="ti-shopping-cart"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="properties-caption properties-caption2">
                                            <h3><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></h3>
                                            <div class="properties-footer">
                                                <div class="price">
                                                    <span>{{ number_format($product->price, 2) }} BDT</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5">
                                <h3>No products found for "{{ $query }}"</h3>
                                <p>Try searching for something else.</p>
                            </div>
                            @endforelse
                        </div>

                        <div class="row">
                            <div class="col-12">
                                {{ $products->appends(['q' => $query])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
