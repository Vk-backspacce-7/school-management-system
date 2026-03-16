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
   
        public function showRegister()
            {
                $roles = Role::whereIn('name', ['Principal', 'Teacher', 'Student'])->get();
                return view('auth.register', compact('roles'));
            }



    public function register(Request $request)
    {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required', Rule::in(['Principal', 'Teacher', 'Student'])],
                'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            
                'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
                'father_name' => ['nullable', 'string', 'max:255'],
                'mobile' => ['nullable', 'regex:/^[0-9]{10}$/'],
                'address' => ['nullable', 'string', 'max:1000'],
            ]);

            $imagePath = $request->hasFile('image')
                ? $request->file('image')->store('profile_images', 'public') : null;

              
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                
                    'gender' => $request->gender,
                    'father_name' => $request->father_name,
                    'mobile' => $request->mobile,
                    'address' => $request->address,
                    'image' => $imagePath,
                ]);

                $user->assignRole($request->role);

                /* Queue Email */
                SendWelcomeEmailJob::dispatch($user);

                return redirect()->route('login')->with('success', 'Registration successful. Please login.');
            }

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
