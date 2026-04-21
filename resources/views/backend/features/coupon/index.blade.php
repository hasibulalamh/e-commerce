@extends('backend.master')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row mb-2 mt-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Coupon Management</h2>
                    <a href="{{ route('coupons.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Coupon
                    </a>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-centered mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Code</th>
                                            <th>Target</th>
                                            <th>Type</th>
                                            <th>Value</th>
                                            <th>Min Purchase</th>
                                            <th>Usage</th>
                                            <th>Expiry</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($coupons as $coupon)
                                        <tr>
                                            <td class="font-weight-bold text-primary">{{ $coupon->code }}</td>
                                            <td>
                                                @if($coupon->product_id)
                                                    <span class="badge bg-primary">{{ $coupon->product->name }}</span>
                                                @else
                                                    <span class="badge bg-dark">Entire Cart</span>
                                                @endif
                                            </td>
                                            <td><span class="badge {{ $coupon->type == 'percent' ? 'bg-info' : 'bg-secondary' }}">{{ ucfirst($coupon->type) }}</span></td>
                                            <td>{{ $coupon->type == 'percent' ? $coupon->value . '%' : $coupon->value . ' BDT' }}</td>
                                            <td>{{ number_format($coupon->min_purchase, 2) }} BDT</td>
                                            <td>
                                                <div class="progress progress-sm mt-1" style="height: 5px;">
                                                    @php 
                                                        $percent = $coupon->usage_limit ? ($coupon->used_count / $coupon->usage_limit) * 100 : 0;
                                                    @endphp
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percent }}%"></div>
                                                </div>
                                                <small class="text-muted">{{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }} used</small>
                                            </td>
                                            <td>
                                                @if($coupon->expiry_date)
                                                    <span class="{{ $coupon->expiry_date->isPast() ? 'text-danger' : 'text-muted' }}">
                                                        {{ $coupon->expiry_date->format('M d, Y') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">No Expiry</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $coupon->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ ucfirst($coupon->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Delete this coupon?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger ml-1">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">No coupons found. Click "Create New Coupon" to start.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $coupons->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
