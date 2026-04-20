@extends('backend.master')

@section('title', 'Order Details')

@push('styles')
<style>
    .order-status {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 500;
        display: inline-block;
    }
    .status-pending { background-color: #fff3cd; color: #664d03; }
    .status-confirmed { background-color: #cfe2ff; color: #084298; }
    .status-shipped { background-color: #cff4fc; color: #055160; }
    .status-delivered { background-color: #d1e7dd; color: #0f5132; }
    .status-cancelled { background-color: #f8d7da; color: #842029; }

    .timeline {
        position: relative;
        padding: 20px 0;
    }
    .timeline-item {
        position: relative;
        padding-left: 40px;
        margin-bottom: 20px;
    }
    .timeline-item:before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: -20px;
        width: 2px;
        background: #e9ecef;
    }
    .timeline-item:last-child:before {
        display: none;
    }
    .timeline-badge {
        position: absolute;
        left: 0;
        top: 0;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        text-align: center;
        line-height: 32px;
        background: #fff;
        border: 2px solid #e9ecef;
    }
    .timeline-badge.pending { border-color: #ffc107; color: #ffc107; }
    .timeline-badge.confirmed { border-color: #0d6efd; color: #0d6efd; }
    .timeline-badge.shipped { border-color: #0dcaf0; color: #0dcaf0; }
    .timeline-badge.delivered { border-color: #198754; color: #198754; }
    .timeline-badge.cancelled { border-color: #dc3545; color: #dc3545; }

    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }

    .info-label {
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .info-value {
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('orders.list') }}">Orders</a></li>
                                <li class="breadcrumb-item active">Order Details</li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            <i class="mdi mdi-file-document-outline me-1"></i>
                            Order Details
                        </h4>
                    </div>
                </div>
            </div>

            <!-- Order Information -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- Order Details Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="header-title">Order #{{ $order->id }}</h4>
                                <span class="order-status status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <!-- Order Items -->
                            <h5 class="mb-3">Order Items</h5>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($order->orderDetails as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="product-image me-3">
                                                    @else
                                                        <div class="product-image me-3 bg-light d-flex align-items-center justify-content-center">
                                                            <i class="mdi mdi-image-off"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h5 class="font-14 mb-1">{{ $item->product->name ?? 'Product Not Found' }}</h5>
                                                        @if($item->product)
                                                            <span class="text-muted">
                                                                @if($item->product->category)
                                                                    {{ $item->product->category->name }}
                                                                @endif
                                                                @if($item->product->brand)
                                                                    - {{ $item->product->brand->name }}
                                                                @endif
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                ৳{{ number_format($item->price, 2) }}
                                                @if($item->discount > 0)
                                                    <br>
                                                    <small class="text-danger">
                                                        -৳{{ number_format($item->discount, 2) }} discount
                                                    </small>
                                                @endif
                                            </td>
                                            <td>{{ $item->quantity }}</td>
                                            <td class="text-end">৳{{ number_format($item->total, 2) }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <p class="text-muted mb-0">No items found in this order</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                            <td class="text-end">৳{{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                        @if($discount > 0)
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Discount:</strong></td>
                                            <td class="text-end text-danger">-৳{{ number_format($discount, 2) }}</td>
                                        </tr>
                                        @endif
                                        @if($shipping > 0)
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                                            <td class="text-end">৳{{ number_format($shipping, 2) }}</td>
                                        </tr>
                                        @endif
                                        @if($tax > 0)
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Tax:</strong></td>
                                            <td class="text-end">৳{{ number_format($tax, 2) }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                            <td class="text-end"><strong>৳{{ number_format($total, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Status History -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Status History</h5>
                            <div class="timeline">
                                @forelse($statusHistories as $history)
                                <div class="timeline-item">
                                    <div class="timeline-badge {{ $history->status }}">
                                        @switch($history->status)
                                            @case('pending')
                                                <i class="mdi mdi-clock-outline"></i>
                                                @break
                                            @case('confirmed')
                                                <i class="mdi mdi-check-circle-outline"></i>
                                                @break
                                            @case('shipped')
                                                <i class="mdi mdi-truck-outline"></i>
                                                @break
                                            @case('delivered')
                                                <i class="mdi mdi-package-variant-closed-check"></i>
                                                @break
                                            @case('cancelled')
                                                <i class="mdi mdi-close-circle-outline"></i>
                                                @break
                                        @endswitch
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Order {{ ucfirst($history->status) }}</h6>
                                        <p class="text-muted mb-0">
                                            <small>
                                                <i class="mdi mdi-calendar-clock me-1"></i>
                                                {{ $history->created_at->format('M d, Y H:i') }}
                                                @if($history->changedBy)
                                                    by {{ $history->changedBy->name }}
                                                @endif
                                            </small>
                                        </p>
                                        @if($history->notes)
                                            <p class="mt-2 mb-0">{{ $history->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <p class="text-muted mb-0">No status history available</p>
                                </div>
                                @endforelse
                            </div>

                            @if($statusHistories->hasPages())
                            <div class="mt-4">
                                {{ $statusHistories->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Customer Information -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Customer Information</h5>
                            <div class="mb-3">
                                <label class="info-label">Name</label>
                                <p class="info-value">{{ $order->customer_id ? optional($order->customer)->name : optional($order->user)->name ?? 'Guest User' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="info-label">Email</label>
                                <p class="info-value">{{ $order->customer_id ? optional($order->customer)->email : optional($order->user)->email ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="info-label">Phone</label>
                                <p class="info-value">{{ $order->phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Shipping Information</h5>
                            <div class="mb-3">
                                <label class="info-label">Address</label>
                                <p class="info-value">{{ $order->address ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="info-label">City</label>
                                <p class="info-value">{{ $order->city ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="info-label">Postal Code</label>
                                <p class="info-value">{{ $order->postal_code ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Payment Information</h5>
                            <div class="mb-3">
                                <label class="info-label">Payment Status</label>
                                <p class="info-value">
                                    @if($order->payment_status)
                                        <span class="badge bg-success">Paid</span>
                                    @else
                                        <span class="badge bg-warning">Unpaid</span>
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="info-label">Payment Method</label>
                                <p class="info-value">{{ $order->payment_method ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="info-label">Transaction ID</label>
                                <p class="info-value">{{ $order->transaction_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Actions -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Order Actions</h5>
                            <form action="{{ route('orders.status.update', $order->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Update Status</label>
                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </form>

                            <div class="d-grid gap-2">
                                @if($order->status == 'pending')
                                <form action="{{ route('orders.confirm', $order->id) }}" method="POST" class="d-grid">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="mdi mdi-check-circle-outline me-1"></i>
                                        Confirm Order
                                    </button>
                                </form>
                                @endif

                                @if(in_array($order->status, ['pending', 'confirmed']))
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-grid">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="mdi mdi-close-circle-outline me-1"></i>
                                        Cancel Order
                                    </button>
                                </form>
                                @endif

                                <a href="{{ route('orders.status.history', $order->id) }}" class="btn btn-info">
                                    <i class="mdi mdi-history me-1"></i>
                                    View Status History
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endpush