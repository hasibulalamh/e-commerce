@extends('backend.master')
@section('content')

<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="container mt-5">
                <h2>Product List</h2>
                <a href="{{ route('product.create') }}" class="btn btn-success mb-3">Create New Product</a>

                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>brand</th>
                            <th>price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product as $products)
                        <tr>
                            <td>{{$products->id}}</td>
                            <td>
                                @if($products->image)
                                    <img src="{{ asset('upload/products/' . $products->image) }}" 
                                         alt="{{ $products->name }}"
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <span class="badge bg-secondary">No Image</span>
                                @endif
                            </td>
                            <td>{{$products->name}}</td>
                            <td>{{$products->category->name ?? 'N/A'}}</td>
                            <td>{{$products->brand->name ?? 'N/A'}}</td>
                            <td>
                                {{ number_format($products->price, 2) }} BDT
                                @if($products->discount > 0)
                                    <br><small class="text-danger">
                                        {{ $products->discount }}% off 
                                        → {{ number_format($products->final_price, 2) }} BDT
                                    </small>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $products->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($products->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('product.edit', $products->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('product.delete', $products->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                <a href="{{ route('product.view', $products->id) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection