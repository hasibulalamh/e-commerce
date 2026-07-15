@extends('backend.delivery-master')

@section('title', 'Order Details')
@section('breadcrumb', 'Order Details')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Order #{{ $order->id }}</h4>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill"><i class="fas fa-arrow-left me-2"></i>Back</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 1rem;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h6 class="fw-bold mb-0">Order Items</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('uploads/'.$detail->product->image) }}" alt="" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;" class="me-3">
                                            <span class="fw-semibold">{{ $detail->product->name }}</span>
                                        </div>
                                    </td>
                                    <td>৳{{ number_format($detail->price, 2) }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td class="text-end fw-bold">৳{{ number_format($detail->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Subtotal:</td>
                                    <td class="text-end fw-bold">৳{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end text-muted">Shipping:</td>
                                    <td class="text-end text-muted">+৳{{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                @if($order->discount_amount > 0)
                                <tr>
                                    <td colspan="3" class="text-end text-success">Discount:</td>
                                    <td class="text-end text-success">-৳{{ number_format($order->discount_amount, 2) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="text-end fw-bold text-primary">Grand Total:</td>
                                    <td class="text-end fw-bold text-primary">৳{{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 1rem;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h6 class="fw-bold mb-0">Customer Details</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="mb-3">
                        <label class="text-muted small fw-bold text-uppercase">Name</label>
                        <div class="fw-semibold">{{ $order->name ?? $order->receiver_name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small fw-bold text-uppercase">Phone</label>
                        <div class="fw-semibold">
                            <a href="tel:{{ $order->phone ?? $order->receiver_mobile }}" class="text-decoration-none">
                                <i class="fas fa-phone-alt me-1 text-success"></i>{{ $order->phone ?? $order->receiver_mobile }}
                            </a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small fw-bold text-uppercase">Address</label>
                        <div class="fw-semibold">{{ $order->address ?? $order->receiver_address }}</div>
                        <div class="fw-semibold text-muted">{{ $order->city ?? $order->receiver_city }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small fw-bold text-uppercase">Status</label>
                        <div>
                            @if($order->status === 'cancelled')
                                <span class="badge bg-danger rounded-pill px-3 py-2 mt-1">Cancelled</span>
                            @elseif($order->delivered_at)
                                <span class="badge bg-success rounded-pill px-3 py-2 mt-1">Delivered</span>
                            @else
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2 mt-1">Pending Delivery</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
