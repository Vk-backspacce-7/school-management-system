<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('principal')->middleware('role:Principal')->group(function () {
        Route::get('/dashboard', [PrincipalController::class, 'index'])->name('principal.dashboard');
        Route::get('/teachers/{id}/edit', [PrincipalController::class, 'edit'])->name('principal.teacher.edit');
        Route::put('/teachers/{id}', [PrincipalController::class, 'update'])->name('principal.teacher.update');
        Route::delete('/teachers/{id}', [PrincipalController::class, 'delete'])->name('principal.teacher.delete');
    });



    Route::prefix('teacher')->middleware('role:Teacher')->group(function () {


        Route::get('/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');


       Route::get('/students/create', [TeacherController::class, 'create'])->name('teacher.student.create');

        Route::post('/students', [TeacherController::class, 'store'])->name('teacher.student.store');


        Route::get('/students/{id}/edit', [TeacherController::class, 'edit'])->name('teacher.student.edit');

Route::put('/students/{id}', [TeacherController::class, 'update'])->name('teacher.student.update');


        Route::delete('/students/{id}', [TeacherController::class, 'delete'])->name('teacher.student.delete');
    });

    Route::prefix('student')->middleware('role:Student')->group(function () {


        Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    });
});
