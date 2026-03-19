<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
   
    <title>Principal Dashboard | School Management</title>

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

     

    <link rel="stylesheet" href="{{ asset('css/principal-dashboard.css') }}">
</head>
<body>

    <!-- Notification Container -->
<div class="notification-container">
    @if(session('success'))
        <div class="notification success">
            <span class="icon">✔</span>
            <span class="message">{{ session('success') }}</span>
            <button class="close-btn">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="notification error">
            <span class="icon">⚠</span>
            <span class="message">{{ session('error') }}</span>
            <button class="close-btn">&times;</button>
        </div>
    @endif

    @if(session('info'))
        <div class="notification info">
            <span class="icon">ℹ</span>
            <span class="message">{{ session('info') }}</span>
            <button class="close-btn">&times;</button>
        </div>
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="notification error">
                <span class="icon">⚠</span>
                <span class="message">{{ $error }}</span>
                <button class="close-btn">&times;</button>
            </div>
        @endforeach
    @endif
</div>
 

<nav class="navbar navbar-expand-lg navbar-light custom-navbar shadow-sm sticky-top bg-white">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">PrincipalPanel</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="#" data-section="mainContent">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-section="teachers">Teachers</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-section="students">Students</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-section="classes">Classes</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-section="subjects">Subjects</a></li>
                <li class="nav-item ms-lg-3">
                    <button class="btn btn-primary rounded-pill px-4 profile-btn" onclick="openProfile()">
                        <i class="bi bi-person-circle me-1"></i> Profile
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="mainContent">

    <section class="hero-section py-5 text-center border-bottom" style="background: transparent;">
        <div class="container">
            <h1 class="display-4 fw-bold">Executive Control Portal</h1>
            <p class="fs-5 text-secondary">
                Your unified gateway for comprehensive school administration and academic governance.
            </p>
        </div>
    </section>

    <section class="features-section py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="feature-card shadow-sm p-4 text-center border-0 rounded-4" data-section="teachers">
                        <i class="bi bi-person-video3 fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold">Teachers</h5>
                        <p class="small text-muted mb-0">Organize staff records and assignments.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card shadow-sm p-4 text-center border-0 rounded-4" data-section="students">
                        <i class="bi bi-mortarboard fs-1 text-success mb-3"></i>
                        <h5 class="fw-bold">Students</h5>
                        <p class="small text-muted mb-0">Track student enrollments and details.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card shadow-sm p-4 text-center border-0 rounded-4" data-section="classes">
                        <i class="bi bi-building fs-1 text-info mb-3"></i>
                        <h5 class="fw-bold">Classes</h5>
                        <p class="small text-muted mb-0">Organize sections and academic levels.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card shadow-sm p-4 text-center border-0 rounded-4" data-section="subjects">
                        <i class="bi bi-book fs-1 text-warning mb-3"></i>
                        <h5 class="fw-bold">Subjects</h5>
                        <p class="small text-muted mb-0">Manage academic programs and course structures.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@include('principal.teachers-view')
@include('principal.students-view')
@include('principal.classes-view')
@include('principal.subjects-view')

<div class="modal fade" id="profileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-person-badge me-2"></i>My Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                @if(auth()->user()->image)
                    <img src="{{ asset('storage/'.auth()->user()->image) }}" 
                         class="rounded-circle border shadow-sm mb-3" 
                         width="120" height="120" style="object-fit: cover;">
                @else
                    <i class="bi bi-person-circle display-1 text-secondary mb-3"></i>
                @endif
                <h4 class="fw-bold mb-0">{{ auth()->user()->name }}</h4>
                <p class="text-muted small mb-3">Principal</p>
                <hr>
                <div class="text-start px-4">
                    <p class="mb-1 small"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p class="mb-1 small"><strong>Mobile:</strong> {{ auth()->user()->mobile }}</p>
                </div>
            </div>
            <div class="modal-footer bg-light border-0">
                <form action="{{ route('logout') }}" method="POST" class="w-100">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 py-2 rounded-pill">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/principal-dashboard.js') }}"></script>

<script>
    function openProfile() {
        var myModal = new bootstrap.Modal(document.getElementById('profileModal'));
        myModal.show();
    }
    
 
   </script>
 
  

</body>
</html>