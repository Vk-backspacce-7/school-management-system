<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{

 
// show admin dashboard====
public function index(){
        $principal = Auth::user();
        $teachers = User::where('role','student')->get();


        return view('teacher.dashboard', compact(' teachers','students'));   

    }
 
    //edit page=====
   
    public function edit($id){

    $user = User::findorfail($id);
    return view('teacher.edit-user', compact('user'));
    }

 
    //update student======
 

    public function update(Request $request, $id){
        $request->validate([
            'name'=> 'required|string|max:225',
            'email'=> 'required|email',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  
        ]);
       $user = User::findorfail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('image')){
            if($user->image){
                Storage::disk('public')->delete($user->image);
            }

            $user->image = $request->file('image')
            ->store('profile_images','public');
        }
     
    //password ===========
 

if ($request->old_password || $request->new_password || $request->confirm_password){

if(!Hash::check($request->old_password, $user->password)){
    return back()->with('error', 'Old password is incorrect.');
}

        if($request->new_password !== $request->confirm_password){
    return back()->with('error', 'New password and confirm password do not match.');

}

            $user->password = $request->new_password;


    }

        $user->save();
        return redirect()->route('teacher.dashboard')->with
        ('success', 'User updated successfully.');


    }

 
    //delete user========
 

    public function delete($id){
        $user = User::findorfail($id);

        if($user->image){
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('teacher.dashboard')
        ->with('success', 'User deleted successfully.');
    }

}

