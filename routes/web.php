<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use Illuminate\Support\Facades\Route;

// Root redirect to login
Route::get('/', fn () => redirect()->route('login'));

// Guest routes (login & registration)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Principal routes
    Route::prefix('principal')->middleware('role:Principal')->group(function () {

        // Dashboard
        Route::get('/dashboard', [PrincipalController::class, 'dashboard'])->name('principal.dashboard');

        // Teacher management
        Route::get('/teachers/{id}/edit', [PrincipalController::class, 'editTeacher'])->name('principal.teacher.edit');
        Route::put('/teachers/{id}', [PrincipalController::class, 'updateTeacher'])->name('principal.teacher.update');
        Route::delete('/teachers/{id}', [PrincipalController::class, 'deleteTeacher'])->name('principal.teacher.delete');

        // Student management
        Route::get('/students/create', [PrincipalController::class, 'createStudent'])->name('principal.student.create');
        Route::post('/students', [PrincipalController::class, 'storeStudent'])->name('principal.student.store');
        Route::get('/students/{id}/edit', [PrincipalController::class, 'editStudent'])->name('principal.student.edit');
        Route::put('/students/{id}', [PrincipalController::class, 'updateStudent'])->name('principal.student.update');
        Route::delete('/students/{id}', [PrincipalController::class, 'deleteStudent'])->name('principal.student.delete');

        // Classes management
        Route::get('/classes', [ClassController::class, 'index'])->name('principal.classes.index');
        Route::post('/classes/store', [ClassController::class, 'store'])->name('principal.classes.store');
    });

    // Teacher routes
    Route::prefix('teacher')->middleware('role:Teacher')->group(function () {
        Route::get('/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');

        Route::get('/students/create', [TeacherController::class, 'create'])->name('teacher.student.create');
        Route::post('/students', [TeacherController::class, 'store'])->name('teacher.student.store');
        Route::get('/students/{id}/edit', [TeacherController::class, 'edit'])->name('teacher.student.edit');
        Route::put('/students/{id}', [TeacherController::class, 'update'])->name('teacher.student.update');
        Route::delete('/students/{id}', [TeacherController::class, 'delete'])->name('teacher.student.delete');
    });

    // Student dashboard
    Route::prefix('student')->middleware('role:Student')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    });
});