<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    // Show Teacher Dashboard with all students
    public function index()
    {
        // Simple all students fetch (role column optional)
        $students = Student::latest()->get();
        return view('teachers.dashboard', compact('students'));
    }

    // Show form to create new student
    public function create()
    {
        return view('teachers.register-students');
    }

    // Store new student from form
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:students,email'], // check students table
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'dob' => ['nullable', 'date'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'address' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('profile_images', 'public')
            : null;

        // Create student record
        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Student', // optional, just for info
            'dob' => $request->dob,
            'gender' => $request->gender,
            'father_name' => $request->father_name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'image' => $imagePath,
        ]);

        return redirect()->route('teacher.dashboard')->with('success', 'Student created successfully.');
    }

    // Show edit form for student
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('teachers.edit-students', compact('student'));
    }

    // Update student from form
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('students', 'email')->ignore($student->id)],
            'dob' => ['nullable', 'date'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'address' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Update basic fields
        $student->fill($request->only([
            'name', 'email', 'dob', 'gender', 'father_name', 'mobile', 'address'
        ]));

        // Update image if uploaded
        if ($request->hasFile('image')) {
            if ($student->image) {
                Storage::disk('public')->delete($student->image);
            }
            $student->image = $request->file('image')->store('profile_images', 'public');
        }

        // Update password if filled
        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        $student->save();

        return redirect()->route('teacher.dashboard')->with('success', 'Student updated successfully.');
    }

    // Delete student
    public function delete($id)
    {
        $student = Student::findOrFail($id);

        // Delete image file if exists
        if ($student->image) {
            Storage::disk('public')->delete($student->image);
        }

        $student->delete();

        return redirect()->route('teacher.dashboard')->with('success', 'Student deleted successfully.');
    }
}