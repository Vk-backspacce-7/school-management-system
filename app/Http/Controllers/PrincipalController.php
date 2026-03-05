<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class PrincipalController extends Controller
{

    public function index()
    {
        $principal = Auth::user();

        $teachers = User::where('role','Teacher')->get();

        return view('principal.dashboard', compact('principal','teachers'));
    }


    public function edit($id)
    {
        $teacher = User::findOrFail($id);

        return view('principal.edit-teacher', compact('teacher'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'name'=> 'required|string|max:255',
            'email'=> 'required|email|unique:users,email,'.$id,
            'dob'=> 'nullable|date',
            'gender'=> 'nullable',
            'father_name'=> 'nullable|string|max:255',
            'mobile'=>  'nullable|string|regex:/^[0-9]{10}$/',
            'address'=> 'nullable|string',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->father_name = $request->father_name;
        $user->mobile = $request->mobile;
        $user->address = $request->address;


        if ($request->hasFile('image')) {

            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            $user->image = $request->file('image')
                ->store('profile_images','public');
        }


        if ($request->filled('old_password')) {

            if (!Hash::check($request->old_password, $user->password)) {
                return back()->with('error','Old password is incorrect.');
            }

            if ($request->new_password !== $request->confirm_password) {
                return back()->with('error','New password and confirm password do not match.');
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('principal.dashboard')
            ->with('success','Teacher updated successfully.');
    }


    public function delete($id)
    {

        $user = User::findOrFail($id);

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('principal.dashboard')
            ->with('success','Teacher deleted successfully.');
    }

}