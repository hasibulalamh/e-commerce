<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function register(){
        return view('frontend.auth.register');
    }

    public function store(Request $request){
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

        Customer::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => bcrypt($request->password),
        ]);

        toastr()->success('Registration successful! Welcome.');
        return redirect()->route('Home');
    }

    // Show login form
    public function login(){
        return view('frontend.auth.register');
    }

    // Handle login submission
    public function loginSubmit(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            toastr()->error('Invalid credentials');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if(auth('customerg')->attempt($credentials)){
            toastr()->success('Successfully logged in');
            return redirect()->route('Home');
        } else {
            toastr()->error('Invalid email or password');
            return redirect()->back()->withInput();
        }
    }

    public function logout(){
        auth('customerg')->logout();
        toastr()->success('Successfully logged out');
        return redirect()->route('Home');
    }

    public function profile()
    {
        return view('frontend.pages.profile');
    }

    public function profileupdate(Request $request)
    {
        $customer = auth('customerg')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $customer->update($data);

        toastr()->success('Profile updated successfully!');
        return redirect()->back();
    }
}
