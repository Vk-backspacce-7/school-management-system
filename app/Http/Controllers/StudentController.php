<?php

namespace App\Http\Controllers;
use App\Models\User;
 
use App\Models\Classes;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
  public function index()
    {
        $student = auth()->user(); 
        return view('students.dashboard', compact('student'));
    }
}
