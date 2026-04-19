@extends('backend.master')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <!-- Back to Brand List Button -->
            <div class="row mb-2">
                <div class="col-12">
                    <a href="{{ route('brand.list') }}" class="btn btn-secondary float-end">
                        <i class="fas fa-arrow-left"></i> Back to Brand List
                    </a>
                </div>
            </div>

            <!-- Brand Edit Form -->
            <div class="container mt-5">
                <h2>Edit Brand: {{ $brand->name }}</h2>
                <form action="{{ route('brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Brand Name -->
                    <div class="mb-3">
                        <label for="brandName" class="form-label">Brand Name</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="brandName"
                            value="{{ old('name', $brand->name) }}" placeholder="Enter brand name" required />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Brand Description -->
                    <div class="mb-3">
                        <label for="brandDescription" class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="brandDescription" rows="3"
                            placeholder="Enter brand description">{{ old('description', $brand->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Brand Logo Upload -->
                    <div class="mb-3">
                        <label for="brandLogo" class="form-label">Brand Logo</label>
                        <input name="logo" class="form-control @error('logo') is-invalid @enderror" type="file" id="brandLogo" />
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if($brand->logo)
                            <div class="mt-2">
                                <p class="mb-1 small text-muted">Current Logo:</p>
                                <img src="{{ asset('upload/brands/' . $brand->logo) }}" 
                                     alt="Current Logo" 
                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                            </div>
                        @endif
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input name="status" class="form-check-input" type="radio" id="statusActive" value="active"
                                {{ old('status', $brand->status) == 'active' ? 'checked' : '' }} />
                            <label class="form-check-label" for="statusActive">
                                Active
                            </label>
                        </div>
                        <div class="form-check">
                            <input name="status" class="form-check-input" type="radio" id="statusInactive"
                                value="inactive" {{ old('status', $brand->status) == 'inactive' ? 'checked' : '' }} />
                            <label class="form-check-label" for="statusInactive">
                                Inactive
                            </label>
                        </div>
                        @error('status')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Brand</button>
                    <a href="{{ route('brand.list') }}" class="btn btn-outline-secondary ml-2">Cancel</a>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
