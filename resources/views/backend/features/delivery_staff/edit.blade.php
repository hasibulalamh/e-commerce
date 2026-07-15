@extends('backend.master')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="container mt-5">
                <h2 class="mb-4">Edit Delivery Staff</h2>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('deliverystaff.update', $staff->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $staff->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $staff->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $staff->phone) }}">
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="form-label">New Password (leave blank to keep current)</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Delivery Staff
                            </button>
                            <a href="{{ route('deliverystaff.list') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
