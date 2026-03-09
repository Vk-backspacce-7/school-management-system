<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

 

<div class="sidebar">

 

<h2>Student Dashboard</h2>

<img src="{{ asset('storage/'.$student->image) }}" width="120">

<p>Name : {{ $student->name }}</p>
<p>Email : {{ $student->email }}</p>
<p>Father : {{ $student->father_name }}</p>
<p>Mobile : {{ $student->mobile }}</p>
<p>Gender : {{ $student->gender }}</p>
<p>DOB : {{ $student->dob }}</p>
<p>Address : {{ $student->address }}</p>

<form action="{{ route('logout') }}" method="POST">
@csrf
<button type="submit">Logout</button>
</form>

</body>
</html>