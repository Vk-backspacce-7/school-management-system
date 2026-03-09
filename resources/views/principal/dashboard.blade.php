<!DOCTYPE html>
<html>
<head>

<title>Principal Dashboard</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<!-- External CSS --> 
<link rel="stylesheet" href="{{ asset('css/principal-dashboard.css') }}">

</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light custom-navbar">
<div class="container">
<a class="navbar-brand fw-bold"> PrincipalPanel</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="menu">
<ul class="navbar-nav ms-auto">
<li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="backHome()">Home</a></li>
<li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="openAbout()">About</a></li>
<li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="showTeachers()">Teacher</a></li>
<li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="showStudents()">Student</a></li>
<li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="showClasses()">Classes</a></li>
<li class="nav-item"><a class="nav-link">Subjects</a></li>

<li class="nav-item ms-3">
<button class="btn profile-btn" onclick="openProfile()">
<i class="bi bi-person-circle"></i> Profile
</button>
</li>
</ul>
</div>
</div>
</nav>

<!-- MAIN CONTENT -->
<div id="mainContent">

<!-- HERO -->
<section class="hero-section">
<div class="container text-center">
<h1>Welcome to School Management System</h1>
<p>Manage teachers, students, classes and subjects easily.</p>
</div>
</section>

<!-- FEATURES -->
<section class="features-section">
<div class="container">
<div class="row g-4">
<div class="col-md-3">
<div class="feature-card" onclick="showTeachers()">
<i class="bi bi-person-video3"></i>
<h5>Teachers</h5>
<p>Manage teacher profiles and records.</p>
</div>
</div>

<div class="col-md-3">
<div class="feature-card" onclick="showStudents()">
<i class="bi bi-mortarboard"></i>
<h5>Students</h5>
<p>Track student details and classes.</p>
</div>
</div>

<div class="col-md-3">
<div class="feature-card" onclick="showClasses()">
<i class="bi bi-building"></i>
<h5>Classes</h5>
<p>Organize classes and schedules.</p>
</div>
</div>

<div class="col-md-3">
<div class="feature-card">
<i class="bi bi-book"></i>
<h5>Subjects</h5>
<p>Manage subjects and curriculum.</p>
</div>
</div>

</div>
</div>
</section>

</div>

<!-- TEACHERS TABLE -->
<section class="teachers-section" id="teachers" style="display:none;">
<div class="container">
<div class="d-flex justify-content-between mb-3">
<h2>Teachers List</h2>
<button class="btn btn-secondary" onclick="backHome()">Back</button>
</div>

<div class="card shadow">
<div class="card-body">
<table class="table table-bordered table-hover">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Gender</th>
<th>DOB</th>
<th>Father</th>
<th>Mobile</th>
<th>Address</th>
<th>Image</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@foreach($teachers as $teacher)
<tr>
<td>{{ $teacher->id }}</td>
<td>{{ $teacher->name }}</td>
<td>{{ $teacher->email }}</td>
<td>{{ $teacher->gender }}</td>
<td>{{ $teacher->dob }}</td>
<td>{{ $teacher->father_name }}</td>
<td>{{ $teacher->mobile }}</td>
<td>{{ $teacher->address }}</td>
<td>@if($teacher->image)<img src="{{ asset('storage/'.$teacher->image) }}" width="50">@endif</td>
<td>
<a href="{{ route('principal.teacher.edit',$teacher->id) }}" class="btn btn-warning btn-sm">Edit</a>
<form action="{{ route('principal.teacher.delete',$teacher->id) }}" method="POST" style="display:inline">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm">Delete</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</section>

<!-- STUDENTS TABLE -->
<section class="students-section" id="students" style="display:none;">
<div class="container mt-5">
<div class="d-flex justify-content-between mb-3">
<h2>Students List</h2>
<a href="{{ route('principal.student.create') }}" class="btn btn-primary">Add Student</a>
</div>

<div class="card shadow">
<div class="card-body">
<table class="table table-bordered table-hover">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Mobile</th>
<th>Gender</th>
<th>Father</th>
<th>Address</th>
<th>Image</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@foreach($students as $student)
<tr>
<td>{{ $student->id }}</td>
<td>{{ $student->name }}</td>
<td>{{ $student->email }}</td>
<td>{{ $student->mobile }}</td>
<td>{{ $student->gender }}</td>
<td>{{ $student->father_name }}</td>
<td>{{ $student->address }}</td>
<td>@if($student->image)<img src="{{ asset('storage/'.$student->image) }}" width="50">@endif</td>
<td>
<a href="{{ route('principal.student.edit',$student->id) }}" class="btn btn-warning btn-sm">Edit</a>
<form action="{{ route('principal.student.delete',$student->id) }}" method="POST" style="display:inline;">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm" onclick="return confirm('Delete this student?')">Delete</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</section>

<!-- CLASSES TABLE -->
<section class="classes-section" id="classes" style="display:none;">
<div class="container">
<div class="d-flex justify-content-between mb-3">
<h2>Classes List</h2>
<button class="btn btn-secondary" onclick="backHome()">Back</button>
</div>

<!-- Add Class Form -->
<div class="card mb-3">
<div class="card-body">
<form action="{{ route('principal.classes.store') }}" method="POST">
@csrf
<div class="row g-2">
<div class="col-md-4">
<label>Class</label>
<select name="class" class="form-control">
<option value="">Select Class</option>
@for($i=1;$i<=12;$i++)
<option value="{{ $i }}">Class {{ $i }}</option>
@endfor
</select>
</div>
<div class="col-md-4">
<label>Section</label>
<select name="section" class="form-control">
@foreach(['A','B','C','D'] as $sec)
<option value="{{ $sec }}">{{ $sec }}</option>
@endforeach
</select>
</div>
<div class="col-md-4 d-flex align-items-end">
<button type="submit" class="btn btn-success">Add Class</button>
</div>
</div>
</form>
</div>
</div>

<!-- Classes Table -->
<div class="card shadow">
<div class="card-body">
<table class="table table-bordered table-hover">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Class</th>
<th>Section</th>
<th>Created At</th>
</tr>
</thead>
<tbody>
@foreach($classes as $cls)
<tr>
<td>{{ $cls->id }}</td>
<td>{{ $cls->class }}</td>
<td>{{ $cls->section }}</td>
<td>{{ $cls->created_at->format('d-m-Y') }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</section>

<!-- PROFILE MODAL -->
<div class="modal fade" id="profileModal">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Principal Profile</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body text-center">
@if(auth()->user()->image)
<img src="{{ asset('storage/'.auth()->user()->image) }}" class="profile-img">
@endif
<p><strong>Name:</strong> {{ auth()->user()->name }}</p>
<p><strong>Email:</strong> {{ auth()->user()->email }}</p>
<p><strong>Mobile:</strong> {{ auth()->user()->mobile }}</p>
</div>

<div class="modal-footer">
<form action="{{ route('logout') }}" method="POST">
@csrf
<button class="btn btn-danger">Logout</button>
</form>
</div>
</div>
</div>
</div>
</div> <!-- end of content -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/principal-dashboard.js') }}"></script>
</body>
</body>
</html>