<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PrincipalController extends Controller
{
    public function index()
    {
        $teachers = User::role('Teacher')->latest()->get();
        return view('principal.dashboard', compact('teachers'));
    }

    public function edit($id)
    {
        $teacher = User::role('Teacher')->findOrFail($id);
        return view('principal.edit-teachers', compact('teacher'));
    }

    public function update(Request $request, $id)
    {
        $teacher = User::role('Teacher')->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($teacher->id)],
            'dob' => ['nullable', 'date'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'address' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $teacher->fill($request->only([
            'name', 'email', 'dob', 'gender', 'father_name', 'mobile', 'address'
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

    public function delete($id)
    {
        $teacher = User::role('Teacher')->findOrFail($id);

        if ($teacher->image) {
            Storage::disk('public')->delete($teacher->image);
        }

        $teacher->delete();

        return redirect()->route('principal.dashboard')->with('success', 'Teacher deleted successfully.');
    }

    //=========================
    // student system start ==========
    //============================



}
