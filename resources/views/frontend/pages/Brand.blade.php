@extends('frontend.master')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css">
<style>
    .brand-slider img {
        width: 150px;
        height: 70px;
        object-fit: contain;
        transition: all 0.4s ease;
        padding: 0 7px;
    }

    .brand-slider img:hover {
        opacity: 0.7;
        transform: scale(1.05);
    }

    .slick-prev:before, 
    .slick-next:before {
        color: #04776e;
    }

    .brand-slider .px-2 {
        margin: 10px 0;
    }

    @media (max-width: 768px) {
        .brand-slider img {
            width: 100px;
            height: 50px;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <header class="text-center mb-5">
        <h1 class="display-4">Our Brands</h1>
    </header>

    <!-- Popular Brands Section -->
    <section class="mb-5">
        <div class="row mb-4">
            <div class="col-md-6">
                <h3 class="h5">Our Most Popular Brands</h3>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Find a brand">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Brands Slider -->
        <div class="row">
            @foreach($brand as $brands)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
            <a href="{{ route('customer.brands', $brands->id) }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm" style="transition: transform 0.3s ease;">
                <div style="height: 120px; display: flex; align-items: center; justify-content: center; background: #fff;">
                    @if($brands->logo)
                        <img src="{{ asset('upload/brands/' . $brands->logo) }}" 
                            alt="{{ $brands->name }}"
                            style="width:100%; height:120px; object-fit:contain; padding:10px;">
                    @else
                        <div style="height:120px; display:flex; align-items:center; justify-content:center; font-size:2.5rem; color:#ccc; background:#f9f9f9; width:100%;">
                            🏷️
                        </div>
                    @endif
                </div>
                <div class="card-body p-2 border-top">
                    <p class="text-center mb-0 font-weight-bold text-dark">{{$brands->name}}</p>
                </div>
                </div>
            </a>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js"></script>
<script>
    $('.brand-slider').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        autoplay: true,
        autoplaySpeed: 2000,
        centerMode: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 2,
                    centerMode: false
                }
            }
        ]
    });
</script>
@endsection
