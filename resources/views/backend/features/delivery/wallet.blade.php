@extends('backend.delivery-master')

@section('title', 'My Wallet')
@section('breadcrumb', 'Wallet')

@push('styles')
<style>
    .wallet-card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }
    .bg-gradient-primary { background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%); }
    .bg-gradient-secondary { background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%); }
    .bg-gradient-tertiary { background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%); }
    
    .transaction-card {
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 1rem;
        background: #fff;
        transition: all 0.3s ease;
    }
    .transaction-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .transaction-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.25rem;
    }
    .icon-earning { background: #dcfce7; color: #16a34a; }
    .icon-payout { background: #fee2e2; color: #ef4444; }
    .icon-bonus { background: #fef3c7; color: #f59e0b; }
    .icon-deduction { background: #f3f4f6; color: #6b7280; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card wallet-card bg-gradient-primary h-100">
                <div class="card-body p-4">
                    <h6 class="text-white-50 text-uppercase fw-bold mb-3">Available Balance</h6>
                    <h2 class="fw-bold mb-0">৳{{ number_format($walletBalance, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card wallet-card bg-gradient-secondary h-100">
                <div class="card-body p-4">
                    <h6 class="text-white-50 text-uppercase fw-bold mb-3">Total Earnings</h6>
                    <h2 class="fw-bold mb-0">৳{{ number_format($totalEarnings, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card wallet-card bg-gradient-tertiary h-100">
                <div class="card-body p-4">
                    <h6 class="text-white-50 text-uppercase fw-bold mb-3">This Month</h6>
                    <h2 class="fw-bold mb-0">৳{{ number_format($thisMonthEarnings, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
        <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0"><i class="fas fa-exchange-alt me-2 text-primary"></i>Transaction History</h6>
        </div>
        <div class="card-body px-4 pb-4">
            @forelse($transactions as $txn)
            <div class="transaction-card d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="transaction-icon icon-{{ $txn->type }}">
                        @if($txn->type === 'earning')
                            <i class="fas fa-arrow-down"></i>
                        @elseif($txn->type === 'payout')
                            <i class="fas fa-arrow-up"></i>
                        @elseif($txn->type === 'bonus')
                            <i class="fas fa-gift"></i>
                        @else
                            <i class="fas fa-minus-circle"></i>
                        @endif
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">{{ ucfirst($txn->type) }}</h6>
                        <div class="text-muted small">{{ $txn->description ?? 'Transaction' }} | {{ $txn->created_at->format('d M, Y h:i A') }}</div>
                    </div>
                </div>
                <div class="text-end">
                    <h6 class="fw-bold mb-1 {{ in_array($txn->type, ['earning', 'bonus']) ? 'text-success' : 'text-danger' }}">
                        {{ in_array($txn->type, ['earning', 'bonus']) ? '+' : '-' }}৳{{ number_format($txn->amount, 2) }}
                    </h6>
                    <div class="text-muted small">Balance: ৳{{ number_format($txn->balance_after, 2) }}</div>
                </div>
            </div>
            @empty
            <div class="text-center py-5 text-muted">
                <i class="fas fa-wallet fa-3x mb-3 text-light"></i>
                <h5>No transactions yet</h5>
                <p>Complete deliveries to earn into your wallet.</p>
            </div>
            @endforelse

            @if($transactions->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $transactions->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
