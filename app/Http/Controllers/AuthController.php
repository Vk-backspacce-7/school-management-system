<?php

namespace App\Http\Controllers;

            use App\Models\User;
            use App\Models\Classes;
            use Illuminate\Http\Request;
            use Illuminate\Support\Facades\Auth;
            use Illuminate\Support\Facades\Hash;
            use Illuminate\Validation\Rule;
            use Spatie\Permission\Models\Role;
           

class AuthController extends Controller {
    
        public function showLogin()
        {
            return view('auth.login');
        }

        public function login(Request $request)
        {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ]);

            if (!Auth::attempt($request->only('email', 'password'))) {
                return back()->withInput()->with('error', 'Invalid email or password.');
            }

            
            $request->session()->regenerate();
        $user = Auth::user();




        switch ($user->getRoleNames()->first()) {
            case 'Principal':
                return redirect()->route('principal.dashboard');
            case 'Teacher':
                return redirect()->route('teacher.dashboard');
            case 'Student':
                return redirect()->route('student.dashboard');
            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'No valid role assigned.');
        }
                 
        

                Auth::logout();
                return redirect()->route('login')->with('error', 'No valid role assigned.');
            }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
