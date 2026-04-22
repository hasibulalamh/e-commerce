@extends('backend.master')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card mt-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0 text-white">Edit Product: {{ $product->name }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="productName" class="form-label">Product Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="productName" name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="category" class="form-label">Product Category</label>
                                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                            <option value="">Select Category</option>
                                            @foreach($category as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="brand" class="form-label">Brand</label>
                                        <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                                            <option value="">Select Brand</option>
                                            @foreach($brand as $b)
                                                <option value="{{ $b->id }}" {{ old('brand_id', $product->brand_id) == $b->id ? 'selected' : '' }}>
                                                    {{ $b->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="discount" class="form-label">Discount (%)</label>
                                        <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount', $product->discount) }}">
                                        @error('discount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="stock" class="form-label">Stock</label>
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="productImage" class="form-label">Main Product Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="productImage" name="image">
                                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    
                                    @if($product->image)
                                        <div class="mt-2">
                                            <p class="mb-1 small text-muted">Current Main Image:</p>
                                            <img src="{{ asset('upload/products/' . $product->image) }}" alt="Main Image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="galleryImages" class="form-label">Gallery Images (Multiple)</label>
                                    <input type="file" class="form-control @error('gallery_images.*') is-invalid @enderror" id="galleryImages" name="gallery_images[]" multiple>
                                    @error('gallery_images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    
                                    @if($product->productImages->count() > 0)
                                        <div class="mt-3">
                                            <p class="mb-2 small text-muted">Current Gallery Images (click to delete):</p>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($product->productImages as $image)
                                                    <div class="gallery-image-container position-relative" id="gallery-image-{{ $image->id }}">
                                                        <img src="{{ asset('upload/products/gallery/' . $image->image) }}" alt="Gallery Image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 rounded-circle delete-gallery-image" data-id="{{ $image->id }}" style="padding: 2px 6px; font-size: 10px;">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check">
                                        <input name="status" class="form-check-input" type="radio" id="statusActive" value="active" {{ old('status', $product->status) == 'active' ? 'checked' : '' }} />
                                        <label class="form-check-label" for="statusActive">Active</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="status" class="form-check-input" type="radio" id="statusInactive" value="inactive" {{ old('status', $product->status) == 'inactive' ? 'checked' : '' }} />
                                        <label class="form-check-label" for="statusInactive">Inactive</label>
                                    </div>
                                    @error('status')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Product</button>
                                    <a href="{{ route('product.list') }}" class="btn btn-secondary ml-2">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-gallery-image').on('click', function() {
            const imageId = $(this).data('id');
            const container = $('#gallery-image-' + imageId);
            
            if (confirm('Are you sure you want to delete this image?')) {
                $.ajax({
                    url: "{{ url('admin/products/gallery/delete') }}/" + imageId,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            container.fadeOut(300, function() {
                                $(this).remove();
                            });
                        }
                    },
                    error: function() {
                        alert('Failed to delete image. Please try again.');
                    }
                });
            }
        });
    });
</script>
@endpush
