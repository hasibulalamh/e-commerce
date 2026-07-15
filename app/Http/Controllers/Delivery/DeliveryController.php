<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Mail\DeliveryOtpMail;
use App\Models\DeliveryOtp;
use App\Models\DeliveryWalletTransaction;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    /**
     * Dashboard — overview stats for delivery man
     */
    public function dashboard()
    {
        $staffId = Auth::guard('delivery')->id();

        $todayDelivered = Order::query()
            ->where('delivery_staff_id', $staffId)
            ->whereDate('delivered_at', today())
            ->count();

        $totalPending = Order::query()
            ->where('delivery_staff_id', $staffId)
            ->whereNull('delivered_at')
            ->where('delivery_channel', 'in_house')
            ->where('status', '!=', 'cancelled')
            ->count();

        $totalDelivered = Order::query()
            ->where('delivery_staff_id', $staffId)
            ->whereNotNull('delivered_at')
            ->count();

        $totalEarnings = Auth::guard('delivery')->user()->total_earned ?? 0;

        $walletBalance = Auth::guard('delivery')->user()->wallet_balance ?? 0;

        // Recent 5 orders for quick look
        $recentOrders = Order::query()
            ->where('delivery_staff_id', $staffId)
            ->where('delivery_channel', 'in_house')
            ->latest()
            ->take(5)
            ->get();

        return view('backend.features.delivery.dashboard', compact(
            'todayDelivered',
            'totalPending',
            'totalDelivered',
            'totalEarnings',
            'walletBalance',
            'recentOrders'
        ));
    }

    /**
     * Assigned Orders — pending orders list with OTP actions
     */
    public function assignedOrders()
    {
        $staffId = Auth::guard('delivery')->id();

        $orders = Order::query()
            ->where('delivery_staff_id', $staffId)
            ->where('delivery_channel', 'in_house')
            ->whereNull('delivered_at')
            ->where('status', '!=', 'cancelled')
            ->latest()
            ->paginate(15);

        return view('backend.features.delivery.assigned-orders', compact('orders'));
    }

    /**
     * Delivery History — completed deliveries
     */
    public function deliveryHistory(Request $request)
    {
        $staffId = Auth::guard('delivery')->id();

        $query = Order::query()
            ->where('delivery_staff_id', $staffId)
            ->whereNotNull('delivered_at');

        // Filter by date
        if ($request->filled('date_from')) {
            $query->whereDate('delivered_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('delivered_at', '<=', $request->date_to);
        }

        $orders = $query->latest('delivered_at')->paginate(15);

        return view('backend.features.delivery.delivery-history', compact('orders'));
    }

    /**
     * Order Details — view single order
     */
    public function orderShow(Order $order)
    {
        $staffId = Auth::guard('delivery')->id();
        abort_unless($order->delivery_staff_id === $staffId, 403);

        $order->load('orderDetails');

        return view('backend.features.delivery.order-show', compact('order'));
    }

    /**
     * Wallet — earnings overview and transaction history
     */
    public function wallet(Request $request)
    {
        $staff = Auth::guard('delivery')->user();

        $query = DeliveryWalletTransaction::query()
            ->where('delivery_staff_id', $staff->id);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->paginate(20);

        $totalEarnings = $staff->total_earned ?? 0;
        $walletBalance = $staff->wallet_balance ?? 0;

        $thisMonthEarnings = DeliveryWalletTransaction::query()
            ->where('delivery_staff_id', $staff->id)
            ->where('type', 'earning')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $totalPayouts = DeliveryWalletTransaction::query()
            ->where('delivery_staff_id', $staff->id)
            ->where('type', 'payout')
            ->sum('amount');

        return view('backend.features.delivery.wallet', compact(
            'transactions',
            'totalEarnings',
            'walletBalance',
            'thisMonthEarnings',
            'totalPayouts'
        ));
    }

    /**
     * Profile page
     */
    public function profile()
    {
        return view('backend.features.delivery.profile', ['user' => Auth::guard('delivery')->user()]);
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('delivery')->user();

        try {
            $request->validate([
                'name'  => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'password' => 'nullable|string|min:6|confirmed',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            notify()->error('Validation failed. Please check the form.');
            throw $e;
        }

        $user->name = $request->name;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        notify()->success('Profile updated successfully.');
        return redirect()->route('delivery.profile');
    }

    /**
     * Staff sends OTP to customer for in-house delivery
     */
    public function staffSendOtp(Order $order)
    {
        abort_unless($order->delivery_channel === 'in_house', 403, 'This order is not on the in-house channel.');
        abort_unless($order->delivery_staff_id === Auth::guard('delivery')->id(), 403);

        return $this->issueOtp($order, 'in_house');
    }

    /**
     * Staff verifies OTP entered by customer
     */
    public function staffVerifyOtp(Request $request, Order $order)
    {
        abort_unless($order->delivery_channel === 'in_house', 403);
        abort_unless($order->delivery_staff_id === Auth::guard('delivery')->id(), 403);

        return $this->verifyOtp($request, $order, verifiedByStaffId: Auth::guard('delivery')->id());
    }

    public function triggerSteadfastOtp(Order $order)
    {
        abort_unless($order->customer_id === Auth::guard('customer')->id(), 403);
        abort_unless($order->delivery_channel === 'steadfast', 403);

        return $this->issueOtp($order, 'steadfast');
    }

    public function showConfirmDeliveryPage(Order $order)
    {
        abort_unless($order->customer_id === Auth::guard('customer')->id(), 403);
        abort_unless($order->delivery_channel === 'steadfast', 403);

        if ($order->delivered_at) {
            return redirect()->route('customer.orders')->with('info', 'This order has already been delivered.');
        }

        // Auto-send OTP if none has been sent within last 2 minutes
        $recent = DeliveryOtp::query()
            ->where('order_id', $order->id)
            ->where('channel', 'steadfast')
            ->where('created_at', '>', now()->subMinutes(2))
            ->whereNull('verified_at')
            ->exists();

        if (!$recent) {
            $otp = (string) random_int(100000, 999999);

            DeliveryOtp::create([
                'order_id'   => $order->id,
                'channel'    => 'steadfast',
                'otp_hash'   => Hash::make($otp),
                'expires_at' => now()->addMinutes(30),
            ]);

            $email = $order->email ?? $order->receiver_email;
            if ($email) {
                try {
                    Mail::to($email)->send(new DeliveryOtpMail($order, $otp, 'steadfast'));
                    session()->flash('success', 'A verification OTP has been sent to your email.');
                } catch (\Exception $e) {
                    \Log::error('Steadfast OTP send error: ' . $e->getMessage());
                    session()->flash('error', 'Failed to send OTP to your email. Please try again.');
                }
            }
        }

        return view('frontend.pages.confirm-delivery', compact('order'));
    }

    public function customerVerifyOtp(Request $request, Order $order)
    {
        abort_unless($order->customer_id === Auth::guard('customer')->id(), 403);
        abort_unless($order->delivery_channel === 'steadfast', 403);

        return $this->verifyOtp($request, $order, verifiedByStaffId: null, ip: $request->ip());
    }

    private function issueOtp(Order $order, string $channel)
    {
        if ($order->delivered_at) {
            return back()->with('error', 'This order has already been delivered.');
        }

        $recent = DeliveryOtp::query()
            ->where('order_id', $order->id)
            ->where('created_at', '>', now()->subMinutes(2))
            ->whereNull('verified_at')
            ->exists();

        if ($recent) {
            return back()->with('error', 'An OTP was already sent recently. Please wait 2 minutes before requesting again.');
        }

        $otp = (string) random_int(100000, 999999);

        DeliveryOtp::create([
            'order_id'   => $order->id,
            'channel'    => $channel,
            'otp_hash'   => Hash::make($otp),
            'expires_at' => now()->addMinutes(30),
        ]);

        $email = $order->email ?? $order->receiver_email;
        if ($email) {
            Mail::to($email)->send(new DeliveryOtpMail($order, $otp, $channel));
        }

        return back()->with('success', 'OTP sent to the customer.');
    }

    private function verifyOtp(Request $request, Order $order, ?int $verifiedByStaffId, ?string $ip = null)
    {
        $request->validate(['otp' => 'required|digits:6']);

        return DB::transaction(function () use ($request, $order, $verifiedByStaffId, $ip) {
            // Lock the order for update to prevent concurrent updates
            $lockedOrder = Order::where('id', $order->id)->lockForUpdate()->firstOrFail();

            if ($lockedOrder->delivered_at || $lockedOrder->status === 'delivered') {
                return back()->with('error', 'This order has already been delivered.');
            }

            $deliveryOtp = DeliveryOtp::query()
                ->where('order_id', $lockedOrder->id)
                ->where('channel', $lockedOrder->delivery_channel)
                ->whereNull('verified_at')
                ->latest()
                ->lockForUpdate()
                ->first();

            if (!$deliveryOtp) {
                return back()->with('error', 'No OTP has been sent yet. Please send an OTP first.');
            }

            if ($deliveryOtp->isLocked()) {
                return back()->with('error', 'Too many incorrect attempts. Please request a new OTP.');
            }

            if ($deliveryOtp->isExpired()) {
                return back()->with('error', 'This OTP has expired. Please request a new one.');
            }

            if (!Hash::check($request->otp, $deliveryOtp->otp_hash)) {
                $deliveryOtp->increment('attempts');
                return back()->with('error', 'Incorrect OTP. Please try again.');
            }

            $deliveryOtp->update([
                'verified_at'           => now(),
                'verified_by_staff_id'  => $verifiedByStaffId,
                'verified_ip'           => $ip,
            ]);

            $lockedOrder->update(['delivered_at' => now(), 'status' => 'delivered']);

            // Credit delivery fee to wallet if in-house and staff verified
            if ($verifiedByStaffId && $lockedOrder->delivery_channel === 'in_house') {
                $this->creditDeliveryEarning($lockedOrder, $verifiedByStaffId);

                \App\Models\DeliveryReport::create([
                    'order_id'          => $lockedOrder->id,
                    'delivery_staff_id' => $verifiedByStaffId,
                    'status_reported'   => 'delivered',
                    'reason'            => 'Successfully verified via OTP',
                ]);
            }

            return back()->with('success', "Order #{$lockedOrder->id} delivery confirmed successfully!");
        });
    }

    /**
     * Delivery staff reports an issue (pending or cancelled)
     */
    public function reportIssue(Request $request, Order $order)
    {
        abort_unless($order->delivery_channel === 'in_house', 403);
        abort_unless($order->delivery_staff_id === Auth::guard('delivery')->id(), 403);

        $request->validate([
            'status_reported' => 'required|in:pending,cancelled',
            'reason'          => 'required|string|max:1000',
        ]);

        $status = $request->status_reported;

        \App\Models\DeliveryReport::create([
            'order_id'          => $order->id,
            'delivery_staff_id' => Auth::guard('delivery')->id(),
            'status_reported'   => $status,
            'reason'            => $request->reason,
        ]);

        if ($status === 'cancelled') {
            $order->update([
                'status' => 'cancelled',
            ]);
        }

        \App\Models\OrderStatusHistory::create([
            'order_id'   => $order->id,
            'status'     => $order->status,
            'notes'      => "Delivery Man Report: {$status} - {$request->reason}",
            'changed_by' => null
        ]);

        return back()->with('success', "Report submitted successfully for Order #{$order->id}");
    }

    /**
     * Credit delivery earning to staff wallet (runs inside parent transaction, locks staff record)
     */
    private function creditDeliveryEarning(Order $order, int $staffId)
    {
        $deliveryFee = $order->delivery_fee ?? $order->shipping_cost ?? 0;

        if ($deliveryFee <= 0) {
            return;
        }

        $staff = \App\Models\DeliveryStaff::where('id', $staffId)->lockForUpdate()->first();
        if (!$staff) {
            return;
        }

        $newBalance = $staff->wallet_balance + $deliveryFee;

        DeliveryWalletTransaction::create([
            'delivery_staff_id' => $staffId,
            'order_id'          => $order->id,
            'type'              => 'earning',
            'amount'            => $deliveryFee,
            'balance_after'     => $newBalance,
            'description'       => "Delivery fee for Order #{$order->id}",
        ]);

        $staff->update([
            'wallet_balance' => $newBalance,
            'total_earned'   => $staff->total_earned + $deliveryFee,
        ]);
    }
}
