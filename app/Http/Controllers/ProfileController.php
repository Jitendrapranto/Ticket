<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users,email,' . $user->id, 'regex:/^.+@.+\..+$/'],
            'phone' => 'nullable|string|max:20',
            'present_address' => 'nullable|string|max:500',
            'avatar' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:150',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->has('avatar') && !$request->hasFile('avatar') && $request->file('avatar') === null) {
             // This happens if the file exceeds PHP's upload_max_filesize
             return back()->withErrors(['avatar' => 'The uploaded file is too large for the server configuration.'])->withInput();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'present_address' => $request->present_address,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }
}
