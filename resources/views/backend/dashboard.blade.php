@extends('backend.master')

@section('title', 'Dashboard - E-Commerce Admin')
@section('breadcrumb', 'Dashboard')

@push('styles')
<style>
    .stats-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        border-radius: 20px;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .bg-glass {
        background: rgba(255, 255, 255, 0.7) !important;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        background: rgba(255,255,255,0.2);
        box-shadow: inset 0 0 10px rgba(255,255,255,0.2);
    }

    .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .bg-gradient-success { background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%); }
    .bg-gradient-info { background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%); }
    .bg-gradient-warning { background: linear-gradient(135deg, #f12711 0%, #f5af19 100%); }

    .chart-card, .table-card {
        border-radius: 20px;
        border: none;
    }

    .product-img {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .smaller { font-size: 0.75rem; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    @if($error)
        <div class="alert alert-danger shadow-sm border-0 mb-4" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ $error }}
        </div>
    @endif

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Revenue Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stats-card bg-gradient-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Total Revenue</div>
                            <div class="fs-3 fw-bold">৳{{ number_format($totalRevenue, 2) }}</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-money-bill-wave fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stats-card bg-gradient-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Total Orders</div>
                            <div class="fs-3 fw-bold">{{ $totalOrders }}</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stats-card bg-gradient-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Customers</div>
                            <div class="fs-3 fw-bold">{{ $totalCustomers }}</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stats-card bg-gradient-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">Active Products</div>
                            <div class="fs-3 fw-bold">{{ $totalProducts }}</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-box fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Alerts Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="card chart-card bg-glass border-0 shadow-lg">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="card-title mb-0 fw-bold">Sales Overview</h5>
                    <p class="text-muted small">Revenue trends over time</p>
                </div>
                <div class="card-body px-4 pb-4">
                    <div style="height: 350px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <!-- Low Stock Alerts -->
            <div class="card table-card bg-glass border-0 shadow-lg mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="card-title mb-0 fw-bold text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Low Stock Alerts
                    </h5>
                </div>
                <div class="card-body px-4">
                    <div class="list-group list-group-flush">
                        @forelse($lowStockProducts as $lp)
                        <div class="list-group-item bg-transparent px-0 border-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('uploads/products/'.$lp->image) }}" class="product-img me-3" 
                                         onerror="this.src='{{ asset('upload/products/'.$lp->image) }}';">
                                    <div>
                                        <div class="fw-bold small">{{ $lp->name }}</div>
                                        <div class="text-muted smaller">SKU: {{ $lp->id }}</div>
                                    </div>
                                </div>
                                <span class="badge bg-danger rounded-pill">{{ $lp->stock }} left</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-3 text-muted">All products are well-stocked.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Top Selling (Moved below Low Stock) -->
            <div class="card table-card bg-glass border-0 shadow-lg">
                <div class="card-header bg-transparent border-0 pt-3 px-4">
                    <h5 class="card-title mb-0 fw-bold">Top Selling</h5>
                </div>
                <div class="card-body px-4 pt-0">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                @foreach($topProducts as $p)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="text-truncate" style="max-width: 120px;">
                                                <div class="fw-bold small">{{ $p->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end fw-bold text-primary">{{ $p->total_sold }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="card table-card mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">Recent Orders</h5>
                    <a href="{{ route('orders.list') }}" class="btn btn-sm btn-outline-primary rounded-pill">View All Orders</a>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr class="text-muted small text-uppercase">
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td class="fw-bold">#ORD-{{ $order->id }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $order->name }}</div>
                                        <div class="text-muted small">{{ $order->email }}</div>
                                    </td>
                                    <td class="fw-bold text-primary">৳{{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($order->status) {
                                                'completed' => 'bg-success',
                                                'pending' => 'bg-warning',
                                                'processing' => 'bg-info',
                                                'cancelled' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} rounded-pill px-3">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td class="text-muted small">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('order.view', $order->id) }}" class="btn btn-sm btn-light rounded-circle shadow-sm">
                                            <i class="fas fa-eye text-primary"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center text-muted py-5">No orders found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Gradient background
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(78, 115, 223, 0.2)');
    gradient.addColorStop(1, 'rgba(78, 115, 223, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                label: 'Revenue (BDT)',
                data: {!! json_encode($monthlyData) !!},
                borderColor: '#4e73df',
                borderWidth: 3,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4e73df',
                pointHoverRadius: 5,
                pointHoverBackgroundColor: '#4e73df',
                pointHoverBorderColor: '#fff',
                pointHitRadius: 10,
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: '#fff',
                    titleColor: '#333',
                    bodyColor: '#666',
                    borderColor: '#eee',
                    borderWidth: 1,
                    padding: 10,
                    callbacks: {
                        label: function(context) {
                            return '৳' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [2, 2], color: '#f0f0f0' },
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000) return '৳' + (value/1000) + 'k';
                            return '৳' + value;
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endpush
