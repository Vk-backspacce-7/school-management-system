<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{

    // =========================
    // Register Form
    // =========================
    public function showRegister()
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    // =========================
    // Register User
    // =========================
   public function register(Request $request)
{

$request->validate([
'name' => 'required|string|max:255',
'email' => 'required|email|unique:users,email',
'password' => 'required|min:6|confirmed',
'role' => 'required',
'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
'dob' => 'required|date',
'gender' => 'required|in:male,female,other',
'father_name' => 'required|string|max:255',
'mobile' => 'nullable|string|regex:/^[0-9]{10}$/',
'address' => 'required|string|max:500',
]);

$imagePath = null;

if ($request->hasFile('image')) {

$imagePath = $request->file('image')
->store('profile_images','public');

}

$user = User::create([

'name' => $request->name,
'email' => $request->email,
'password' => Hash::make($request->password),
'role' => $request->role,
'dob' => $request->dob,
'gender' => $request->gender,
'father_name' => $request->father_name,
'mobile' => $request->mobile,
'address' => $request->address,
'image' => $imagePath

]);

$user->assignRole($request->role);

return redirect()->route('login')
->with('success','Registration successful. Please login.');

}
    // =========================
    // Login Form
    // =========================
    public function showLogin()
    {
        return view('auth.login');
    }

    // =========================
    // Login Process
    // =========================
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email','password'))) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role == 'Principal') {
                return redirect()->route('principal.dashboard');
            }

            if ($user->role == 'Teacher') {
                return redirect()->route('teacher.dashboard');
            }

            if ($user->role == 'Student') {
                return redirect()->route('student.dashboard');
            }

        }

        return back()->with('error', 'Invalid email or password');
    }

    // =========================
    // Logout
    // =========================
    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}