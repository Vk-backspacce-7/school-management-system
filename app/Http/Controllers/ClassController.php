<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\classes;

class ClassController extends Controller
{
   
    // Show form to create new student
    public function create()
    {
        return view('principal.create-classes');
    }

    public function store(Request $request)
    {
         Classes::create([
            'class'=>$request->class,
            'section'=>$request->section
        ]);

        return redirect()->back();
    }
}