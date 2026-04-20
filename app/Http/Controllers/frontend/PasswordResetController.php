<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    // Show forgot password form
    public function showForgotForm()
    {
        return view('frontend.auth.forgot-password');
    }

    // Send reset link email
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers,email',
        ], [
            'email.exists' => 'No account found with this email address.',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        // Delete old tokens
        DB::table('customer_password_resets')->where('email', $request->email)->delete();

        // Generate token
        $token = Str::random(64);

        DB::table('customer_password_resets')->insert([
            'email' => $request->email,
            'token' => bcrypt($token),
            'created_at' => now(),
        ]);

        $resetUrl = url('/customer/password/reset/' . $token . '?email=' . urlencode($request->email));

        Mail::to($request->email)->send(new PasswordResetMail($resetUrl, $customer->name));

        toastr()->success('Password reset link sent to your email!');
        return redirect()->back();
    }

    // Show reset password form
    public function showResetForm(Request $request, $token)
    {
        return view('frontend.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    // Handle password reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers,email',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required',
        ]);

        $record = DB::table('customer_password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            toastr()->error('Invalid or expired reset link.');
            return redirect()->back();
        }

        // Check if token is expired (60 minutes)
        if (now()->diffInMinutes($record->created_at) > 60) {
            DB::table('customer_password_resets')->where('email', $request->email)->delete();
            toastr()->error('Reset link has expired. Please request a new one.');
            return redirect()->route('customer.password.forgot');
        }

        // Verify token
        if (!password_verify($request->token, $record->token)) {
            toastr()->error('Invalid reset token.');
            return redirect()->back();
        }

        // Update password
        Customer::where('email', $request->email)->update([
            'password' => bcrypt($request->password),
        ]);

        // Delete used token
        DB::table('customer_password_resets')->where('email', $request->email)->delete();

        toastr()->success('Password reset successfully! Please login.');
        return redirect()->route('customer.login');
    }
}
