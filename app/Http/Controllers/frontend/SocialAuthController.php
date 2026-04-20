<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\OtpVerificationMail;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Mail;

class SocialAuthController extends Controller
{
    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
            ->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->stateless()
                ->user();
            return $this->handleSocialLogin($socialUser, 'google');
        } catch (\Exception $e) {
            \Log::error('Google Login Error: ' . $e->getMessage());
            toastr()->error('Google login failed: ' . $e->getMessage());
            return redirect()->route('customer.login');
        }
    }

    // Redirect to Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')
            ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
            ->redirect();
    }

    // Handle Facebook callback
    public function handleFacebookCallback()
    {
        try {
            $socialUser = Socialite::driver('facebook')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->stateless()
                ->user();
            return $this->handleSocialLogin($socialUser, 'facebook');
        } catch (\Exception $e) {
            \Log::error('Facebook Login Error: ' . $e->getMessage());
            toastr()->error('Facebook login failed: ' . $e->getMessage());
            return redirect()->route('customer.login');
        }
    }

    // Common handler for social login
    private function handleSocialLogin($socialUser, string $provider)
    {
        $providerId = $provider . '_id';

        // Check if customer already exists with this social ID
        $customer = Customer::where($providerId, $socialUser->getId())->first();

        if ($customer) {
            return $this->completeSocialLogin($customer, 'Welcome back!');
        }

        // Check if email already exists
        $customer = Customer::where('email', $socialUser->getEmail())->first();

        if ($customer) {
            // Link social account to existing customer
            $customer->update([
                $providerId => $socialUser->getId(),
                'provider' => $provider,
            ]);

            return $this->completeSocialLogin($customer, 'Account linked!');
        }

        // Create new customer
        $customer = Customer::create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'phone' => null,
            $providerId => $socialUser->getId(),
            'provider' => $provider,
            'email_verified_at' => null, // Trigger OTP verification
            'password' => null,
        ]);

        return $this->completeSocialLogin($customer, 'Registration successful!');
    }

    // Securely complete the social login/registration
    private function completeSocialLogin($customer, string $successMessage)
    {
        // Check 2FA
        if ($customer->two_factor_enabled) {
            $code = $customer->generateTwoFactorCode();
            Mail::to($customer->email)->send(new TwoFactorCodeMail($code, $customer->name));
            session(['2fa_customer_id' => $customer->id]);
            toastr()->info($successMessage . ' Please complete 2FA.');
            return redirect()->route('customer.2fa.verify');
        } else {
            // Mandatory OTP for social login if 2FA is off
            $otp = $customer->generateOtp();
            Mail::to($customer->email)->send(new OtpVerificationMail($otp, $customer->name));
            session(['otp_customer_id' => $customer->id]);
            toastr()->warning($successMessage . ' Login OTP sent to your email.');
            return redirect()->route('customer.verify.otp');
        }
    }
}
