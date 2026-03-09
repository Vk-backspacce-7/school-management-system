<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;   // added
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PrincipalController extends Controller
{

public function dashboard()
{

    $teachers = User::role('Teacher')->get();

    // changed (students come from users table)
    $students = User::role('Student')->get();

    $classes  = Classes::all();

    return view('principal.dashboard', compact('teachers', 'students', 'classes'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($teacher->id)],
           
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'address' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $teacher->fill($request->only([
            'name', 'email',   'gender', 'father_name', 'mobile', 'address'
        ]));

        if ($request->hasFile('image')) {
            if ($teacher->image) {
                Storage::disk('public')->delete($teacher->image);
            }
            $teacher->image = $request->file('image')->store('profile_images', 'public');
        }

        if ($request->filled('password')) {
            $teacher->password = Hash::make($request->password);
        }

        $teacher->save();

        return redirect()->route('principal.dashboard')->with('success', 'Teacher updated successfully.');
    }

    public function deleteTeacher($id)
    {
        $teacher = User::role('Teacher')->findOrFail($id);

        if ($teacher->image) {
            Storage::disk('public')->delete($teacher->image);
        }

        $teacher->delete();

        return redirect()->route('principal.dashboard')->with('success', 'Teacher deleted successfully.');
    }

    // ==========================
    // STUDENT MANAGEMENT
    // ==========================

    public function createStudent()
    {
        return view('principal.register-students');
    }


    // FIXED
    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Student'
        ]);

        $user->assignRole('Student');

        return redirect()->route('principal.dashboard')->with('success', 'Student created successfully.');
    }


    // FIXED
    public function editStudent($id)
    {
        $user = User::findOrFail($id);
        $student = $user->student;

        return view('principal.edit-students', compact('user','student'));
    }


    // FIXED (insert + update logic)
    public function updateStudent(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email',Rule::unique('users','email')->ignore($user->id)],
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
                'class'=>$request->class,
                'age'=>$request->age
            ]);

        }else{

            Student::create([
                'user_id'=>$user->id,
                'class'=>$request->class,
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

        return redirect()->route('principal.dashboard')->with('success', 'Student deleted successfully.');
    }

}