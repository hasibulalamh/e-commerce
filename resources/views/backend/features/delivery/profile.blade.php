@extends('backend.master')

@section('content')
<div style="max-width:480px;margin:0 auto;padding:16px;">
    <h3>My Profile</h3>

    <form action="{{ route('delivery.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}"
            style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;margin-bottom:12px;" required>

        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
            style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;margin-bottom:12px;">

        <label>Email (cannot be changed)</label>
        <input type="text" value="{{ $user->email }}" disabled
            style="width:100%;padding:10px;border:1px solid #eee;border-radius:6px;margin-bottom:12px;background:#f5f5f5;">

        <hr style="margin:16px 0;">

        <label>New Password (leave blank to keep current password)</label>
        <input type="password" name="password"
            style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;margin-bottom:12px;">

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation"
            style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;margin-bottom:16px;">

        <button type="submit" style="background:#2563eb;color:#fff;border:none;padding:12px;border-radius:6px;width:100%;">
            Update Profile
        </button>
    </form>
</div>
@endsection
