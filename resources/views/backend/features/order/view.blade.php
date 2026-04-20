@extends('backend.master')

@section('title', 'Order Management')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .order-status {
        position: relative;
        padding-left: 15px;
    }

    .order-status:before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .status-pending:before {
        background-color: #ffc107;
    }

    .status-confirmed:before {
        background-color: #0d6efd;
    }

    .status-shipped:before {
        background-color: #0dcaf0;
    }

    .status-delivered:before {
        background-color: #198754;
    }

    .status-cancelled:before {
        background-color: #dc3545;
    }

    .payment-status {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: capitalize;
    }

    .payment-paid {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .payment-unpaid {
        background-color: #fff3cd;
        color: #664d03;
    }

    .order-item-count {
        display: inline-flex;
        align-items: center;
        background-color: #f8f9fa;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.75rem;
    }

    .order-actions .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    .stats-card {
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .stats-card .card-body {
        padding: 1.5rem;
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 24px;
    }

    .stats-value {
        font-size: 24px;
        font-weight: 600;
        margin: 8px 0;
    }

    .stats-label {
        color: #6c757d;
        font-size: 14px;
    }

    .trend-indicator {
        font-size: 12px;
        padding: 2px 8px;
        border-radius: 12px;
    }

    .trend-up {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .trend-down {
        background-color: #f8d7da;
        color: #842029;
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
                    <div class="content">
                        <div class="container-fluid">
                            <!-- Page Header -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box">
                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                                                <li class="breadcrumb-item active">Order Management</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">
                                            <i class="mdi mdi-cart-outline me-1"></i>
                                            Order Management
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <!-- End Page Header -->

                            <!-- Stats Cards -->
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card stats-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                                                    <i class="mdi mdi-cart-outline"></i>
                                                </div>
                                                <div>
                                                    <h6 class="stats-label mb-1">Total Orders</h6>
                                                    <h3 class="stats-value mb-0">{{ number_format($totalOrders) }}</h3>
                                                    <div class="trend-indicator trend-up">
                                                        <i class="mdi mdi-trending-up me-1"></i>
                                                        {{ number_format(($totalOrders - $lastMonthOrders) / max($lastMonthOrders, 1) * 100, 1) }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card stats-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
                                                    <i class="mdi mdi-clock-outline"></i>
                                                </div>
                                                <div>
                                                    <h6 class="stats-label mb-1">Pending Orders</h6>
                                                    <h3 class="stats-value mb-0">{{ number_format($pendingOrders) }}</h3>
                                                    <div class="trend-indicator {{ $pendingOrders > $lastMonthPendingOrders ? 'trend-up' : 'trend-down' }}">
                                                        <i class="mdi mdi-trending-{{ $pendingOrders > $lastMonthPendingOrders ? 'up' : 'down' }} me-1"></i>
                                                        {{ number_format(abs(($pendingOrders - $lastMonthPendingOrders) / max($lastMonthPendingOrders, 1) * 100), 1) }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card stats-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                                                    <i class="mdi mdi-currency-usd"></i>
                                                </div>
                                                <div>
                                                    <h6 class="stats-label mb-1">Total Revenue</h6>
                                                    <h3 class="stats-value mb-0">৳{{ number_format($totalRevenue, 2) }}</h3>
                                                    <div class="trend-indicator trend-up">
                                                        <i class="mdi mdi-trending-up me-1"></i>
                                                        {{ number_format(($totalRevenue - $lastMonthRevenue) / max($lastMonthRevenue, 1) * 100, 1) }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card stats-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                                                    <i class="mdi mdi-calendar-check"></i>
                                                </div>
                                                <div>
                                                    <h6 class="stats-label mb-1">Monthly Revenue</h6>
                                                    <h3 class="stats-value mb-0">৳{{ number_format($monthlyRevenue, 2) }}</h3>
                                                    <div class="trend-indicator {{ $monthlyRevenue > $lastMonthRevenue ? 'trend-up' : 'trend-down' }}">
                                                        <i class="mdi mdi-trending-{{ $monthlyRevenue > $lastMonthRevenue ? 'up' : 'down' }} me-1"></i>
                                                        {{ number_format(abs(($monthlyRevenue - $lastMonthRevenue) / max($lastMonthRevenue, 1) * 100), 1) }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Stats Cards -->

                            <!-- Filters and Search -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{ route('orders.list') }}" method="GET" class="row g-3">
                                                <div class="col-md-2">
                                                    <label class="form-label">Order Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="">All Status</option>
                                                        @foreach(\App\Models\Order::getStatuses() as $value => $label)
                                                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Payment Status</label>
                                                    <select name="payment_status" class="form-select">
                                                        <option value="">All Payments</option>
                                                        <option value="1" {{ request('payment_status') == '1' ? 'selected' : '' }}>Paid</option>
                                                        <option value="0" {{ request('payment_status') == '0' ? 'selected' : '' }}>Unpaid</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Date Range</label>
                                                    <input type="text" class="form-control date-range" name="date_range"
                                                        value="{{ request('date_range') }}" placeholder="Select date range">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Search</label>
                                                    <input type="text" class="form-control" name="search"
                                                        value="{{ request('search') }}"
                                                        placeholder="Order ID, Customer Name, Email...">
                                                </div>
                                                <div class="col-md-3 d-flex align-items-end">
                                                    <button type="submit" class="btn btn-primary me-2">
                                                        <i class="mdi mdi-filter me-1"></i> Filter
                                                    </button>
                                                    <a href="{{ route('orders.list') }}" class="btn btn-light me-2">
                                                        <i class="mdi mdi-refresh"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-success" onclick="exportOrders()">
                                                        <i class="mdi mdi-file-excel me-1"></i> Export
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Filters -->

                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-all me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col-sm-4">
                                                    <h4 class="header-title mb-3">Orders List</h4>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="text-sm-end">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('orders.list', ['status' => 'all']) }}" class="btn btn-outline-secondary {{ request('status') == 'all' || !request('status') ? 'active' : '' }}">
                                                                All
                                                            </a>
                                                            <a href="{{ route('orders.list', ['status' => 'pending']) }}" class="btn btn-outline-warning {{ request('status') == 'pending' ? 'active' : '' }}">
                                                                Pending
                                                            </a>
                                                            <a href="{{ route('orders.list', ['status' => 'confirmed']) }}" class="btn btn-outline-primary {{ request('status') == 'confirmed' ? 'active' : '' }}">
                                                                Confirmed
                                                            </a>
                                                            <a href="{{ route('orders.list', ['status' => 'shipped']) }}" class="btn btn-outline-info {{ request('status') == 'shipped' ? 'active' : '' }}">
                                                                Shipped
                                                            </a>
                                                            <a href="{{ route('orders.list', ['status' => 'delivered']) }}" class="btn btn-outline-success {{ request('status') == 'delivered' ? 'active' : '' }}">
                                                                Delivered
                                                            </a>
                                                            <a href="{{ route('orders.list', ['status' => 'cancelled']) }}" class="btn btn-outline-danger {{ request('status') == 'cancelled' ? 'active' : '' }}">
                                                                Cancelled
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-centered table-nowrap table-hover mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input" id="select-all">
                                                                </div>
                                                            </th>
                                                            <th>Order ID</th>
                                                            <th>Customer</th>
                                                            <th>Items</th>
                                                            <th>Total</th>
                                                            <th>Payment</th>
                                                            <th>Status</th>
                                                            <th>Date</th>
                                                            <th style="width: 82px;">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($orders as $key => $order)
                                                        @php
                                                        $itemCount = $order->orderDetails->sum('quantity');
                                                        $statusClass = [
                                                        'pending' => 'warning',
                                                        'confirmed' => 'success',
                                                        'shipped' => 'info',
                                                        'delivered' => 'primary',
                                                        'cancelled' => 'danger'
                                                        ][$order->status] ?? 'secondary';
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input order-checkbox"
                                                                        value="{{ $order->id }}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('order.view', $order->id) }}" class="text-body fw-bold">
                                                                    #{{ $order->id }}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <h5 class="font-14 mb-1">{{ optional($order->user)->name ?? 'Guest User' }}</h5>
                                                                    <span class="text-muted">{{ optional($order->user)->email ?? 'N/A' }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-light text-dark">
                                                                    {{ $itemCount }} {{ Str::plural('item', $itemCount) }}
                                                                </span>
                                                            </td>
                                                            <td>৳{{ number_format($order->total, 2) }}</td>
                                                            <td>
                                                                @if($order->payment_status)
                                                                <span class="badge bg-success">Paid</span>
                                                                @else
                                                                <span class="badge bg-warning">Unpaid</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-{{ $statusClass }}">
                                                                    {{ ucfirst($order->status) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="{{ route('order.view', $order->id) }}"
                                                                        class="btn btn-sm btn-soft-primary"
                                                                        data-bs-toggle="tooltip"
                                                                        title="View Details">
                                                                        <i class="mdi mdi-eye-outline"></i>
                                                                    </a>

                                                                    @if($order->status == 'pending')
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-soft-success"
                                                                        data-bs-toggle="tooltip"
                                                                        title="Confirm Order"
                                                                        onclick="confirmOrder('{{ $order->id }}')">
                                                                        <i class="mdi mdi-check"></i>
                                                                    </button>
                                                                    @endif

                                                                    @if(in_array($order->status, ['pending', 'confirmed']))
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-soft-danger"
                                                                        data-bs-toggle="tooltip"
                                                                        title="Cancel Order"
                                                                        onclick="cancelOrder('{{ $order->id }}')">
                                                                        <i class="mdi mdi-close"></i>
                                                                    </button>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center py-4">
                                                                <img src="{{ asset('assets/images/no-data.svg') }}" alt="No data" height="64">
                                                                <h5 class="mt-2">No orders found</h5>
                                                                <p class="text-muted mb-0">
                                                                    @if(request('status'))
                                                                    No {{ request('status') }} orders available
                                                                    @else
                                                                    No orders have been placed yet
                                                                    @endif
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>

                                            @if($orders->hasPages())
                                            <div class="mt-3">
                                                {{ $orders->appends(request()->query())->links() }}
                                            </div>
                                            @endif
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
</div>

<!-- Bulk Actions Modal -->
<div class="modal fade" id="bulkActionsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Actions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="bulkActionsForm">
                    <div class="mb-3">
                        <label class="form-label">Action</label>
                        <select class="form-select" name="action" required>
                            <option value="">Select Action</option>
                            <option value="confirm">Confirm Orders</option>
                            <option value="cancel">Cancel Orders</option>
                            <option value="export">Export Selected</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="processBulkAction()">Process</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Date Range Picker -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: 'Select an option',
            allowClear: true,
            width: '100%'
        });

        // Initialize Date Range Picker
        $('.date-range').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD'
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });

        $('.date-range').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $('.date-range').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        // Select All Checkbox
        $('#select-all').change(function() {
            $('.order-checkbox').prop('checked', $(this).prop('checked'));
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // -----------------------------
    // Order status update functions
    // -----------------------------
    function updateOrderStatus(orderId, status, message) {
        if (confirm(message)) {
            const form = $('<form>', {
                method: 'POST',
                action: `/admin/orders/status/update/${orderId}`
            });

            const token = $('meta[name="csrf-token"]').attr('content');
            form.append($('<input>', {
                type: 'hidden',
                name: '_token',
                value: token
            }));

            form.append($('<input>', {
                type: 'hidden',
                name: 'status',
                value: status
            }));

            $('body').append(form);
            form.submit();
        }
    }

    function confirmOrder(orderId) {
        updateOrderStatus(orderId, 'confirmed', 'Are you sure you want to confirm this order?');
    }

    function cancelOrder(orderId) {
        updateOrderStatus(orderId, 'cancelled', 'Are you sure you want to cancel this order?');
    }

    // -----------------------------
    // Bulk actions
    // -----------------------------
    function processBulkAction() {
        const selectedOrders = $('.order-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedOrders.length === 0) {
            alert('Please select at least one order');
            return;
        }

        const action = $('#bulkActionsForm select[name="action"]').val();
        if (!action) {
            alert('Please select an action');
            return;
        }

        if (action === 'export') {
            let paramsObj = {
                orders: selectedOrders.join(',')
            };
            const filterForm = document.getElementById('filterForm');
            if (filterForm) {
                Object.assign(paramsObj, Object.fromEntries(new FormData(filterForm)));
            }
            const params = new URLSearchParams(paramsObj);
            window.location.href = `{{ route('orders.export') }}?${params.toString()}`;
            return;
        }

        const message = action === 'confirm' ?
            'Are you sure you want to confirm the selected orders?' :
            'Are you sure you want to cancel the selected orders?';

        if (confirm(message)) {
            const form = $('<form>', {
                method: 'POST',
                action: '{{ route("orders.bulk-update") }}'
            });

            const token = $('meta[name="csrf-token"]').attr('content');
            form.append($('<input>', {
                type: 'hidden',
                name: '_token',
                value: token
            }));

            form.append($('<input>', {
                type: 'hidden',
                name: 'orders',
                value: JSON.stringify(selectedOrders)
            }));

            form.append($('<input>', {
                type: 'hidden',
                name: 'action',
                value: action
            }));

            $('body').append(form);
            form.submit();
        }
    }
</script>

@endpush
