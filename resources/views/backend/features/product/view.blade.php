@extends('backend.master')
@section('content')

<div class="content-page">
    <div class="content">
        <!-- Start Content -->
        <div class="container-fluid">
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2><span>{{ $product->name }}</span></h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h4>Product Image</h4>
                                    </div>
                                    <div class="card-body text-center">

                                        <img src="{{ asset('upload/products/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="img-fluid" style="max-height: 300px; border-radius: 8px; border: 1px solid #ddd;">

                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Actions</h4>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary btn-block mb-2">Edit Product</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="200">Product ID</th>
                                        <td>{{ $product->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Product Name</th>
                                        <td>{{ $product->name }}</td>
                                    </tr>
                                    <!-- <tr>
                                        <th>URL Slug</th>
                                        <td>{{ $product->url_slug }}</td>
                                    </tr> -->
                                    <tr>
                                        <th>Category</th>
                                        <td>{{ $product->category->name  }}</td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td>{{ number_format($product->price, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Discount</th>
                                        @if($product->discount > 0)
                                            <td>
                                                <span class="text-danger font-weight-bold">{{ $product->discount }}%</span>
                                                <small class="text-muted ml-1">(৳{{ number_format($product->discount_amount, 2) }} off)</small>
                                            </td>
                                        @else
                                            <td><span class="badge bg-secondary">No Discount</span></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th>Stock Quantity</th>
                                        <td>{{ $product->stock }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $product->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $product->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $product->updated_at }}</td>
                                    </tr>
                                </table>

                                <div class="mt-4">
                                    <h4>Product Description</h4>
                                    <div class="p-3 bg-light">
                                        {{ $product->description }}
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

@endsection