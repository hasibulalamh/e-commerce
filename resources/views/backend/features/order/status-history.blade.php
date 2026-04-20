@extends('backend.master')

@section('title', 'Order Status History')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        position: relative;
        padding-left: 40px;
        margin-bottom: 30px;
    }

    .timeline-item:before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: -30px;
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
        z-index: 1;
        transition: all 0.3s ease;
    }

    .timeline-badge:hover {
        transform: scale(1.1);
    }

    .timeline-badge i {
        font-size: 16px;
    }

    .timeline-badge.pending { 
        border-color: #ffc107; 
        color: #ffc107;
        background-color: #fff3cd;
    }
    .timeline-badge.confirmed { 
        border-color: #0d6efd; 
        color: #0d6efd;
        background-color: #cfe2ff;
    }
    .timeline-badge.shipped { 
        border-color: #0dcaf0; 
        color: #0dcaf0;
        background-color: #cff4fc;
    }
    .timeline-badge.delivered { 
        border-color: #198754; 
        color: #198754;
        background-color: #d1e7dd;
    }
    .timeline-badge.cancelled { 
        border-color: #dc3545; 
        color: #dc3545;
        background-color: #f8d7da;
    }

    .timeline-content {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .timeline-content:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transform: translateX(5px);
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .timeline-title {
        font-size: 16px;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .timeline-time {
        color: #6c757d;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .timeline-body {
        color: #6c757d;
        font-size: 14px;
        padding: 10px 0;
    }

    .timeline-footer {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #e9ecef;
        font-size: 13px;
        color: #6c757d;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: #6c757d;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        text-transform: capitalize;
    }

    .status-pending { background-color: #fff3cd; color: #664d03; }
    .status-confirmed { background-color: #cfe2ff; color: #084298; }
    .status-shipped { background-color: #cff4fc; color: #055160; }
    .status-delivered { background-color: #d1e7dd; color: #0f5132; }
    .status-cancelled { background-color: #f8d7da; color: #842029; }

    .notes-box {
        background-color: #f8f9fa;
        border-radius: 4px;
        padding: 10px;
        margin-top: 10px;
    }

    .notes-box i {
        color: #6c757d;
        margin-right: 5px;
    }
</style>
@endpush

@section('content')
<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Order #{{ $order->id }} - Status History</h1>
                            <div>
                                <a href="{{ route('order.view', $order->id) }}" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-arrow-left"></i> Back to Order
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Order Status Timeline</h6>
                                        <div>
                                            <span class="badge status-{{ $order->status }} text-uppercase">
                                                {{ str_replace('_', ' ', $order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if($statusHistories->count() > 0)
                                        <div class="timeline">
                                            @forelse($statusHistories as $history)
                                            <div class="timeline-item">
                                                <div class="timeline-badge {{ $history->status }}" data-bs-toggle="tooltip" title="{{ ucfirst($history->status) }}">
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
                                                    <div class="timeline-header">
                                                        <h6 class="timeline-title">
                                                            <i class="mdi mdi-flag-outline"></i>
                                                            Order {{ ucfirst($history->status) }}
                                                        </h6>
                                                        <span class="timeline-time" data-bs-toggle="tooltip" title="{{ $history->created_at->format('M d, Y H:i:s') }}">
                                                            <i class="mdi mdi-calendar-clock"></i>
                                                            {{ $history->created_at->format('M d, Y H:i') }}
                                                        </span>
                                                    </div>
                                                    
                                                    <div class="timeline-body">
                                                        @if($history->notes)
                                                            <div class="notes-box">
                                                                <i class="mdi mdi-comment-text-outline"></i>
                                                                {{ $history->notes }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="timeline-footer">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="user-info">
                                                                    <div class="user-avatar">
                                                                        @if($history->changedBy)
                                                                            {{ strtoupper(substr($history->changedBy->name, 0, 1)) }}
                                                                        @else
                                                                            <i class="mdi mdi-robot"></i>
                                                                        @endif
                                                                    </div>
                                                                    <small>
                                                                        <i class="mdi mdi-account-outline"></i>
                                                                        Changed by: {{ $history->changedBy->name ?? 'System' }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 text-md-end">
                                                                <small>
                                                                    <i class="mdi mdi-clock-outline"></i>
                                                                    {{ $history->created_at->diffForHumans() }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="text-center py-4">
                                                <img src="{{ asset('assets/images/no-data.svg') }}" alt="No data" height="64">
                                                <h5 class="mt-2">No status history available</h5>
                                                <p class="text-muted mb-0">This order has no status changes recorded yet.</p>
                                            </div>
                                            @endforelse
                                        </div>

                                        <div class="mt-4">
                                            {{ $statusHistories->links() }}
                                        </div>
                                        @else
                                        <div class="text-center py-4">
                                            <i class="bi bi-clock-history text-muted" style="font-size: 4rem;"></i>
                                            <h5 class="mt-3">No status history available</h5>
                                            <p class="text-muted">No status changes have been recorded for this order yet.</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Order Summary</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Order #</h6>
                                            <p class="mb-0">{{ $order->id }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Order Date</h6>
                                            <p class="mb-0">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Customer</h6>
                                            <p class="mb-0">{{ $order->customer_name ?? 'N/A' }}</p>
                                            <p class="mb-0 text-muted small">{{ $order->customer_email ?? '' }}</p>
                                            <p class="mb-0 text-muted small">{{ $order->customer_phone ?? '' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Order Total</h6>
                                            <h5 class="mb-0">{{ config('settings.currency_symbol') }}{{ number_format($order->total, 2) }}</h5>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Shipping Address</h6>
                                            <p class="mb-0">
                                                {{ $order->shipping_address_line1 ?? 'N/A' }}<br>
                                                @if($order->shipping_address_line2)
                                                {{ $order->shipping_address_line2 }}<br>
                                                @endif
                                                {{ $order->shipping_city ?? '' }},
                                                {{ $order->shipping_state ?? '' }}
                                                {{ $order->shipping_zip_code ?? '' }}<br>
                                                {{ $order->shipping_country ?? '' }}
                                            </p>
                                        </div>
                                        @if($order->tracking_number)
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Tracking Number</h6>
                                            <p class="mb-0">{{ $order->tracking_number }}</p>
                                            @if($order->shipping_carrier)
                                            <small class="text-muted">{{ $order->shipping_carrier }}</small>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Update Status</h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('orders.status.update', $order->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-select" required>
                                                    <option value="">Select Status</option>
                                                    @foreach(\App\Models\Order::getStatuses() as $value => $label)
                                                    @if($value !== $order->status && in_array($value, $allowedTransitions))
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-3" id="trackingNumberGroup" style="display: none;">
                                                <label for="tracking_number" class="form-label">Tracking Number</label>
                                                <input type="text" name="tracking_number" id="tracking_number" class="form-control"
                                                    value="{{ old('tracking_number', $order->tracking_number) }}">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="notes" class="form-label">Notes (Optional)</label>
                                                <textarea name="notes" id="notes" rows="2" class="form-control">{{ old('notes') }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="bi bi-save me-1"></i> Update Status
                                            </button>
                                        </form>
                                    </div>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const trackingNumberGroup = document.getElementById('trackingNumberGroup');

        if (statusSelect) {
            // Show/hide tracking number field based on status
            statusSelect.addEventListener('change', function() {
                if (this.value === 'shipped') {
                    trackingNumberGroup.style.display = 'block';
                } else {
                    trackingNumberGroup.style.display = 'none';
                }
            });

            // Trigger change event on page load if needed
            if (statusSelect.value === 'shipped') {
                trackingNumberGroup.style.display = 'block';
            }
        }

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush