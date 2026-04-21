@extends('backend.master')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row mb-2 mt-4">
                <div class="col-12">
                    <h2 class="mb-0">Edit Coupon: <span class="text-primary">{{ $coupon->code }}</span></h2>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('coupons.update', $coupon->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="code" class="form-label font-weight-bold">Coupon Code</label>
                                        <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $coupon->code) }}" required>
                                        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="type" class="form-label font-weight-bold">Discount Type</label>
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixed Amount (BDT)</option>
                                            <option value="percent" {{ $coupon->type == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="product_id" class="form-label font-weight-bold">Apply to Specific Product (Optional)</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="">-- Apply to Entire Cart --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ $coupon->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">If selected, the discount will only apply to this product in the cart.</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="value" class="form-label font-weight-bold">Discount Value</label>
                                        <input type="number" step="0.01" name="value" id="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value', $coupon->value) }}" required>
                                        @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="min_purchase" class="form-label font-weight-bold">Minimum Purchase Amount</label>
                                        <input type="number" step="0.01" name="min_purchase" id="min_purchase" class="form-control @error('min_purchase') is-invalid @enderror" value="{{ old('min_purchase', $coupon->min_purchase) }}" required>
                                        @error('min_purchase') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="expiry_date" class="form-label font-weight-bold">Expiry Date</label>
                                        <input type="date" name="expiry_date" id="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date', $coupon->expiry_date ? $coupon->expiry_date->format('Y-m-d') : '') }}">
                                        @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="usage_limit" class="form-label font-weight-bold">Usage Limit (Leave blank for unlimited)</label>
                                        <input type="number" name="usage_limit" id="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" value="{{ old('usage_limit', $coupon->usage_limit) }}">
                                        @error('usage_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="status" class="form-label font-weight-bold">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="active" {{ $coupon->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $coupon->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-warning px-4">Update Coupon</button>
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
