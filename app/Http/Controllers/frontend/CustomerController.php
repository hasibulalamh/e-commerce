<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function register(){
        return view('frontend.auth.login');
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
        return view('frontend.auth.login');
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
