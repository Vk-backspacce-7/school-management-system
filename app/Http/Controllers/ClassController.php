<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::latest()->get(); // fetch all classes
        return view('principal.dashboard', compact('classes')); // send to dashboard
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

        return redirect()->route('principal.dashboard')->with('success', 'Class added successfully.');
    }


    public function edit($id) {
    $cls = Classes::findOrFail($id);
    return view('principal.edit-classes', compact('cls'));
}

public function update(Request $request, $id) {
    $cls = Classes::findOrFail($id);
    $cls->class = $request->class;
    $cls->section = $request->section;
    $cls->save();

    return redirect()->route('principal.classes.index')->with('success','Class updated successfully');
}

public function delete($id) {
    $cls = Classes::findOrFail($id);
    $cls->delete();
    return redirect()->route('principal.classes.index')->with('success','Class deleted successfully');
}
}