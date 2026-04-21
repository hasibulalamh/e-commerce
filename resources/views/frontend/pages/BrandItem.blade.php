@extends('frontend.master')
@section('content')

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 border-bottom pb-3">
                @if($mybrand->count() > 0)
                    {{ $mybrand->first()->brand->name }} Products
                @else
                    Brand Products
                @endif
            </h1>
        </div>
    </div>

    @forelse($mybrand->groupBy('category.name') as $categoryName => $products)
    <div class="mb-5">
        <div class="bg-light p-3 mb-4 rounded border-left" style="border-left: 5px solid #e44d26 !important;">
            <h2 class="h4 mb-0 text-dark">{{ $categoryName }}</h2>
        </div>

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
    </div>
    @empty
    <div class="text-center py-5">
        <div style="font-size: 5rem; color: #eee;">🔍</div>
        <h3 class="text-muted">No products found for this brand.</h3>
        <a href="{{ route('product.listview') }}" class="btn btn-outline-primary mt-3">Browse All Products</a>
    </div>
    @endforelse
</div>

@endsection
<!-- <table class="table">
    <thead>
        <tr>
            <th scope="col">Product</th>
            <th scope="col">Category</th>
            <th scope="col">Brand</th>
            <th scope="col">Price</th>
            <th scope="col">Image</th>

        </tr>
    </thead>
    <tbody>
        @foreach($mybrand as $brands)
        <tr>
            <td>{{$brands->name}}</td>
            <td>{{$brands->category->name}}</td>
            <td>{{$brands->brand->name}}</td>
            <td>₹{{$brands->price}}</td>
            <td>
                <img src="{{asset($brands->image)}}" alt="{{$brands->name}}" style="width: 100px;">
            </td>

        </tr>
        @endforeach
    </tbody>

</table> -->