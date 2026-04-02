@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@push('styles')
<style>
body {
    background: #f5f6f8;
    font-family: 'Segoe UI', sans-serif;
}

.custom-navbar {
    background: rgba(255, 255, 255, 0.92);
    border-bottom: 1px solid #e8e8e8;
    backdrop-filter: blur(8px);
}

.navbar-brand {
    font-weight: 700;
    color: #1a1a1a !important;
}

.navbar-nav .nav-link {
    color: #4a4a4a !important;
}

.navbar-nav .nav-link:hover {
    color: #111111 !important;
}

.profile {
    background: #ffffff;
    border-radius: 12px;
    transition: transform 0.25s ease;
}

.profile:hover {
    transform: translateY(-4px);
}

.profile-img {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border: 3px solid #ddd;
}
</style>
@endpush

@section('nav_brand', 'TeacherPanel')

@section('nav_links')
    <li class="nav-item">
        <a class="nav-link" href="#">Dashboard</a>
    </li>
    <li class="nav-item ms-lg-2">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-dark btn-sm">Logout</button>
        </form>
    </li>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="profile card shadow-lg p-4">
                <h3 class="mb-3">Teacher Dashboard</h3>

                <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Gender:</strong> {{ auth()->user()->gender }}</p>
                <p><strong>Mobile:</strong> {{ auth()->user()->mobile }}</p>
                <p><strong>Father Name:</strong> {{ auth()->user()->father_name }}</p>
                <p><strong>Address:</strong> {{ auth()->user()->address }}</p>

                @if(auth()->user()->image)
                    <div class="text-center mt-3">
                        <img src="{{ asset('storage/' . auth()->user()->image) }}" class="profile-img" alt="Teacher profile image">
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
