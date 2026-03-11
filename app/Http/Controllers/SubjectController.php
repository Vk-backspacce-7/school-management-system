<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Classes;
use App\Models\User;
use App\Models\Student;

class SubjectController extends Controller
{
    // Show all subjects and classes
    public function index()
    {
        $subjects = Subject::with('classes')->get();
        $classes = Classes::all();
        $teachers = User::role('Teacher')->get();
        $students = User::role('Student')->with('student.class')->get();

        return view('principal.dashboard', compact('subjects', 'classes', 'teachers','students'));
    }

    // Store a new subject
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name',
        ]);

        Subject::create([
            'name' => $request->name
        ]);

        return redirect()->route('principal.dashboard.index')->with('success', 'Subject added successfully.');
    }

    // Edit subject
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('principal.edit-subjects', compact('subject'));
    }

    // Update subject
    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,'.$subject->id,
        ]);

        $subject->update(['name' => $request->name]);

        return redirect()->route('principal.dashboard.index')->with('success','Subject updated successfully.');
    }

    // Delete subject
    public function delete($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->classes()->detach(); // detach from classes
        $subject->delete();

        return redirect()->route('principal.dashboard.index')->with('success','Subject deleted successfully.');
    }

    // Assign subjects to a class
    public function assign(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        $class = Classes::findOrFail($request->class_id);
        $class->subjects()->sync($request->subjects);

        return redirect()->route('principal.dashboard.index')->with('success', 'Subjects assigned successfully.');
    }
 
   public function editAssignSubjects($id)
{
    $class = Classes::with('subjects')->findOrFail($id);
    $subjects = Subject::all();
    $allClasses = Classes::all(); // <-- fetch all classes for dropdown

    return view('principal.edit-assign-subjects', compact('class', 'subjects', 'allClasses'));
}
 
    public function updateAssignSubjects(Request $request, $id)
    {
        $request->validate([
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        $class = Classes::findOrFail($id);
        $class->subjects()->sync($request->subjects);

        return redirect()->route('principal.dashboard.index')->with('success', 'Subjects updated successfully.');
    }

    
    
}