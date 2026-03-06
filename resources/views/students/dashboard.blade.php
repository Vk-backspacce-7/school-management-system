<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

 

<div class="sidebar">

<h2>Student Panel</h2>

<form action="{{ route('logout') }}" method="POST">
@csrf
<button type="submit">Logout</button>
</form>

</div>


<!-- Main Content -->

<div class="main">

<div class="card">

<div class="profile">
@if($student->image)
    <img src="{{ asset('storage/'.$student->image) }}" width="120">
@endif

<h2>{{ $student->name }}</h2>
<p>{{ $student->email }}</p>
<p>{{ $student->father_name }}</p>
<p>{{ $student->mobile }}</p>
<p>{{ $student->gender }}</p>
<p>{{ $student->dob }}</p>
<p>{{ $student->address }}</p>
</div>
 

</div>

</div>

</body>
</html>