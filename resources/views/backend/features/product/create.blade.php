@extends('backend.master')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card mt-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Add New Product</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="productName" class="form-label">Product Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="productName" name="name" value="{{ old('name') }}" required>
                                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="category" class="form-label">Product Category</label>
                                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                        @foreach($category as $categories)
                                        <option value="{{$categories->id}}" {{ old('category_id') == $categories->id ? 'selected' : '' }}>{{$categories->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="brand" class="form-label">Product Brand</label>
                                    <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                                        <option value="">Select Brand</option>
                                        @foreach($brand as $brands)
                                        <option value="{{$brands->id}}" {{ old('brand_id') == $brands->id ? 'selected' : '' }}>{{$brands->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="categoryDescription" class="form-label">Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="categoryDescription" rows="3"
                                        placeholder="Enter product description" required>{{ old('description') }}</textarea>
                                    @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                                        @error('price') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="discount" class="form-label">Discount (%)</label>
                                        <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount') }}">
                                        @error('discount') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="stock" class="form-label">Stock</label>
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}" required>
                                        @error('stock') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="productImage" class="form-label">Product Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="productImage" name="image" required>
                                    @error('image') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check">
                                        <input name="status" class="form-check-input" type="radio" id="statusActive"
                                            value="active" {{ old('status', 'active') == 'active' ? 'checked' : '' }} />
                                        <label class="form-check-label" for="statusActive">
                                            Active
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="status" class="form-check-input" type="radio" id="statusInactive"
                                            value="inactive" {{ old('status') == 'inactive' ? 'checked' : '' }} />
                                        <label class="form-check-label" for="statusInactive">
                                            Inactive
                                        </label>
                                    </div>
                                    @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3 text-end">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Add Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0 text-white">
                        <i class="fas fa-file-excel"></i> Bulk Import Products (CSV/Excel)
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        Upload a CSV or Excel file to import multiple products at once. <br>
                        <strong>Required columns:</strong> <code>name, category_name, brand_name, description, price, discount, stock, status</code>
                    </p>
                    <form action="{{ route('product.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
                        @csrf
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" style="max-width: 350px;" required>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-upload"></i> Import Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection