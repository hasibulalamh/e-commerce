@extends('backend.master')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0">Category Management</h2>
                </div>
                <div class="col-auto">
                    {{-- RESTful route naming conventions (category.create -> categories.create) --}}
                    <a href="{{ route('category.create') }}" class="btn btn-primary float-end">
                        <i class="fas fa-plus"></i> Add New Category
                    </a>
                </div>
            </div>

            <div class="container mt-5">
                <h2 class="mb-4">Category List</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover align-middle mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col" class="text-center" style="width: 50px;">#</th>
                                                <th scope="col">Category Name</th>
                                                <th scope="col">Description</th>
                                                <th scope="col" class="text-center" style="width: 80px;">Image</th>
                                                <th scope="col" class="text-center" style="width: 100px;">Display Order</th>
                                                <th scope="col" class="text-center" style="width: 100px;">Status</th>
                                                <th scope="col" class="text-center" style="width: 160px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cat as $cats)
                                            <tr>
                                                <th scope="row" class="text-center font-weight-bold">
                                                    {{-- pagination-aware iteration number --}}
                                                    {{ $loop->iteration + ($cat->firstItem() - 1) }}
                                                </th>
                                                <td class="font-weight-medium">{{ $cats->name ?? 'N/A' }}</td>
                                                <td>
                                                    {{-- Limit description length for UI consistency --}}
                                                    {{ Str::limit($cats->description ?? 'No description provided.', 100) }}
                                                </td>
                                                <td class="text-center p-1">
                                                    {{-- আর্কিটেকচারালি সঠিক ক্লিন পাথ রেজোলিউশন (M মডেলে অ্যাক্সেসর ডিফাইন করা হয়েছে) --}}
                                                  @if($cats->image_url)
    <img src="{{ $cats->image_url }}"
          alt="{{ $cats->name }}"
         class="rounded shadow-sm"
         style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #dee2e6; ">
@else
    <div class="text-center">
        <i class="fas fa-image text-muted fa-2x"></i>
    </div>
@endif
                                                </td>
                                                <td class="text-center text-monospace">{{ $cats->display_order ?? 0 }}</td>
                                                <td class="text-center">
                                                    @if($cats->status == 'active')
                                                        <span class="badge bg-success text-uppercase">Active</span>
                                                    @else
                                                        <span class="badge bg-danger text-uppercase">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a class="btn btn-warning" href="{{ route('category.edit', $cats->id) }}" title="Edit Category">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('category.delete', $cats->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" title="Delete Category">
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
                                    {{ $cat->links('pagination::bootstrap-5') }}
                                </div>
                            </div> </div> </div> </div> </div>
        </div>
    </div>
</div>
@endsection