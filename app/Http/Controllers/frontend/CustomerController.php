<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Mail\TwoFactorCodeMail;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function register(){
        return view('frontend.auth.login');
    }

    public function store(Request $request){
        // Sanitize input
        $request->merge([
            'name' => strip_tags(trim($request->name)),
            'email' => trim($request->email),
            'phone' => trim($request->phone),
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|digits:11|unique:customers,phone',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer = Customer::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => bcrypt($request->password),
        ]);

        // Generate and send OTP
        $otp = $customer->generateOtp();
        Mail::to($customer->email)->send(new OtpVerificationMail($otp, $customer->name));

        // Store customer ID in session for OTP verification
        session(['otp_customer_id' => $customer->id]);

        toastr()->success('Registration successful! Please verify your email.');
        return redirect()->route('customer.verify.otp');
    }

    // Show OTP verification form
    public function showOtpForm()
    {
        if (!session('otp_customer_id')) {
            return redirect()->route('customer.login');
        }
        $customer = Customer::find(session('otp_customer_id'));
        return view('frontend.auth.verify-otp', ['email' => $customer ? $customer->email : '']);
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $customerId = session('otp_customer_id');
        if (!$customerId) {
            toastr()->error('Session expired. Please register again.');
            return redirect()->route('customer.login');
        }

        $customer = Customer::find($customerId);

        if (!$customer) {
            toastr()->error('Customer not found.');
            return redirect()->route('customer.login');
        }

        if ($customer->otp_code !== $request->otp) {
            toastr()->error('Invalid OTP code.');
            return redirect()->back();
        }

        if ($customer->otp_expires_at && now()->isAfter($customer->otp_expires_at)) {
            toastr()->error('OTP has expired. Please request a new one.');
            return redirect()->back();
        }

        // Verify email
        $customer->update([
            'email_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        session()->forget('otp_customer_id');

        // Auto login
        auth('customerg')->login($customer);

        toastr()->success('Email verified successfully! Welcome.');
        return redirect()->route('Home');
    }

    // Resend OTP
    public function resendOtp()
    {
        $customerId = session('otp_customer_id');
        if (!$customerId) {
            toastr()->error('Session expired. Please register again.');
            return redirect()->route('customer.login');
        }

        $customer = Customer::find($customerId);
        if (!$customer) {
            toastr()->error('Customer not found.');
            return redirect()->route('customer.login');
        }

        $otp = $customer->generateOtp();
        Mail::to($customer->email)->send(new OtpVerificationMail($otp, $customer->name));

        toastr()->success('New OTP sent to your email!');
        return redirect()->back();
    }

    // Show login form
    public function login(){
        return view('frontend.auth.login');
    }

    // Handle login submission
    public function loginSubmit(Request $request){
        // Sanitize input
        $request->merge([
            'login' => strip_tags(trim($request->login)),
        ]);

        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            toastr()->error('Invalid credentials');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        
        // Restriction: Phone login only with 2FA enabled
        if ($field === 'phone') {
            $customer = Customer::where('phone', $login)->first();
            if ($customer && !$customer->two_factor_enabled) {
                toastr()->error('Phone login is only allowed if 2FA is enabled.');
                return redirect()->back()->withInput();
            }
        }

        $credentials = [
            $field => $login,
            'password' => $request->password
        ];

        if(auth('customerg')->attempt($credentials)){
            $customer = auth('customerg')->user();

            // E2E Testing Bypass: Skip OTP for specific test account in local environment
            if (app()->environment('local') && in_array($customer->email, ['hasibulalamhimel44@gmail.com', 'himelhasib06@gmail.com'])) {
                toastr()->success('E2E Test Login Successful');
                return redirect()->route('Home');
            }

            // Check email verification
            if (!$customer->isEmailVerified()) {
                auth('customerg')->logout();
                $otp = $customer->generateOtp();
                Mail::to($customer->email)->send(new OtpVerificationMail($otp, $customer->name));
                session(['otp_customer_id' => $customer->id]);
                toastr()->warning('Please verify your email first.');
                return redirect()->route('customer.verify.otp');
            }

            // Check 2FA
            if ($customer->two_factor_enabled) {
                auth('customerg')->logout();
                $code = $customer->generateTwoFactorCode();
                Mail::to($customer->email)->send(new TwoFactorCodeMail($code, $customer->name));
                session(['2fa_customer_id' => $customer->id]);
                return redirect()->route('customer.2fa.verify');
            } else {
                // Mandatory OTP for email login if 2FA is off
                auth('customerg')->logout();
                $otp = $customer->generateOtp();
                Mail::to($customer->email)->send(new OtpVerificationMail($otp, $customer->name));
                session(['otp_customer_id' => $customer->id]);
                toastr()->warning('Login OTP sent to your email.');
                return redirect()->route('customer.verify.otp');
            }
        } else {
            toastr()->error('Invalid login credentials');
            return redirect()->back()->withInput();
        }
    }

    // Show 2FA verification form
    public function show2faForm()
    {
        if (!session('2fa_customer_id')) {
            return redirect()->route('customer.login');
        }
        $customer = Customer::find(session('2fa_customer_id'));
        return view('frontend.auth.two-factor', ['email' => $customer ? $customer->email : '']);
    }

    // Verify 2FA code
    public function verify2fa(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $customerId = session('2fa_customer_id');
        if (!$customerId) {
            toastr()->error('Session expired. Please login again.');
            return redirect()->route('customer.login');
        }

        $customer = Customer::find($customerId);

        if (!$customer || $customer->two_factor_code !== $request->code) {
            toastr()->error('Invalid verification code.');
            return redirect()->back();
        }

        if ($customer->two_factor_expires_at && now()->isAfter($customer->two_factor_expires_at)) {
            toastr()->error('Code has expired. Please login again.');
            return redirect()->route('customer.login');
        }

        // Clear 2FA code
        $customer->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        session()->forget('2fa_customer_id');
        auth('customerg')->login($customer);

        toastr()->success('Successfully logged in');
        return redirect()->route('Home');
    }

    public function logout(){
        auth('customerg')->logout();
        toastr()->success('Successfully logged out');
        return redirect()->route('Home');
    }

    public function profile()
    {
        $addresses = auth('customerg')->user()->addresses()->get();
        return view('frontend.pages.profile', compact('addresses'));
    }

    public function vouchers()
    {
        $vouchers = auth('customerg')->user()->coupons()
            ->withPivot('collected_at', 'is_used')
            ->orderBy('collected_at', 'desc')
            ->get();
        return view('frontend.pages.vouchers', compact('vouchers'));
    }

    public function profileupdate(Request $request)
    {
        $customer = auth('customerg')->user();

        $request->validate([
            'phone' => 'nullable|string|max:20',
            'default_address_id' => 'nullable|exists:customer_addresses,id',
            'password' => 'nullable|string|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [];
        if ($request->has('phone')) $data['phone'] = $request->phone;

        // Handle 2FA toggle
        if ($request->has('two_factor_enabled')) {
            $data['two_factor_enabled'] = (bool) $request->two_factor_enabled;
        }

        if ($request->filled('default_address_id')) {
            $customer->addresses()->update(['is_default' => false]);
            $addr = \App\Models\CustomerAddress::where('id', $request->default_address_id)
                        ->where('customer_id', $customer->id)->first();
            if ($addr) {
                $addr->update(['is_default' => true]);
                $data['address'] = $addr->address;
            }
        }

        if ($request->hasFile('image')) {
            if ($customer->image && file_exists(public_path($customer->image))) {
                unlink(public_path($customer->image));
            }
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('upload/customers'), $fileName);
            $data['image'] = 'upload/customers/' . $fileName;
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $customer->update($data);

        toastr()->success('Profile updated successfully!');
        return redirect()->back();
    }

    public function addresses()
    {
        $addresses = auth('customerg')->user()->addresses()->latest()->get();
        return view('frontend.pages.addresses', compact('addresses'));
    }

    public function addressStore(Request $request)
    {
        $customer = auth('customerg')->user();
        
        if ($customer->addresses()->count() >= 5) {
            toastr()->error('You can only have up to 5 addresses.');
            return redirect()->back();
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'zip_code' => 'nullable|string|max:20',
        ]);

        $isFirst = $customer->addresses()->count() == 0;

        CustomerAddress::create([
            'customer_id' => $customer->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'is_default' => $isFirst
        ]);

        toastr()->success('Address added successfully!');
        return redirect()->back();
    }

    public function addressEdit($id)
    {
        $address = CustomerAddress::where('id', $id)
            ->where('customer_id', auth('customerg')->id())
            ->firstOrFail();
            
        return view('frontend.pages.address-edit', compact('address'));
    }

    public function addressUpdate(Request $request, $id)
    {
        $address = CustomerAddress::where('id', $id)
            ->where('customer_id', auth('customerg')->id())
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'zip_code' => 'nullable|string|max:20',
        ]);

        $address->update($request->only(['name', 'email', 'phone', 'address', 'city', 'zip_code']));

        toastr()->success('Address updated successfully!');
        return redirect()->route('customer.addresses');
    }

    public function addressDelete($id)
    {
        $address = CustomerAddress::where('id', $id)
            ->where('customer_id', auth('customerg')->id())
            ->firstOrFail();

        if ($address->is_default) {
            $address->delete();
            // Set another address as default if exists
            $newDefault = auth('customerg')->user()->addresses()->first();
            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        } else {
            $address->delete();
        }

        toastr()->success('Address deleted successfully!');
        return redirect()->back();
    }

    public function addressSetDefault($id)
    {
        $customer = auth('customerg')->user();
        
        // Reset all defaults
        $customer->addresses()->update(['is_default' => false]);
        
        // Set new default
        $address = CustomerAddress::where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();
            
        $address->update(['is_default' => true]);

        toastr()->success('Default address updated!');
        return redirect()->back();
    }
}
