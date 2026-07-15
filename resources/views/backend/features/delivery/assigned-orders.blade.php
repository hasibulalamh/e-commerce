@extends('backend.delivery-master')

@section('title', 'Assigned Orders')
@section('breadcrumb', 'Assigned Orders')

@push('styles')
<style>
    .order-card {
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 1rem;
        background: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .order-card:hover {
        box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        border-color: #16a34a30;
    }

    .order-id {
        font-weight: 700;
        color: #0f172a;
        font-size: 1rem;
    }

    .order-customer {
        color: #64748b;
        font-size: 0.875rem;
        margin: 0.25rem 0 0.75rem;
    }

    .btn-otp-send {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        border: none;
        padding: 0.6rem 1.25rem;
        border-radius: 0.625rem;
        font-size: 0.85rem;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-otp-send:hover {
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        transform: translateY(-1px);
    }

    .btn-otp-confirm {
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: #fff;
        border: none;
        padding: 0.6rem 1.25rem;
        border-radius: 0.625rem;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-otp-confirm:hover {
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);
        transform: translateY(-1px);
    }

    .otp-input {
        border: 2px solid #e2e8f0;
        border-radius: 0.625rem;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        font-weight: 600;
        letter-spacing: 4px;
        text-align: center;
        transition: border-color 0.3s ease;
    }

    .otp-input:focus {
        outline: none;
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #94a3b8;
    }

    .empty-state svg {
        width: 80px;
        height: 80px;
        margin-bottom: 1rem;
        stroke: #cbd5e1;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .page-header h4 {
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .badge-count {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: #fff;
        padding: 0.35rem 0.85rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 700;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center shadow-sm mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="page-header">
        <h4><i class="fas fa-truck me-2 text-warning"></i>Assigned Orders</h4>
        <span class="badge-count">{{ $orders->total() }} orders</span>
    </div>

    {{-- Orders List --}}
    @forelse ($orders as $order)
        <div class="order-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="order-id">
                        <a href="{{ route('delivery.order.show', $order->id) }}" class="text-decoration-none text-dark">
                            Order #{{ $order->id }}
                        </a>
                    </span>
                    <p class="order-customer mb-0">
                        <i class="fas fa-user me-1"></i> {{ $order->name ?? $order->customer_name ?? 'N/A' }}
                        <br>
                        @if($order->phone ?? $order->receiver_mobile)
                            <i class="fas fa-phone me-1 mt-1"></i> {{ $order->phone ?? $order->receiver_mobile }}
                            <br>
                        @endif
                        @if($order->address ?? $order->receiver_address)
                            <i class="fas fa-map-marker-alt me-1 mt-1"></i> {{ $order->address ?? $order->receiver_address }}
                        @endif
                    </p>
                </div>
                <div class="text-end">
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2" style="font-size: 0.75rem;">Pending</span>
                    <div class="mt-1 fw-bold text-primary">৳{{ number_format($order->total, 0) }}</div>
                </div>
            </div>

            <div class="row g-2">
                {{-- Send OTP --}}
                <div class="col-12">
                    <form action="{{ route('delivery.send-otp', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-otp-send">
                            <i class="fas fa-paper-plane me-1"></i> Send OTP to Customer
                        </button>
                    </form>
                </div>

                {{-- Verify OTP --}}
                <div class="col-12">
                    <form action="{{ route('delivery.verify-otp', $order) }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <input type="text" name="otp" maxlength="6" placeholder="● ● ● ● ● ●"
                            class="otp-input flex-grow-1" required>
                        <button type="submit" class="btn-otp-confirm">
                            <i class="fas fa-shield-alt me-1"></i> Confirm
                        </button>
                    </form>
                </div>

                {{-- Report Issue --}}
                <div class="col-12 mt-2">
                    <button type="button" class="btn btn-outline-danger w-100 btn-sm rounded-3 fw-bold" data-bs-toggle="modal" data-bs-target="#reportModal{{ $order->id }}">
                        <i class="fas fa-exclamation-triangle me-1"></i> Report Issue / Cancel
                    </button>
                </div>
            </div>
        </div>

        {{-- Report Issue Modal --}}
        <div class="modal fade" id="reportModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 1rem; border: none;">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title fw-bold">Report Issue for Order #{{ $order->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('delivery.report-issue', $order->id) }}" method="POST">
                        @csrf
                        <div class="modal-body py-0">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Action</label>
                                <select name="status_reported" class="form-select rounded-3" required>
                                    <option value="">Select an action...</option>
                                    <option value="pending">Keep Pending (Attempted but failed, will try again)</option>
                                    <option value="cancelled">Cancel Order (Customer refused, incorrect address, etc.)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Reason</label>
                                <textarea name="reason" class="form-control rounded-3" rows="3" placeholder="Please explain the reason in detail..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4">Submit Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="1" y="3" width="15" height="13" rx="2"></rect>
                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                </svg>
                <h5 class="fw-bold text-dark">No Pending Deliveries</h5>
                <p>You don't have any assigned orders at the moment.<br>Check back later for new assignments!</p>
            </div>
        </div>
    @endforelse

    {{-- Pagination --}}
    @if($orders->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
