@extends('backend.master')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <!-- Add New Brand Button -->
            <div class="row mb-2">
                <div class="col-12">
                    <a href="{{ route('brand.create') }}" class="btn btn-primary float-end">
                        <i class="fas fa-plus"></i> Add New Brand
                    </a>
                </div>
            </div>

            <!-- Brand List Table -->
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
                                        @foreach($brand as $brands)
                                        <tr>
                                            <th scope="row">{{ $brands->id }}</th>
                                            <td>{{ $brands->name }}</td>
                                            <td>{{ $brands->description }}</td>
                                            <td>
                                                @if($brands->logo)
                                                    <img src="{{ asset('upload/brands/' . $brands->logo) }}" 
                                                         alt="{{ $brands->name }}"
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                @else
                                                    <span class="badge bg-secondary">No Logo</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($brands->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                                @else
                                                <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-warning btn-sm" href="{{ route('brand.edit', $brands->id) }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('brand.delete', $brands->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this brand?')">
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
@endsection