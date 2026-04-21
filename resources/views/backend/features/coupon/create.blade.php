@extends('backend.master')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row mb-2 mt-4">
                <div class="col-12">
                    <h2 class="mb-0">Create New Coupon</h2>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('coupons.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="code" class="form-label font-weight-bold">Coupon Code</label>
                                        <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" placeholder="e.g. SAVE20" value="{{ old('code') }}" required>
                                        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="type" class="form-label font-weight-bold">Discount Type</label>
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="fixed">Fixed Amount (BDT)</option>
                                            <option value="percent">Percentage (%)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="product_id" class="form-label font-weight-bold">Apply to Specific Product (Optional)</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="">-- Apply to Entire Cart --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">If selected, the discount will only apply to this product in the cart.</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="value" class="form-label font-weight-bold">Discount Value</label>
                                        <input type="number" step="0.01" name="value" id="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value') }}" required>
                                        @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="min_purchase" class="form-label font-weight-bold">Minimum Purchase Amount</label>
                                        <input type="number" step="0.01" name="min_purchase" id="min_purchase" class="form-control @error('min_purchase') is-invalid @enderror" value="{{ old('min_purchase', 0) }}" required>
                                        @error('min_purchase') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="expiry_date" class="form-label font-weight-bold">Expiry Date</label>
                                        <input type="date" name="expiry_date" id="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date') }}">
                                        @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="usage_limit" class="form-label font-weight-bold">Usage Limit (Leave blank for unlimited)</label>
                                        <input type="number" name="usage_limit" id="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" value="{{ old('usage_limit') }}">
                                        @error('usage_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="status" class="form-label font-weight-bold">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary px-4">Create Coupon</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card bg-light border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="font-weight-bold"><i class="fas fa-info-circle mr-2"></i> Coupon Tips</h5>
                            <hr>
                            <p class="small text-muted mb-2"><strong>Fixed Amount:</strong> Subtracts a flat amount from the total. e.g. 50 BDT off.</p>
                            <p class="small text-muted mb-2"><strong>Percentage:</strong> Subtracts a percentage of the subtotal. e.g. 10% off.</p>
                            <p class="small text-muted mb-2"><strong>Min Purchase:</strong> The coupon will only be valid if the order subtotal is greater than or equal to this value.</p>
                            <p class="small text-muted"><strong>Expiry:</strong> The coupon will not work after the selected date.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
