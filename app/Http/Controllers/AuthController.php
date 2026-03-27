<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\ActivityNotifier;
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
        $loggedInAt = now()->format('d M Y, h:i A');

        switch ($role) {
            case 'Principal':
                ActivityNotifier::send(
                    user: $user,
                    title: 'Login Activity',
                    message: "{$user->name} logged in on {$loggedInAt}.",
                    actionUrl: route('principal.dashboard', [], false),
                    meta: ['activity' => 'login', 'role' => 'Principal']
                );
                return redirect()->route('principal.dashboard')->with('success', 'Logged in to Principal Panel successfully.');
            case 'Teacher':
                ActivityNotifier::send(
                    user: $user,
                    title: 'Login Activity',
                    message: "{$user->name} logged in on {$loggedInAt}.",
                    actionUrl: route('teacher.dashboard', [], false),
                    meta: ['activity' => 'login', 'role' => 'Teacher']
                );
                return redirect()->route('teacher.dashboard')->with('success', 'Welcome Teacher!');
            case 'Student':
                ActivityNotifier::send(
                    user: $user,
                    title: 'Login Activity',
                    message: "{$user->name} logged in on {$loggedInAt}.",
                    actionUrl: route('student.dashboard', [], false),
                    meta: ['activity' => 'login', 'role' => 'Student']
                );
                return redirect()->route('student.dashboard')->with('success', 'Welcome Student!');
            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'No valid role assigned.');
        }
    }

    public function logout(Request $request) {
        $user = Auth::user();

        if ($user !== null) {
            $loggedOutAt = now()->format('d M Y, h:i A');

            ActivityNotifier::send(
                user: $user,
                title: 'Logout Activity',
                message: "{$user->name} logged out on {$loggedOutAt}.",
                actionUrl: route('login', [], false),
                meta: ['activity' => 'logout']
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
