@extends('backend.master')

@section('title', 'Delivery Reports')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">
                            <i class="mdi mdi-alert-circle-outline me-1"></i> Delivery Issues & Reports
                        </h4>
                    </div>
                </div>
            </div>

            <!-- Reports List -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-centered table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>Delivery Man</th>
                                            <th>Order ID</th>
                                            <th>Reported Status</th>
                                            <th>Reason / Notes</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($reports as $report)
                                        <tr>
                                            <td>{{ $report->created_at->format('d M, Y h:i A') }}</td>
                                            <td>
                                                <strong>{{ $report->deliveryStaff->name ?? 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $report->deliveryStaff->phone ?? '' }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('order.view', $report->order_id) }}" class="fw-bold">#{{ $report->order_id }}</a>
                                            </td>
                                            <td>
                                                @if($report->status_reported === 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @elseif($report->status_reported === 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @else
                                                    <span class="badge bg-success">{{ ucfirst($report->status_reported) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="text-wrap" style="max-width: 300px;">
                                                    {{ $report->reason }}
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('order.view', $report->order_id) }}" class="btn btn-sm btn-info">
                                                    <i class="mdi mdi-eye"></i> View Order
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <p class="text-muted mb-0">No delivery reports found.</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($reports->hasPages())
                            <div class="mt-4">
                                {{ $reports->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
