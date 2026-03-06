<!-- <!DOCTYPE html>
<html>
<head>

<title>Principal Dashboard</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<div class="container">

<div class="profile">

<h2>Principal Dashboard</h2>

<form action="{{ route('logout') }}" method="POST">
@csrf
<button class="logout-btn">Logout</button>
</form>
 
<p><strong>Name :</strong> {{ auth()->user()->name }}</p>
 
<p><strong>Email :</strong> {{ auth()->user()->email }}</p>
<p><strong>Gender :</strong> {{ auth()->user()->gender }}</p>
<p><strong>Mobile :</strong> {{ auth()->user()->mobile }}</p>
<p><strong>DOB :</strong> {{ auth()->user()->dob }}</p>
<p><strong>Father Name :</strong> {{ auth()->user()->father_name }}</p>
<p><strong>Address :</strong> {{ auth()->user()->address }}</p>
@if(auth()->user()->image)
<img src="{{ asset('storage/'.auth()->user()->image) }}" width="80">
@endif

</div>


                <h3>Teachers List</h3>

                         <table>
                              <tr>
                          <th>ID</th>
                        <th>Name</th>
                          <th>Email</th>
                        <th>Gender</th>
                      <th>DOB</th>
                          <th>Father Name</th>
                            <th>Mobile</th>
                        <th>Address</th>
                    <th>Image</th>
                <th>Action</th>
            </tr>
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
            <td>
            @if($teacher->image)
            <img src="{{ asset('storage/'.$teacher->image) }}" width="50">
            @endif
            </td>     

                    <td>

                    <button <a href="{{ route('principal.teacher.edit',$teacher->id) }}">Edit</a></button>

                    |

                    <form action="{{ route('principal.teacher.delete',$teacher->id) }}" method="POST" style="display:inline">

                    @csrf
                    @method('DELETE')

                    <button onclick="return confirm('Delete this teacher?')">Delete</button>

                    </form>

                    </td>

        </tr>

        @endforeach

        </table>

        </div>
 
</body>
</html> -->


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

 <!-- External CSS --> <link rel="stylesheet" href="{{ asset('css/principal-dashboard.css') }}">

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

<li class="nav-item"><a class="nav-link">Home</a></li>
<li class="nav-item"><a class="nav-link">About</a></li> 
<li class="nav-item"><a class="nav-link">Teacher</a></li>
<li class="nav-item"><a class="nav-link">Student</a></li>
<li class="nav-item"><a class="nav-link">Classes</a></li>
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
<div class="feature-card">
<i class="bi bi-mortarboard"></i>
<h5>Students</h5>
<p>Track student details and classes.</p>
</div>
</div>

<div class="col-md-3">
<div class="feature-card">
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
<section class="teachers-section" id="teachers">

<div class="container">

<div class="d-flex justify-content-between mb-3">

<h2>Teachers List</h2>

<button class="btn btn-secondary" onclick="backHome()">
Back
</button>

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

<td>
@if($teacher->image)
<img src="{{ asset('storage/'.$teacher->image) }}" width="50">
@endif
</td>

<td>

<a href="{{ route('principal.teacher.edit',$teacher->id) }}" class="btn btn-warning btn-sm">
Edit
</a>

<form action="{{ route('principal.teacher.delete',$teacher->id) }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

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
<button class="btn btn-danger" >Logout</button>
</form>

</div>

</div>
</div>
</div>

<!-- Bootstrap JS --> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- External JS --> <script src="{{ asset('js/principal-dashboard.js') }}"></script>
</body>
</html>