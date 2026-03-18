<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('organizer.auth.login');
    }

    public function login(Request $request)
    {
        $request->merge(['email' => strtolower($request->email)]);
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();

            if ($user->role === 'organizer' && $user->organizer_status === 'approved') {
                $request->session()->regenerate();
                return redirect()->intended(route('organizer.dashboard'));
            }

            if ($user->role === 'pending_organizer' || ($user->role === 'organizer' && $user->organizer_status !== 'approved')) {
                return redirect()->route('organizer.pending');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'You do not have organizer privileges.']);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('organizer.auth.register');
    }

    public function showPendingPage()
    {
        if (Auth::check() && Auth::user()->role === 'organizer' && Auth::user()->organizer_status === 'approved') {
            return redirect()->route('organizer.dashboard');
        }
        return view('organizer.auth.pending');
    }

    public function register(Request $request)
    {
        $request->merge(['email' => strtolower($request->email)]);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'institution_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'present_address' => 'required|string|max:500',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'institution_name' => $request->institution_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'present_address' => $request->present_address,
            'password' => Hash::make($request->password),
            'role' => 'pending_organizer',
            'organizer_status' => 'pending',
        ]);

        Auth::login($user);

        return redirect()->route('organizer.pending');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('organizer.login');
    }
}
