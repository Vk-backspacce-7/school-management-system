<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
     use Spatie\Permission\Models\Role;
     use App\Jobs\SendWelcomeEmailJob;
     use Flash; // laracasts/flash

class PrincipalController extends Controller
{

        public function showRegister()
            {
                $roles = Role::whereIn('name', [ 'Teacher', 'Student'])->get();
                return view('principal.register', compact('roles'));
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

                return redirect()->route('principal.dashboard')->with('success', 'Registration successful.');
            }

public function dashboard()
{
    $teachers = User::role('Teacher')->get();

    $students = User::role('Student')->with('student.class')->get();

    $classes = Classes::orderBy('id','asc')->get();

     $subjects = Subject::orderBy('id','asc')->get();

    return view('principal.dashboard', compact('teachers', 'students', 'classes','subjects'));
}


    // ==========================
    // TEACHER MANAGEMENT
    // ==========================

    public function editTeacher($id)
    {
        $teacher = User::role('Teacher')->findOrFail($id);
        return view('principal.edit-teachers', compact('teacher'));
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = User::role('Teacher')->findOrFail($id);

        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email',Rule::unique('users','email')->ignore($teacher->id)],
            'gender' => ['nullable',Rule::in(['male','female','other'])],
            'father_name' => ['nullable','string','max:255'],
            'mobile' => ['nullable','regex:/^[0-9]{10}$/'],
            'address' => ['nullable','string','max:1000'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg','max:2048'],
            'password' => ['nullable','string','min:8','confirmed'],
        ]);

        $teacher->fill($request->only([
            'name','email','gender','father_name','mobile','address'
        ]));

        if ($request->hasFile('image')) {

            if ($teacher->image) {
                Storage::disk('public')->delete($teacher->image);
            }

            $teacher->image = $request->file('image')->store('profile_images','public');
        }

        if ($request->filled('password')) {
            $teacher->password = Hash::make($request->password);
        }

        $teacher->save();

        return redirect()->route('principal.dashboard')->with('success','Teacher updated successfully.');
    }


    public function deleteTeacher($id)
    {
        $teacher = User::role('Teacher')->findOrFail($id);

        if ($teacher->image) {
            Storage::disk('public')->delete($teacher->image);
        }

        $teacher->delete();

        return redirect()->route('principal.dashboard')->with('success','Teacher deleted successfully.');
    }


    // ==========================
    // STUDENT MANAGEMENT
    // ==========================

    public function createStudent()
    {
        $classes = Classes::all();

        return view('principal.register-students',compact('classes'));
    }


    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','string','min:8','confirmed'],
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'Student'
        ]);

        $user->assignRole('Student');

        // create student record
        Student::create([
            'user_id'=>$user->id,
            'class_id'=>$request->class_id,
            'age'=>$request->age
        ]);

        return redirect()->route('principal.dashboard')->with('success','Student created successfully.');
    }



    public function editStudent($id)
    {
        $user = User::with('student')->findOrFail($id);

        $classes = Classes::all();

        return view('principal.edit-students',compact('user','classes'));
    }



    public function updateStudent(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'=>['required','string','max:255'],
            'email'=>['required','email',Rule::unique('users','email')->ignore($user->id)],
        ]);

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'gender'=>$request->gender,
            'father_name'=>$request->father_name,
            'mobile'=>$request->mobile,
            'address'=>$request->address
        ]);

        $student = Student::where('user_id',$user->id)->first();

        if($student){

            $student->update([
                'class_id'=>$request->class_id,
                'age'=>$request->age
            ]);

        }else{

            Student::create([
                'user_id'=>$user->id,
                'class_id'=>$request->class_id,
                'age'=>$request->age
            ]);

        }

        return redirect()->route('principal.dashboard')->with('success','Student updated successfully.');
    }


    public function deleteStudent($id)
    {
        $user = User::findOrFail($id);

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('principal.dashboard')->with('success','Student deleted successfully.');
    }

}