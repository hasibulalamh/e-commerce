@extends('backend.master')
@section('content')

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row mb-2 mt-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Product Management</h2>
                    <a href="{{ route('product.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Product
                    </a>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-centered mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th style="width: 80px;">Image</th>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th style="width: 150px;">Price</th>
                                            <th style="width: 100px;">Status</th>
                                            <th style="width: 200px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($product as $products)
                                        <tr>
                                            <td class="align-middle text-center">{{ $loop->iteration + ($product->firstItem() - 1) }}</td>
                                            <td class="align-middle text-center">
                                                @if($products->image && file_exists(public_path('uploads/' . $products->image)))
                                                    <img src="{{ asset('uploads/' . $products->image) }}" 
                                                         alt="{{ $products->name }}"
                                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                                                @else
                                                    <div style="width: 60px; height: 60px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 1px dashed #dee2e6;">
                                                        <i class="fas fa-image text-muted" style="font-size: 18px;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="align-middle font-weight-bold">{{ $products->name }}</td>
                                            <td class="align-middle"><span class="badge bg-soft-primary text-primary">{{ $products->category->name ?? 'N/A' }}</span></td>
                                            <td class="align-middle">{{ $products->brand->name ?? 'N/A' }}</td>
                                            <td class="align-middle">
                                                <div class="font-weight-bold">{{ number_format($products->price, 0) }} BDT</div>
                                                @if($products->discount > 0)
                                                    <small class="text-danger" style="display: block; line-height: 1.2;">
                                                        <i class="fas fa-arrow-down mr-1"></i>{{ $products->discount }}% OFF 
                                                        <br><strong>{{ number_format($products->final_price, 0) }} BDT</strong>
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <span class="badge {{ $products->status == 'active' ? 'bg-success' : 'bg-danger' }} px-2 py-1">
                                                    {{ ucfirst($products->status) }}
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex flex-wrap gap-1">
                                                    <a href="{{ route('product.edit', $products->id) }}" class="btn btn-sm btn-warning text-white">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <a href="{{ route('product.view', $products->id) }}" class="btn btn-sm btn-info text-white">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <form action="{{ route('product.delete', $products->id) }}" method="POST" onsubmit="return confirm('Delete this product?')" style="margin: 0;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {{ $product->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection