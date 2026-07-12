<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Mail\DeliveryOtpMail;
use App\Models\DeliveryOtp;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    public function dashboard()
    {
        $staffId = Auth::guard('delivery')->id();

        $orders = Order::query()
            ->where('delivery_staff_id', $staffId)
            ->where('delivery_channel', 'in_house')
            ->whereNull('delivered_at')
            ->latest()
            ->get();

        $todayDelivered = Order::query()
            ->where('delivery_staff_id', $staffId)
            ->whereDate('delivered_at', today())
            ->count();

        $totalPending = Order::query()
            ->where('delivery_staff_id', $staffId)
            ->whereNull('delivered_at')
            ->count();

        return view('backend.features.delivery.dashboard', compact('orders', 'todayDelivered', 'totalPending'));
    }

    public function profile()
    {
        return view('backend.features.delivery.profile', ['user' => Auth::guard('delivery')->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('delivery')->user();

        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->getMessageBag());
            return redirect()->back();
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

    public function staffSendOtp(Order $order)
    {
        abort_unless($order->delivery_channel === 'in_house', 403, 'This order is not on the in-house channel.');
        abort_unless($order->delivery_staff_id === Auth::guard('delivery')->id(), 403);

        return $this->issueOtp($order, 'in_house');
    }

    public function staffVerifyOtp(Request $request, Order $order)
    {
        abort_unless($order->delivery_channel === 'in_house', 403);
        abort_unless($order->delivery_staff_id === Auth::guard('delivery')->id(), 403);

        return $this->verifyOtp($request, $order, verifiedByStaffId: Auth::guard('delivery')->id());
    }

    public function triggerSteadfastOtp(Order $order)
    {
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

        Mail::to($order->customer_email)->send(new DeliveryOtpMail($order, $otp, $channel));

        return back()->with('success', 'OTP sent to the customer.');
    }

    private function verifyOtp(Request $request, Order $order, ?int $verifiedByStaffId, ?string $ip = null)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $deliveryOtp = DeliveryOtp::query()
            ->where('order_id', $order->id)
            ->where('channel', $order->delivery_channel)
            ->whereNull('verified_at')
            ->latest()
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

        $order->update(['delivered_at' => now(), 'status' => 'delivered']);

        return back()->with('success', "Order #{$order->id} delivery confirmed successfully!");
    }
}
