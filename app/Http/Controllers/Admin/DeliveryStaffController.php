<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DeliveryStaffController extends Controller
{
    public function list()
    {
        $staff = DeliveryStaff::paginate(10);
        return view('backend.features.delivery_staff.list', compact('staff'));
    }

    public function create()
    {
        return view('backend.features.delivery_staff.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:delivery_staff,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->getMessageBag());
            return redirect()->back()->withInput();
        }

        DeliveryStaff::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        notify()->success('Delivery staff created successfully.');
        return redirect()->route('deliverystaff.list');
    }

    public function edit($id)
    {
        $staff = DeliveryStaff::findOrFail($id);
        return view('backend.features.delivery_staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = DeliveryStaff::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:delivery_staff,email,' . $staff->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->getMessageBag());
            return redirect()->back()->withInput();
        }

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);

        notify()->success('Delivery staff updated successfully.');
        return redirect()->route('deliverystaff.list');
    }

    public function delete($id)
    {
        $staff = DeliveryStaff::findOrFail($id);
        $staff->delete();

        notify()->success('Delivery staff deleted successfully.');
        return redirect()->back();
    }
}
