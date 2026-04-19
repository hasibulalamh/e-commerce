@extends('backend.master')
@section('content')
<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <a href="{{ route('category.create') }}" class="btn btn-primary float-end">
                        <i class="fas fa-plus"></i> Add New Category
                    </a>
                </div>
            </div>

            <div class="container mt-5">
                <h2 class="mb-4">Category List</h2>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Category Name</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Display Order</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($cat as $cats)
                                            <tr>
                                                <th scope="row">{{ $cats->id }}</th>
                                                <td>{{ $cats->name }}</td>
                                                <td>{{ $cats->description }}</td>
                                                <td>
                                                    @if($cats->image)
                                                        <img src="{{ asset('upload/categories/' . $cats->image) }}" 
                                                             alt="{{ $cats->name }}"
                                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                    @else
                                                        <span class="badge bg-secondary">No Image</span>
                                                    @endif
                                                </td>
                                                <td>{{ $cats->display_order }}</td>
                                                <td>
                                                    @if($cats->status == 'active')
                                                    <span class="badge bg-success">Active</span>
                                                    @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-warning btn-sm" href="{{ route('category.edit', $cats->id) }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('category.delete', $cats->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                            </div> <!-- End Card Body -->
                        </div> <!-- End Card -->
                    </div> <!-- End Col -->
                </div> <!-- End Row -->
            </div>
        </div>
    </div>
</div>
@endsection