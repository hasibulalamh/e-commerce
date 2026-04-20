<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; font-size:14px; color:#333; }
        .invoice-box { max-width:800px; margin:30px auto; padding:30px; 
                       border:1px solid #eee; box-shadow:0 0 10px rgba(0,0,0,0.15); }
        .header { display:flex; justify-content:space-between; margin-bottom:30px; }
        .company { font-size:24px; font-weight:700; color:#e44d26; }
        .invoice-title { font-size:28px; color:#888; text-align:right; }
        .invoice-meta { font-size:13px; color:#666; text-align:right; }
        table { width:100%; border-collapse:collapse; margin:20px 0; }
        th { background:#f8f9fa; padding:10px; text-align:left; 
             border-bottom:2px solid #dee2e6; font-size:13px; }
        td { padding:10px; border-bottom:1px solid #f0f0f0; }
        .total-section { text-align:right; margin-top:20px; }
        .total-row { display:flex; justify-content:flex-end; 
                     gap:30px; margin:5px 0; }
        .grand-total { font-size:1.2rem; font-weight:700; color:#e44d26; }
        .footer { margin-top:40px; text-align:center; color:#888; 
                  font-size:12px; border-top:1px solid #eee; padding-top:20px; }
        .status-badge { background:#d4edda; color:#155724; padding:3px 10px;
                        border-radius:20px; font-size:12px; }
        @media print {
            .no-print { display:none !important; }
            body { margin:0; }
            .invoice-box { box-shadow:none; border:none; }
        }
    </style>
</head>
<body>
<div class="invoice-box">
    
    {{-- Print/Download Button --}}
    <div class="no-print" style="text-align:right; margin-bottom:20px;">
        <button onclick="window.print()" 
                style="background:#e44d26; color:white; border:none;
                       padding:10px 25px; border-radius:5px; cursor:pointer;
                       font-size:14px; font-weight:600;">
            🖨️ Print / Save as PDF
        </button>
        <a href="{{ route('order.view', $order->id) }}"
           style="background:#6c757d; color:white; border:none;
                  padding:10px 25px; border-radius:5px; cursor:pointer;
                  font-size:14px; font-weight:600; text-decoration:none;
                  margin-left:10px;">
            ← Back to Order
        </a>
    </div>

    {{-- Header --}}
    <div class="header">
        <div>
            <div class="company">Capital Shop</div>
            <div style="color:#888; font-size:13px; margin-top:5px;">
                Dhaka, Bangladesh<br>
                support@capitalshop.com
            </div>
        </div>
        <div>
            <div class="invoice-title">INVOICE</div>
            <div class="invoice-meta">
                Invoice #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}<br>
                Date: {{ $order->created_at->format('d M Y') }}<br>
                Status: <span class="status-badge">{{ ucfirst($order->status ?? 'pending') }}</span>
            </div>
        </div>
    </div>

    <hr style="border:1px solid #eee; margin:20px 0;">

    {{-- Customer + Order Info --}}
    <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
        <div>
            <div style="font-weight:700; color:#333; margin-bottom:8px;">Bill To:</div>
            <div style="color:#555; line-height:1.8;">
                <strong>{{ $order->receiver_name ?? $order->name }}</strong><br>
                {{ $order->receiver_email ?? $order->email }}<br>
                {{ $order->receiver_mobile ?? $order->phone }}<br>
                {{ $order->receiver_address ?? $order->address }}<br>
                {{ $order->receiver_city ?? $order->city }}
            </div>
        </div>
        <div style="text-align:right;">
            <div style="font-weight:700; color:#333; margin-bottom:8px;">Payment Info:</div>
            <div style="color:#555; line-height:1.8;">
                Method: {{ $order->payment_method ?? 'CASH' }}<br>
                Status: {{ ucfirst($order->pay_status ?? 'unpaid') }}
            </div>
        </div>
    </div>

    {{-- Items Table --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th style="text-align:center;">Quantity</th>
                <th style="text-align:right;">Unit Price</th>
                <th style="text-align:right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->product->name ?? 'Product #'.$detail->product_id }}</td>
                <td style="text-align:center;">{{ $detail->quantity }}</td>
                <td style="text-align:right;">৳{{ number_format($detail->price, 2) }}</td>
                <td style="text-align:right; font-weight:600;">
                    ৳{{ number_format($detail->price * $detail->quantity, 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Totals --}}
    <div class="total-section">
        @php
            $subtotal = $order->orderDetails->sum(fn($d) => $d->price * $d->quantity);
            $shipping = $order->total - $subtotal;
        @endphp
        <div class="total-row">
            <span style="color:#666;">Subtotal:</span>
            <span style="font-weight:600; min-width:120px; text-align:right;">
                ৳{{ number_format($subtotal, 2) }}
            </span>
        </div>
        <div class="total-row">
            <span style="color:#666;">Shipping:</span>
            <span style="font-weight:600; min-width:120px; text-align:right;">
                ৳{{ number_format(max($shipping, 0), 2) }}
            </span>
        </div>
        <hr style="margin:10px 0; border-color:#eee;">
        <div class="total-row grand-total">
            <span>Grand Total:</span>
            <span style="min-width:120px; text-align:right;">
                ৳{{ number_format($order->total, 2) }}
            </span>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Thank you for shopping with Capital Shop!</p>
        <p>For any queries, contact: support@capitalshop.com</p>
    </div>

</div>
</body>
</html>
