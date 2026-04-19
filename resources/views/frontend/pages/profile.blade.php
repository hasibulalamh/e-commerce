@extends('frontend.master')
@section('content')
<main>
    <div class="hero-area section-bg2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="slider-area">
                        <div class="slider-height2 slider-bg4 d-flex align-items-center justify-content-center">
                            <div class="hero-caption hero-caption2">
                                <h2>Edit Profile</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-50 pb-50">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('customer.profile.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', auth('customerg')->user()->name) }}">
                                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Email Address</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', auth('customerg')->user()->email) }}">
                                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', auth('customerg')->user()->phone) }}">
                                    @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address', auth('customerg')->user()->address) }}">
                                    @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                    <h5>Change Password <small class="text-muted">(Leave blank to keep current)</small></h5>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>New Password</label>
                                    <input type="password" name="password" class="form-control">
                                    @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                    <a href="{{ route('customer.orders') }}" class="btn btn-secondary ml-2">My Orders</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
