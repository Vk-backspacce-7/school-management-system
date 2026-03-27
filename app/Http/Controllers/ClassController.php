<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\student;
use App\Models\User;
use App\Models\Subject;
use App\Support\ActivityNotifier;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::orderBy('id','asc')->get();
        $teachers = User::role('Teacher')->get();
         $students = User::role('Student')->get();  
         $subjects = Subject::all();
        return view('principal.dashboard', compact('classes','teachers','students','subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class' => 'required|integer|min:1|max:12',
            'section' => 'required|string|max:1',
        ]);

        Classes::create([
            'class' => $request->class,
            'section' => $request->section,
        ]);

        ActivityNotifier::send(
            user: auth()->user(),
            title: 'Class Created',
            message: "Class {$request->class}-{$request->section} added on " . now()->format('d M Y, h:i A') . '.',
            actionUrl: route('principal.classes.index', [], false),
            meta: ['activity' => 'class_create', 'class' => $request->class, 'section' => $request->section]
        );

        return redirect()->route('principal.dashboard')->with('success', 'Class added successfully.');
    }

    public function edit($id)
    {
        $cls = Classes::findOrFail($id);
        return view('principal.edit-classes', compact('cls'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'class' => 'required|integer|min:1|max:12',
            'section' => 'required|string|max:1',
        ]);

        $cls = Classes::findOrFail($id);
        $cls->class = $request->class;
        $cls->section = $request->section;
        $cls->save();

        ActivityNotifier::send(
            user: auth()->user(),
            title: 'Class Updated',
            message: "Class {$cls->class}-{$cls->section} updated on " . now()->format('d M Y, h:i A') . '.',
            actionUrl: route('principal.classes.index', [], false),
            meta: ['activity' => 'class_update', 'class_id' => $cls->id]
        );

        return redirect()->route('principal.classes.index')->with('success','Class updated successfully');
    }

    public function delete($id)
    {
        $cls = Classes::findOrFail($id);
        $classLabel = $cls->class . '-' . $cls->section;
        $classId = $cls->id;
        $cls->delete();

        ActivityNotifier::send(
            user: auth()->user(),
            title: 'Class Deleted',
            message: "Class {$classLabel} deleted on " . now()->format('d M Y, h:i A') . '.',
            actionUrl: route('principal.classes.index', [], false),
            meta: ['activity' => 'class_delete', 'class_id' => $classId]
        );

        return redirect()->route('principal.classes.index')->with('success','Class deleted successfully');
    }
}
