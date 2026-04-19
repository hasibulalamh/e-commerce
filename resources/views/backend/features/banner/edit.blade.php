@extends('backend.master')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-warning text-dark">
                                <h4 class="mb-0">Edit Banner</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="title" class="form-label">Banner Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $banner->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="subtitle" class="form-label">Subtitle</label>
                                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $banner->subtitle) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" class="form-control" rows="3">{{ old('description', $banner->description) }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="button_text" class="form-label">Button Text</label>
                                                <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $banner->button_text) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="button_url" class="form-label">Button URL</label>
                                                <input type="text" name="button_url" class="form-control" value="{{ old('button_url', $banner->button_url) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Banner Image</label>
                                        @if($banner->image)
                                            <div class="mb-2">
                                                <img src="{{ asset('upload/banners/' . $banner->image) }}" alt="Current Banner" style="width: 200px; border-radius: 4px;">
                                            </div>
                                        @endif
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                        <small class="text-muted">Leave empty to keep current image. Recommended size: 1920x800px.</small>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="sort_order" class="form-label">Sort Order</label>
                                                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $banner->sort_order) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="form-check form-switch mt-3">
                                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $banner->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">Active Status</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary px-4">Update Banner</button>
                                        <a href="{{ route('banner.list') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
