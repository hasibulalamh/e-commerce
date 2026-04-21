<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class OrderListController extends Controller
{
    public function list(Request $request)
    {
        // Get filter parameters
        $status = $request->status;
        $paymentStatus = $request->payment_status;
        $dateRange = $request->date_range;
        $search = $request->search;
        $perPage = 15;

        // Base query with relationships
        $query = Order::with(['orderDetails' => function($q) {
            $q->with('product');
        }, 'user', 'customer'])->latest();

        // Apply filters
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($paymentStatus !== null) {
            $query->where('payment_status', $paymentStatus);
        }

        if ($dateRange) {
            $dates = explode(' - ', $dateRange);
            if (count($dates) === 2) {
                $startDate = Carbon::parse($dates[0])->startOfDay();
                $endDate = Carbon::parse($dates[1])->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        // Apply search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Get statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        $monthlyRevenue = Order::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // Get last month's statistics for comparison
        $lastMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $lastMonthPendingOrders = Order::where('status', 'pending')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $lastMonthRevenue = Order::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total');

        $orders = $query->paginate($perPage);

        return view('backend.features.order.list', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'totalRevenue',
            'monthlyRevenue',
            'lastMonthOrders',
            'lastMonthPendingOrders',
            'lastMonthRevenue'
        ));
    }

    /**
     * Display the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try {
            $order = Order::with(['orderDetails.product.category', 'orderDetails.product.brand', 'statusHistories.changedBy', 'user', 'customer'])
                ->findOrFail($id);

            // Calculate order totals
            $subtotal = $order->orderDetails->sum(function($item) {
                return ($item->price * $item->quantity) - $item->discount;
            });

            $discount = $order->orderDetails->sum('discount');
            $shipping = $order->shipping_cost ?? 0;
            $tax = $order->tax ?? 0;
            $total = $subtotal + $shipping + $tax;

            // Get status histories with pagination
            $statusHistories = $order->statusHistories()
                ->with('changedBy')
                ->latest()
                ->paginate(10);

            return view('backend.features.order.details', compact(
                'order',
                'subtotal',
                'discount',
                'shipping',
                'tax',
                'total',
                'statusHistories'
            ));
        } catch (\Exception $e) {
            Log::error('Error in OrderListController@show: ' . $e->getMessage());
            return redirect()->route('orders.list')->with('error', 'Error loading order details.');
        }
    }

    // Display status history for an order
    public function statusHistory($id)
    {
        $order = Order::findOrFail($id);
        $statusHistories = $order->statusHistories()
            ->with('changedBy')
            ->latest()
            ->paginate(10);

        // Get allowed status transitions for the current status
        $allowedTransitions = $this->getAllowedStatusTransitions($order->status);

        return view('backend.features.order.status-history', compact('order', 'statusHistories', 'allowedTransitions'));
    }

    public function confirm($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'Order confirmed successfully!');
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Order cancelled successfully!');
    }
    // Update the status of an order.

    public function updateStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $order = Order::findOrFail($id);
            $previousStatus = $order->status;
            $newStatus = $request->status;

            // Validate status transition
            $allowedTransitions = $this->getAllowedStatusTransitions($previousStatus);
            if (!in_array($newStatus, $allowedTransitions)) {
                throw new \Exception('Invalid status transition from ' . $previousStatus . ' to ' . $newStatus);
            }

            // Update order status
            $order->status = $newStatus;
            $order->save();

            // Create status history record
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $newStatus,
                'notes' => $request->notes,
                'changed_by' => Auth::id()
            ]);

            // Handle specific status change actions
            $this->handleStatusChangeActions($order, $newStatus, $previousStatus, $request);

            // Send notifications
            $this->sendStatusNotifications($order, $newStatus, $previousStatus);

            DB::commit();

            return redirect()->back()->with('success', 'Order status updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating order status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating order status: ' . $e->getMessage());
        }
    }

     //Get allowed status transitions for the current status.

    protected function getAllowedStatusTransitions($currentStatus)
    {
        $transitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['shipped', 'cancelled'],
            'shipped' => ['delivered', 'cancelled'],
            'delivered' => [],
            'cancelled' => []
        ];

        return $transitions[$currentStatus] ?? [];
    }

     //Handle specific actions based on status change.

    protected function handleStatusChangeActions($order, $newStatus, $previousStatus, $request)
    {
        switch ($newStatus) {
            case 'confirmed':
                // Stock already decremented at order placement (OrderController@storeaddorder)
                // No additional stock changes needed here
                break;

            case 'cancelled':
                // Restore inventory if order was previously confirmed
                if ($previousStatus === 'confirmed') {
                    foreach ($order->orderDetails as $detail) {
                        $product = $detail->product;
                        if ($product) {
                            $product->stock += $detail->quantity;
                            $product->save();
                        }
                    }
                }
                break;

            case 'delivered':
                // Update payment status if not already paid
                if (!$order->payment_status) {
                    $order->payment_status = true;
                    $order->save();
                }
                break;
        }
    }

    // Send notifications for status change.

    protected function sendStatusNotifications($order, $newStatus, $previousStatus)
    {
        if ($order->customer) {
            try {
                $order->customer->notify(new \App\Notifications\ShippingStatusNotification($order, $newStatus));
            } catch (\Exception $e) {
                \Log::error('Status Mail Error: ' . $e->getMessage());
            }
        }
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'status' => 'required|string|in:' . implode(',', [
                Order::STATUS_CONFIRMED,
                Order::STATUS_CANCELLED
            ]),
        ]);

        $orderIds = $request->order_ids;
        $status = $request->status;

        DB::beginTransaction();

        try {
            $orders = Order::whereIn('id', $orderIds)->get();

            foreach ($orders as $order) {
                if (in_array($status, $this->getAllowedStatusTransitions($order->status))) {
                    $previousStatus = $order->status;

                    // Update order status
                    $order->update(['status' => $status]);

                    // Create status history
                    OrderStatusHistory::create([
                        'order_id' => $order->id,
                        'status' => $status,
                        'notes' => 'Bulk status update',
                        'changed_by' => Auth::id(),
                    ]);

                    // Handle specific actions
                    $this->handleStatusChangeActions($order, $status, $previousStatus, $request);

                    // Send notifications
                    $this->sendStatusNotifications($order, $status, $previousStatus);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Selected orders have been updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to perform bulk update: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update orders. Please try again.');
        }
    }

    public function export(Request $request)
    {
        $query = Order::with(['orderDetails', 'user', 'customer']);

        // Apply filters
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->payment_status !== null) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->date_range) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) === 2) {
                $startDate = Carbon::parse($dates[0])->startOfDay();
                $endDate = Carbon::parse($dates[1])->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('id', 'like', "%{$request->search}%")
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', "%{$request->search}%")
                        ->orWhere('email', 'like', "%{$request->search}%");
                  })
                  ->orWhereHas('customer', function($q) use ($request) {
                      $q->where('name', 'like', "%{$request->search}%")
                        ->orWhere('email', 'like', "%{$request->search}%");
                  });
            });
        }

        // If specific orders are selected
        if ($request->selected_orders) {
            $selectedIds = explode(',', $request->selected_orders);
            $query->whereIn('id', $selectedIds);
        }

        $orders = $query->get();

        $headers = [
            'Order ID',
            'Customer Name',
            'Customer Email',
            'Order Date',
            'Status',
            'Payment Status',
            'Total Items',
            'Total Amount',
            'Shipping Address',
            'Notes'
        ];

        $rows = [];
        foreach ($orders as $order) {
            $rows[] = [
                $order->id,
                $order->customer_id ? ($order->customer->name ?? 'N/A') : ($order->user->name ?? 'N/A'),
                $order->customer_id ? ($order->customer->email ?? 'N/A') : ($order->user->email ?? 'N/A'),
                $order->created_at->format('Y-m-d H:i:s'),
                ucfirst($order->status),
                $order->payment_status ? 'Paid' : 'Unpaid',
                $order->orderDetails->sum('quantity'),
                $order->total,
                $order->shipping_address,
                $order->notes
            ];
        }

        $filename = 'orders-export-' . date('Y-m-d-H-i-s') . '.csv';

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $headers);

        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
    public function invoice($id)
    {
        $order = Order::with(['orderDetails.product', 'customer'])
                      ->findOrFail($id);
        return view('backend.features.order.invoice', compact('order'));
    }
}
