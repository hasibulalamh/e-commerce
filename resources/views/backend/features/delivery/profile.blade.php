@extends('backend.delivery-master')

@section('title', 'My Profile')
@section('breadcrumb', 'Profile')

@push('styles')
<style>
    .profile-card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    .profile-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 2rem;
        text-align: center;
        color: #fff;
    }

    .profile-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        border: 4px solid rgba(255,255,255,0.2);
        box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        margin-bottom: 0.75rem;
    }

    .profile-name {
        font-size: 1.25rem;
        font-weight: 700;
    }

    .profile-role {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #34d399;
        font-weight: 600;
    }

    .profile-body {
        padding: 2rem;
    }

    .form-label-custom {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 0.4rem;
    }

    .form-control-custom {
        border: 2px solid #e2e8f0;
        border-radius: 0.625rem;
        padding: 0.7rem 1rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .form-control-custom:focus {
        outline: none;
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
        background: #fff;
    }

    .form-control-custom:disabled {
        background: #f1f5f9;
        color: #94a3b8;
        border-color: #e2e8f0;
    }

    .btn-update {
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: #fff;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 0.625rem;
        font-size: 0.9rem;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-update:hover {
        box-shadow: 0 6px 16px rgba(22, 163, 74, 0.3);
        transform: translateY(-2px);
    }

    .divider {
        border: none;
        border-top: 2px solid #f1f5f9;
        margin: 1.5rem 0;
    }

    .security-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.3rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 600;
        background: #fef3c7;
        color: #92400e;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card profile-card">
                {{-- Profile Header --}}
                <div class="profile-header">
                    <img class="profile-avatar"
                         src="https://ui-avatars.com/api/?name={{ $user->name }}&size=180&background=16a34a&color=fff&bold=true"
                         alt="{{ $user->name }}">
                    <div class="profile-name">{{ $user->name }}</div>
                    <div class="profile-role">Delivery Staff</div>
                </div>

                {{-- Profile Form --}}
                <div class="profile-body">
                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('delivery.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label-custom">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-control form-control-custom" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="form-control form-control-custom" placeholder="e.g. 01712345678">
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Email Address</label>
                            <input type="text" value="{{ $user->email }}" disabled
                                class="form-control form-control-custom">
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-lock me-1"></i> Email cannot be changed
                            </small>
                        </div>

                        <hr class="divider">

                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="security-badge">
                                <i class="fas fa-shield-alt"></i> Security
                            </span>
                            <span class="text-muted" style="font-size: 0.8rem;">Change your password below</span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">New Password</label>
                            <input type="password" name="password"
                                class="form-control form-control-custom" placeholder="Leave blank to keep current">
                        </div>

                        <div class="mb-4">
                            <label class="form-label-custom">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                class="form-control form-control-custom" placeholder="Re-type new password">
                        </div>

                        <button type="submit" class="btn-update">
                            <i class="fas fa-save me-2"></i> Update Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
