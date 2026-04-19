@extends('frontend.master')
@section('content')
<main>
    <div class="hero-area section-bg2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="slider-area">
                        <div class="slider-height2 slider-bg4 d-flex align-items-center justify-content-center">
                            <div class="hero-caption hero-caption2">
                                <h2>Order Details #{{ $order->id }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-50 pb-50">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Items</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $item)
                                <tr>
                                    <td>
                                        <div class="media">
                                            <img src="{{ asset('uploads/products/' . ($item->product->image ?? 'default.jpg')) }}" alt="" style="width: 50px;" class="mr-3">
                                            <div class="media-body">
                                                <p>{{ $item->product->name ?? 'Deleted Product' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ number_format($item->unit_price, 2) }}</td>
                                    <td>{{ $item->pro_quentity }}</td>
                                    <td>{{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Subtotal:</th>
                                    <th>{{ number_format($order->subtotal, 2) }} BDT</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Shipping:</th>
                                    <th>100.00 BDT</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Total:</th>
                                    <th>{{ number_format($order->total, 2) }} BDT</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Status History</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($order->statusHistories as $history)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ ucfirst($history->status) }}</strong>
                                    <br><small class="text-muted">{{ $history->comment }}</small>
                                </div>
                                <span class="badge badge-secondary">{{ $history->created_at->format('d M Y, h:i A') }}</span>
                            </li>
                            @empty
                            <li class="list-group-item">No status history available.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Info</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Status:</strong> <span class="badge badge-info">{{ ucfirst($order->status) }}</span></p>
                        <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                        <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Shipping Address</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $order->receiver_name }}</p>
                        <p><strong>Email:</strong> {{ $order->receiver_email }}</p>
                        <p><strong>Phone:</strong> {{ $order->receiver_mobile }}</p>
                        <p><strong>Address:</strong> {{ $order->receiver_address }}</p>
                        <p><strong>City:</strong> {{ $order->receiver_city }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
