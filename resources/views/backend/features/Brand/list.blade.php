@extends('backend.master')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">

                <div class="row mb-2">
                    <div class="col-12">
                        <a href="{{ route('brand.create') }}" class="btn btn-primary float-end">
                            <i class="fas fa-plus"></i> Add New Brand
                        </a>
                    </div>
                </div>

                <div class="container mt-5">
                    <h2 class="mb-4">Brand List</h2>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Brand Name</th>
                                                <th scope="col">Brand Description</th>
                                                <th scope="col">Logo</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($brands as $brand)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration + ($brands->firstItem() - 1) }}
                                                    </th>
                                                    <td>{{ $brand->name }}</td>
                                                    <td>{{ $brand->description }}</td>

                                                    <td>
                                                        <div
                                                            style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 1px dashed #ccc; overflow: hidden;">
                                                            @if ($brand->logo && !str_contains($brand->logo, 'default.png'))
                                                                <img src="{{ $brand->logo }}" alt="{{ $brand->name }}"
                                                                    style="width: 100%; height: 100%; object-fit: contain;">
                                                            @else
                                                                <i class="fas fa-image text-muted"
                                                                    style="font-size: 18px;"></i>
                                                            @endif
                                                        </div>
                                                    </td>

                                                    <td>
                                                        @if (strtolower($brand->status) == 'active')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <a class="btn btn-warning btn-sm"
                                                            href="{{ route('brand.edit', $brand->id) }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('brand.delete', $brand->id) }}"
                                                            method="POST" style="display:inline-block;"
                                                            onsubmit="return confirm('Are you sure you want to delete this brand?')">
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
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $brands->links('pagination::bootstrap-5') }}
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
