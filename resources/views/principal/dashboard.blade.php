<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal Dashboard | School Management</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- OLD CSS INCLUDE (commented for safe migration):
    <link rel="stylesheet" href="{{ asset('css/principal-dashboard.css') }}">
    --}}
    <link rel="stylesheet" href="{{ asset('css/principal-dashboard.min.css') }}">
</head>
<body class="app-fixed-body">
@include('partials.flash-notifications')

<div class="app-shell">
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid px-3 px-lg-4">
            <a class="navbar-brand" href="#" data-section="mainContent">PrincipalPanel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
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
                </ul>
            </div>
        </div>
    </nav>

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

    @include('partials.notification-bell')
</div>

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

<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
{{-- OLD JS INCLUDE (commented for safe migration):
<script src="{{ asset('js/principal-dashboard.js') }}"></script>
--}}
<script defer src="{{ asset('js/principal-dashboard.min.js') }}"></script>
</body>
</html>