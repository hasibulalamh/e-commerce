<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeliveryAuthController extends Controller
{
    public function login()
    {
        return view('backend.auth.delivery-login');
    }

    public function loginSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->getMessageBag());
            return redirect()->back();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::guard('delivery')->attempt($credentials)) {
            notify()->success('Successfully login');
            return redirect()->route('delivery.dashboard');
        }

        notify()->error('Invalid credentials');
        return redirect()->back();
    }

    public function logout()
    {
        Auth::guard('delivery')->logout();
        notify()->success('Successfully logged out');
        return redirect('/delivery/login');
    }
}
