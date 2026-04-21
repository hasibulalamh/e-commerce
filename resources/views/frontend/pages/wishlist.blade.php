@extends('frontend.master')
@section('content')

<main class="wishlist-area pt-60 pb-60 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-tittle mb-50">
                    <h2 class="font-weight-bold">My Wishlist</h2>
                    <p class="text-muted">You have {{ $wishlistItems->total() }} items saved in your wishlist.</p>
                </div>
                
                @if($wishlistItems->count() > 0)
                    <div class="row">
                        @foreach($wishlistItems as $item)
                            @php $p = $item->product; @endphp
                            @if($p)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm rounded-lg overflow-hidden position-relative wishlist-card">
                                    {{-- Remove Button --}}
                                    <form action="{{ route('customer.wishlist.remove', $item->id) }}" method="POST" class="position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white rounded-circle shadow-sm text-danger" style="width: 35px; height: 35px; padding: 0;" title="Remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>

                                    {{-- Product Image --}}
                                    <a href="{{ route('product.details', $p->id) }}">
                                        <div style="height: 250px; overflow: hidden; background: #fff;">
                                            @if($p->image)
                                                <img src="{{ asset('uploads/products/'.$p->image) }}" 
                                                     alt="{{ $p->name }}" 
                                                     style="width: 100%; height: 100%; object-fit: cover;"
                                                     onerror="this.src='{{ asset('upload/products/'.$p->image) }}'; this.onerror=null;">
                                            @else
                                                <div class="h-100 d-flex align-items-center justify-content-center bg-secondary text-white">
                                                    No Image
                                                </div>
                                            @endif
                                        </div>
                                    </a>

                                    <div class="card-body p-3">
                                        {{-- Category --}}
                                        <div class="small text-muted mb-1">{{ $p->category->name ?? 'Category' }}</div>
                                        
                                        {{-- Title --}}
                                        <h5 class="card-title mb-2 text-truncate">
                                            <a href="{{ route('product.details', $p->id) }}" class="text-dark font-weight-bold">{{ $p->name }}</a>
                                        </h5>

                                        {{-- Price --}}
                                        <div class="mb-3">
                                            <span class="h6 font-weight-bold text-primary mb-0">৳{{ number_format($p->final_price, 2) }}</span>
                                            @if($p->discount > 0)
                                                <small class="text-muted ml-2" style="text-decoration: line-through;">৳{{ number_format($p->price, 2) }}</small>
                                            @endif
                                        </div>

                                        {{-- Stock & Action --}}
                                        <div class="d-flex align-items-center justify-content-between mt-auto">
                                            @if($p->stock > 0)
                                                <span class="badge badge-pill badge-success-soft px-3 py-1" style="background: #e8f5e9; color: #2e7d32;">In Stock</span>
                                                <a href="{{ route('addto.cart', $p->id) }}" class="btn btn-sm btn-dark px-3 py-1" style="border-radius: 5px;">
                                                    <i class="fas fa-cart-plus mr-1"></i> Cart
                                                </a>
                                            @else
                                                <span class="badge badge-pill badge-danger-soft px-3 py-1" style="background: #ffebee; color: #c62828;">Out of Stock</span>
                                                <button disabled class="btn btn-sm btn-light px-3 py-1" style="border-radius: 5px;">Out</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="row mt-40">
                        <div class="col-12 d-flex justify-content-center">
                            {{ $wishlistItems->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5 bg-white rounded shadow-sm">
                        <div class="mb-4">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <i class="far fa-heart fa-3x text-muted"></i>
                            </div>
                        </div>
                        <h3 class="font-weight-bold">Your wishlist is empty</h3>
                        <p class="text-muted">Explore our latest collection and save items for later.</p>
                        <a href="{{ route('product.listview') }}" class="btn btn-primary btn-lg mt-3 px-5">Continue Shopping</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

<style>
    .wishlist-card {
        transition: all 0.3s ease;
    }
    .wishlist-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .btn-white {
        background: #fff;
        border: none;
    }
    .btn-white:hover {
        background: #f8f9fa;
    }
    .badge-success-soft {
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>

@endsection
