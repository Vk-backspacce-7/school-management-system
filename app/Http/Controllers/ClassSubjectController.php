<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;

class ClassSubjectController extends Controller
{

public function index()
{
    $classes = Classes::with('subjects')->get();
    return view('principal.class-subjects.index', compact('classes'));
}

public function edit($id)
{
    $class = Classes::with('subjects')->findOrFail($id);
    $classes = Classes::all();
    $subjects = Subject::all();

    return view('principal.class-subjects.edit', compact('class','classes','subjects'));
}

public function update(Request $request, $id)
{
    $class = Classes::findOrFail($id);

    $class->subjects()->sync($request->subjects);

    return redirect()->route('principal.class-subjects.index')
        ->with('success','Subjects updated');
}

}