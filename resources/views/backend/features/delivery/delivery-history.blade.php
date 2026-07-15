@extends('backend.delivery-master')

@section('title', 'Delivery History')
@section('breadcrumb', 'Delivery History')

@push('styles')
<style>
    .history-card {
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 1rem;
        background: #fff;
        transition: all 0.3s ease;
    }
    .history-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-color: #cbd5e1;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="fas fa-history text-success me-2"></i>Delivery History</h4>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 1rem;">
        <div class="card-body p-4">
            <form action="{{ route('delivery.history') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label text-muted small fw-bold text-uppercase">From Date</label>
                    <input type="date" name="date_from" class="form-control form-control-lg" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small fw-bold text-uppercase">To Date</label>
                    <input type="date" name="date_to" class="form-control form-control-lg" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success btn-lg w-100">Filter History</button>
                </div>
            </form>
        </div>
    </div>

    @forelse($orders as $order)
    <div class="history-card">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fw-bold mb-1">
                    <a href="{{ route('delivery.order.show', $order->id) }}" class="text-decoration-none text-dark">Order #{{ $order->id }}</a>
                </h6>
                <div class="text-muted small">
                    <i class="fas fa-user me-1"></i> {{ $order->name ?? $order->customer_name }} | 
                    <i class="fas fa-check-circle text-success me-1"></i> Delivered: {{ \Carbon\Carbon::parse($order->delivered_at)->format('d M, Y h:i A') }}
                </div>
            </div>
            <div class="text-end">
                <span class="badge bg-success rounded-pill px-3 py-2">Delivered</span>
                <div class="mt-2 fw-bold text-primary">৳{{ number_format($order->total, 2) }}</div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5 text-muted">
        <i class="fas fa-box-open fa-3x mb-3 text-light"></i>
        <h5>No deliveries found</h5>
        <p>You haven't completed any deliveries matching these criteria yet.</p>
    </div>
    @endforelse

    @if($orders->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
