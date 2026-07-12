<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Show the user's profile.

    public function edit(): View
    {
        $user = Auth::user();
        return view('backend.profile.edit', compact('user'));
    }

    //Update the user's profile information.

    public function update(Request $request): RedirectResponse
    {
        // Get the authenticated user with proper type hinting
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'min:8', 'different:current_password'],
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::delete('public/avatars/' . basename($user->avatar));
            }

            $avatar = $request->file('avatar');
            $filename = 'avatar-' . Str::uuid() . '.' . $avatar->getClientOriginalExtension();
            $path = $avatar->storeAs('public/avatars', $filename);
            $user->avatar = Storage::url($path);
        }

        // Update user data
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update password if provided
        if (!empty($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }

        // Save the user model
        $user->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully!');
    }
}
