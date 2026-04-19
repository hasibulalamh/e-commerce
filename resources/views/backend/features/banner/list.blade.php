@extends('backend.master')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <a href="{{ route('banner.create') }}" class="btn btn-primary float-end">
                        <i class="fas fa-plus"></i> Add New Banner
                    </a>
                </div>
            </div>

            <div class="container mt-5">
                <h2 class="mb-4">Banner List</h2>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Subtitle</th>
                                                <th scope="col">Order</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($banners as $banner)
                                            <tr>
                                                <th scope="row">{{ $banner->id }}</th>
                                                <td>
                                                    @if($banner->image)
                                                        <img src="{{ asset('upload/banners/' . $banner->image) }}" 
                                                             alt="{{ $banner->title }}"
                                                             style="width: 100px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                    @else
                                                        <span class="badge bg-secondary">No Image</span>
                                                    @endif
                                                </td>
                                                <td>{{ $banner->title }}</td>
                                                <td>{{ $banner->subtitle }}</td>
                                                <td>{{ $banner->sort_order }}</td>
                                                <td>
                                                    @if($banner->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-warning btn-sm" href="{{ route('banner.edit', $banner->id) }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('banner.delete', $banner->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this banner?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
