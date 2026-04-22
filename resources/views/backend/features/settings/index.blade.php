@extends('backend.master')

@section('title', 'General Settings')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">General Settings</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Shipping Charges</h4>
                            
                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-md-4 col-form-label">Inside Dhaka Shipping Charge (৳)</label>
                                    <div class="col-md-8">
                                        <input type="number" name="shipping_charge_dhaka" class="form-control" value="{{ $settings['shipping_charge_dhaka'] ?? 70 }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-md-4 col-form-label">Outside Dhaka Shipping Charge (৳)</label>
                                    <div class="col-md-8">
                                        <input type="number" name="shipping_charge_outside" class="form-control" value="{{ $settings['shipping_charge_outside'] ?? 130 }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
