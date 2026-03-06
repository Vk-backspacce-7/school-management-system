<!DOCTYPE html>
<html>
<head>
<title>Teacher Dashboard</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<div class="container">

<!-- Teacher Profile -->

<div class="profile">

<h2>Teacher Dashboard</h2>

<f 

<div class="container">

<div class="profile">

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


<!-- Register Student Button -->

<div class="top-bar">

<a href="{{ route('teacher.student.create') }}">
    <button>Register Student</button>
</a>

</div>


<!-- Students Table -->

<h3>Students List</h3>

@if(session('success'))
<p style="color:green">{{ session('success') }}</p>
@endif

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Mobile</th>
<th>Address</th>
<th>Gender</th>
<th>Father Name</th>
<th>Image</th>
<th>Action</th>
</tr>

@foreach($students as $student)

<tr>
<td>{{ $student->id }}</td>
<td>{{ $student->name }}</td>
 <td>{{$student->email}}</td>
<td>{{ $student->mobile }}</td>
<td>{{ $student->address }}</td>
<td>{{ $student->gender }}</td>
<td>{{ $student->father_name }}</td>
<td>
 @if($student->image)
    <img src="{{ asset('storage/'.$student->image) }}" width="50">
@endif
</td>
<td>
<button <a href="{{ route('teacher.student.edit', $student->id) }}">>Edit</a></button> |
<form action="{{ route('teacher.student.delete', $student->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Delete this student?')">Delete</button>
</form>
</tr>
@endforeach
</table>
</div>
</body>
</html>