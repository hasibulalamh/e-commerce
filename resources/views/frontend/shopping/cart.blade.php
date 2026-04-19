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
                                <h2>Cart</h2>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb justify-content-center">
                                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                        <li class="breadcrumb-item"><a href="#">Cart</a></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Hero area End -->
    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <form action="{{ route('cart.update') }}" method="POST">
                        @csrf
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($mycart) > 0)
                                @foreach($mycart as $cartId => $cartData)
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="{{ asset('upload/products/' . $cartData['image']) }}" alt="{{ $cartData['name'] }}" style="width: 100px;"/>
                                            </div>
                                            <div class="media-body">
                                                <p>{{$cartData['name']}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h5>{{ number_format($cartData['price'], 2) }} BDT</h5>
                                    </td>
                                    <td>
                                        <div class="product_count">
                                            <input class="input-number" name="quantities[{{ $cartId }}]" type="number" value="{{$cartData['quantity']}}" min="1" max="100">
                                        </div>
                                    </td>
                                    <td>
                                        <h5>{{ number_format($cartData['price'] * $cartData['quantity'], 2) }} BDT</h5>
                                    </td>
                                    <td>
                                        <a href="{{ route('cart.remove', $cartId) }}" 
                                           onclick="return confirm('Remove this item?')"
                                           class="btn btn-sm btn-danger">
                                           <i class="ti-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                <tr class="bottom_button">
                                    <td>
                                        <button type="submit" class="btn">Update Cart</button>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <h5>Subtotal</h5>
                                    </td>
                                    <td>
                                        <h5>{{ number_format(array_sum(array_column(Session::get('cart', []), 'subtotal')), 2) }} BDT</h5>
                                    </td>
                                    <td></td>
                                </tr>
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <h2>Cart is Empty !!</h2>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </form>
                    <div class="checkout_btn_inner float-right" style="margin-right: 0;">
                        <a class="btn" href="{{ route('product.listview') }}">Continue Shopping</a>
                        <a class="btn checkout_btn" href="{{route('cart.checkout')}}">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->
</main>
@endsection