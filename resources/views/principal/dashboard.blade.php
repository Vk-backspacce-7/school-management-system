@extends('layouts.app')

@section('title', 'Principal Dashboard | School Management')
@section('body_class', 'app-fixed-body')
@section('shell_class', 'app-shell')
@section('nav_brand', 'PrincipalPanel')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/principal-dashboard.min.css') }}">
@endpush

@section('nav_links')
    <li class="nav-item"><a class="nav-link" href="#" data-section="mainContent">Home</a></li>
    <li class="nav-item"><a class="nav-link" href="#" data-section="teachers">Teachers</a></li>
    <li class="nav-item"><a class="nav-link" href="#" data-section="students">Students</a></li>
    <li class="nav-item"><a class="nav-link" href="#" data-section="classes">Classes</a></li>
    <li class="nav-item"><a class="nav-link" href="#" data-section="subjects">Subjects</a></li>
    <li class="nav-item ms-lg-2">
        <button type="button" class="btn profile-btn" onclick="openProfile()">
            <i class="bi bi-person-circle me-1"></i> Profile
        </button>
    </li>
@endsection

@section('content')
    <main id="dashboardViewport" class="dashboard-viewport" tabindex="-1">
        <section id="mainContent" class="dashboard-section">
            <div class="hero-wrap">
                <div class="container-fluid px-3 px-lg-4">
                    <h1 class="hero-title">Executive Control Portal</h1>
                    <p class="hero-subtitle">
                        Your unified gateway for school administration and academic governance.
                    </p>
                </div>
            </div>

            <div class="container-fluid px-3 px-lg-4 pb-4">
                <div class="row g-3 g-lg-4">
                    <div class="col-6 col-lg-3">
                        <button type="button" class="feature-card w-100" data-section="teachers" aria-label="Open teachers section">
                            <i class="bi bi-person-video3 feature-icon"></i>
                            <span class="feature-title">Teachers</span>
                            <span class="feature-text">Organize staff records and assignments.</span>
                        </button>
                    </div>
                    <div class="col-6 col-lg-3">
                        <button type="button" class="feature-card w-100" data-section="students" aria-label="Open students section">
                            <i class="bi bi-mortarboard feature-icon"></i>
                            <span class="feature-title">Students</span>
                            <span class="feature-text">Track student enrollments and details.</span>
                        </button>
                    </div>
                    <div class="col-6 col-lg-3">
                        <button type="button" class="feature-card w-100" data-section="classes" aria-label="Open classes section">
                            <i class="bi bi-building feature-icon"></i>
                            <span class="feature-title">Classes</span>
                            <span class="feature-text">Organize sections and levels.</span>
                        </button>
                    </div>
                    <div class="col-6 col-lg-3">
                        <button type="button" class="feature-card w-100" data-section="subjects" aria-label="Open subjects section">
                            <i class="bi bi-book feature-icon"></i>
                            <span class="feature-title">Subjects</span>
                            <span class="feature-text">Manage courses and subject mapping.</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        @include('principal.teachers-view')
        @include('principal.students-view')
        @include('principal.classes-view')
        @include('principal.subjects-view')
    </main>
@endsection

@push('modals')
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content profile-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">My Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-center py-4">
                    @if(auth()->user()->image)
                        <img
                            src="{{ asset('storage/' . auth()->user()->image) }}"
                            class="rounded-circle border mb-3"
                            width="120"
                            height="120"
                            loading="lazy"
                            decoding="async"
                            style="object-fit: cover;"
                            alt="{{ auth()->user()->name }} profile image"
                        >
                    @else
                        <i class="bi bi-person-circle profile-avatar-icon"></i>
                    @endif

                    <h4 class="fw-semibold mb-0">{{ auth()->user()->name }}</h4>
                    <p class="small text-muted mb-3">Principal</p>
                    <hr>
                    <div class="text-start px-2 px-md-4">
                        <p class="mb-1 small"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p class="mb-1 small"><strong>Mobile:</strong> {{ auth()->user()->mobile }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('logout') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-dark w-100 rounded-pill">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script defer src="{{ asset('js/principal-dashboard.min.js') }}"></script>
@endpush
