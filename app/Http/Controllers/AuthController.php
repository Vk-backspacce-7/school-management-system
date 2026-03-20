<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;

class AuthController extends Controller {

    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Invalid email or password!')->withInput();
        }

        $request->session()->regenerate();
        $user = Auth::user();

        $role = $user->getRoleNames()->first();

        switch ($role) {
            case 'Principal':
                return redirect()->route('principal.dashboard')->with('success', 'Logged in to Principal Panel successfully.');
            case 'Teacher':
                return redirect()->route('teacher.dashboard')->with('success', 'Welcome Teacher!');
            case 'Student':
                return redirect()->route('student.dashboard')->with('success', 'Welcome Student!');
            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'No valid role assigned.');
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
