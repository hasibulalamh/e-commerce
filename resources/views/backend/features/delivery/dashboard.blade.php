@extends('backend.delivery-master')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@push('styles')
<style>
    .stats-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }

    .stats-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.12);
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: rgba(255,255,255,0.2);
        box-shadow: inset 0 0 10px rgba(255,255,255,0.15);
    }

    .bg-gradient-delivered { background: linear-gradient(135deg, #10b981 0%, #34d399 100%); }
    .bg-gradient-pending { background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); }
    .bg-gradient-total { background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%); }
    .bg-gradient-wallet { background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%); }
    .bg-gradient-earnings { background: linear-gradient(135deg, #06b6d4 0%, #22d3ee 100%); }

    .quick-link-card {
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.5rem;
        background: #fff;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .quick-link-card:hover {
        box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        border-color: #16a34a30;
        transform: translateY(-3px);
    }

    .quick-link-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
    }

    .recent-order-row {
        transition: background 0.2s;
    }

    .recent-order-row:hover {
        background: #f8fafc;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- Welcome --}}
    <div class="mb-4">
        <h4 class="fw-bold text-dark mb-1">Welcome back, {{ auth('delivery')->user()->name }}! 👋</h4>
        <p class="text-muted mb-0">Here's an overview of your delivery activity.</p>
    </div>

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

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card stats-card bg-gradient-delivered">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Today</div>
                            <div class="fs-2 fw-bold">{{ $todayDelivered }}</div>
                            <div class="small text-white-50">Delivered</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-check-double fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card stats-card bg-gradient-pending">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Pending</div>
                            <div class="fs-2 fw-bold">{{ $totalPending }}</div>
                            <div class="small text-white-50">To Deliver</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clock fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card stats-card bg-gradient-total">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Total</div>
                            <div class="fs-2 fw-bold">{{ $totalDelivered }}</div>
                            <div class="small text-white-50">Completed</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-truck fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card stats-card bg-gradient-wallet">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Wallet</div>
                            <div class="fs-2 fw-bold">৳{{ number_format($walletBalance, 0) }}</div>
                            <div class="small text-white-50">Balance</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-wallet fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <a href="{{ route('delivery.assigned-orders') }}" class="quick-link-card">
                <div class="quick-link-icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="fw-bold">Assigned Orders</div>
                <div class="text-muted small">{{ $totalPending }} pending</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('delivery.history') }}" class="quick-link-card">
                <div class="quick-link-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-history"></i>
                </div>
                <div class="fw-bold">History</div>
                <div class="text-muted small">{{ $totalDelivered }} deliveries</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('delivery.wallet') }}" class="quick-link-card">
                <div class="quick-link-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="fw-bold">My Wallet</div>
                <div class="text-muted small">৳{{ number_format($totalEarnings, 0) }} earned</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('delivery.profile') }}" class="quick-link-card">
                <div class="quick-link-icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div class="fw-bold">Profile</div>
                <div class="text-muted small">Edit details</div>
            </a>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
        <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h6 class="section-title mb-0"><i class="fas fa-list me-2 text-success"></i>Recent Orders</h6>
            <a href="{{ route('delivery.assigned-orders') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">View All</a>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-muted small text-uppercase">
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr class="recent-order-row">
                            <td class="fw-bold">#{{ $order->id }}</td>
                            <td>
                                <div class="fw-semibold">{{ $order->name ?? $order->customer_name ?? '-' }}</div>
                                <div class="text-muted small">{{ $order->phone ?? $order->receiver_mobile ?? '' }}</div>
                            </td>
                            <td class="fw-bold text-primary">৳{{ number_format($order->total, 0) }}</td>
                            <td>
                                @if($order->status === 'cancelled')
                                    <span class="badge bg-danger rounded-pill px-3">Cancelled</span>
                                @elseif($order->delivered_at)
                                    <span class="badge bg-success rounded-pill px-3">Delivered</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill px-3">Pending</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('delivery.order.show', $order->id) }}" class="btn btn-sm btn-light rounded-circle shadow-sm">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No orders assigned yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
