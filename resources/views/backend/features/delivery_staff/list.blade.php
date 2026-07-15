@extends('backend.master')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-12">
                    <a href="{{ route('deliverystaff.create') }}" class="btn btn-primary float-end">
                        <i class="fas fa-plus"></i> Add New Delivery Staff
                    </a>
                </div>
            </div>

            <div class="container mt-5">
                <h2 class="mb-4">Delivery Staff List</h2>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Joined</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($staff as $s)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration + ($staff->firstItem() - 1) }}</th>
                                                <td>{{ $s->name }}</td>
                                                <td>{{ $s->email }}</td>
                                                <td>{{ $s->phone ?? '-' }}</td>
                                                <td>{{ $s->created_at->format('d M, Y') }}</td>
                                                <td>
                                                    <a class="btn btn-warning btn-sm" href="{{ route('deliverystaff.edit', $s->id) }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('deliverystaff.delete', $s->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this delivery staff?')">
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
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $staff->links('pagination::bootstrap-5') }}
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
