<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return redirect()->route('login');
});


/* Authentication */

Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class,'showRegister'])->name('register');
    Route::post('/register', [AuthController::class,'register']);

    Route::get('/login', [AuthController::class,'showLogin'])->name('login');
    Route::post('/login', [AuthController::class,'login']);

});


/* Protected Routes */

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class,'logout'])->name('logout');


    /* Principal */

    Route::middleware('role:Principal')->prefix('principal')->group(function () {

        Route::get('/dashboard',[PrincipalController::class,'index'])
        ->name('principal.dashboard');

        Route::get('/teachers/{id}/edit',[PrincipalController::class,'edit'])
        ->name('principal.teacher.edit');

        Route::post('/teachers/{id}/update',[PrincipalController::class,'update'])
        ->name('principal.teacher.update');

        Route::delete('/teachers/{id}',[PrincipalController::class,'delete'])
        ->name('principal.teacher.delete');

    });


    /* Teacher */

    Route::middleware('role:Teacher')->prefix('teacher')->group(function () {

        Route::get('/dashboard',[TeacherController::class,'index'])
        ->name('teacher.dashboard');

        Route::get('/students/{id}/edit',[TeacherController::class,'edit'])
        ->name('teacher.student.edit');

        Route::post('/students/{id}/update',[TeacherController::class,'update'])
        ->name('teacher.student.update');

        Route::delete('/students/{id}',[TeacherController::class,'delete'])
        ->name('teacher.student.delete');

    });


    /* Student */

    Route::middleware('role:Student')->prefix('student')->group(function () {

        Route::get('/dashboard',[StudentController::class,'index'])
        ->name('student.dashboard');

    });

});