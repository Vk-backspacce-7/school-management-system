<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
  
use App\Models\User;
use App\Models\Student;
use App\Models\Classes;
use App\Models\Subject;
use App\Support\ActivityNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
     use Spatie\Permission\Models\Role;
     use Flash;  

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
                'role' => ['required', Rule::in(['Teacher', 'Student'])],
                'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                'gender' => ['required', Rule::in(['male', 'female', 'other'])],
                'father_name' => ['required', 'string', 'max:255'],
                'mobile' => ['required', 'regex:/^[0-9]{10}$/'],
                'address' => ['required', 'string', 'max:1000'],
            ]);

            $imagePath = $request->hasFile('image') ? $request->file('image')->store('profile_images', 'public') : null;

              
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

             
                event(new UserRegistered($user));

                ActivityNotifier::send(
                    user: $request->user(),
                    title: 'User Registered',
                    message: "{$user->name} ({$user->role}) was registered on " . now()->format('d M Y, h:i A') . '.',
                    actionUrl: route('principal.dashboard', [], false),
                    meta: ['activity' => 'register_user', 'registered_user_id' => $user->id]
                );

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
    // ==========================/

          
public function editTeacher($id)
{
    $teacher = User::role('Teacher')->findOrFail($id);
    return view('principal.edit-teachers', compact('teacher'));
}
   public function updateTeacher(Request $request, $id)
{
    $teacher = User::role('Teacher')->findOrFail($id);

    $request->validate([
        'name' => ['nullable','string','max:255'],
        'email' => ['nullable','email', Rule::unique('users','email')->ignore($teacher->id)],
        'gender' => ['nullable', Rule::in(['male','female','other'])],
        'father_name' => ['nullable','string','max:255'],
        'mobile' => ['nullable','regex:/^[0-9]{10}$/'],
        'address' => ['nullable','string','max:1000'],
        'image' => ['nullable','image','mimes:jpeg,png,jpg','max:2048'],
        'password' => ['nullable','string','min:8','confirmed'],
    ]);

    // Only update fields that are provided (not empty)
    $fields = ['name','email','gender','father_name','mobile','address'];
    foreach ($fields as $field) {
        if ($request->filled($field)) {  // only update if the field is not empty
            $teacher->$field = $request->$field;
        }
    }

    // Handle image upload
    if ($request->hasFile('image')) {
        if ($teacher->image) {
            Storage::disk('public')->delete($teacher->image);
        }
        $teacher->image = $request->file('image')->store('profile_images','public');
    }

    // Handle password change
    if ($request->filled('password')) {
        $teacher->password = Hash::make($request->password);
    }

    $teacher->save();

    ActivityNotifier::send(
        user: auth()->user(),
        title: 'Teacher Updated',
        message: "Teacher profile updated for {$teacher->name} on " . now()->format('d M Y, h:i A') . '.',
        actionUrl: route('principal.dashboard', [], false),
        meta: ['activity' => 'update_teacher', 'teacher_id' => $teacher->id]
    );

    return redirect()->route('principal.dashboard')->with('success','Teacher updated successfully.');
}

    public function deleteTeacher($id)
    {
        $teacher = User::role('Teacher')->findOrFail($id);
        $teacherName = $teacher->name;
        $teacherId = $teacher->id;

        if ($teacher->image) {
            Storage::disk('public')->delete($teacher->image);
        }

        $teacher->delete();

        ActivityNotifier::send(
            user: auth()->user(),
            title: 'Teacher Deleted',
            message: "Teacher {$teacherName} was deleted on " . now()->format('d M Y, h:i A') . '.',
            actionUrl: route('principal.dashboard', [], false),
            meta: ['activity' => 'delete_teacher', 'teacher_id' => $teacherId]
        );

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

        ActivityNotifier::send(
            user: auth()->user(),
            title: 'Student Created',
            message: "Student {$user->name} was created on " . now()->format('d M Y, h:i A') . '.',
            actionUrl: route('principal.dashboard', [], false),
            meta: ['activity' => 'create_student', 'student_user_id' => $user->id]
        );

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
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'father_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'regex:/^[0-9]{10}$/'],
            'address' => ['required', 'string', 'max:1000'],
            'class_id' => ['required', 'exists:classes,id'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'father_name' => $request->father_name,
            'mobile' => $request->mobile,
            'address' => $request->address,
        ]);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            $user->image = $request->file('image')->store('profile_images', 'public');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

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

        ActivityNotifier::send(
            user: auth()->user(),
            title: 'Student Updated',
            message: "Student {$user->name} was updated on " . now()->format('d M Y, h:i A') . '.',
            actionUrl: route('principal.dashboard', [], false),
            meta: ['activity' => 'update_student', 'student_user_id' => $user->id]
        );

        return redirect()->route('principal.dashboard')->with('success','Student updated successfully.');
    }


    public function deleteStudent($id)
    {
        $user = User::findOrFail($id);
        $studentName = $user->name;
        $studentId = $user->id;

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        ActivityNotifier::send(
            user: auth()->user(),
            title: 'Student Deleted',
            message: "Student {$studentName} was deleted on " . now()->format('d M Y, h:i A') . '.',
            actionUrl: route('principal.dashboard', [], false),
            meta: ['activity' => 'delete_student', 'student_user_id' => $studentId]
        );

        return redirect()->route('principal.dashboard')->with('success','Student deleted successfully.');
    }

}
