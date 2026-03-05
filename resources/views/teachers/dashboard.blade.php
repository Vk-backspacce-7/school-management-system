<!DOCTYPE html>
<html>
<head>
<title>Teacher Dashboard</title>
</head>

<body>

<div class="container">

<!-- Teacher Profile -->

<div class="profile">

<h2>Teacher Dashboard</h2>

<form action="{{ route('logout') }}" method="POST">
@csrf
<button type="submit">Logout</button>
</form>
 
<p><strong>Name :</strong> {{ auth()->user()->name }}</p>

<p><strong>Email :</strong> {{ auth()->user()->email }}</p>

<p><strong>Gender :</strong> {{ auth()->user()->gender }}</p>

@if(auth()->user()->image)

<img src="{{ asset('images/'.auth()->user()->image) }}" width="80">

@endif

</div>


<!-- Register Student Button -->

<div class="top-bar">

<a href="/student/register">
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
<th>Father Name</th>
<th>Class</th>
<th>Mobile</th>
<th>Gender</th>
<th>Age</th>
<th>Image</th>
<th>Action</th>
</tr>

@foreach($students as $student)

<tr>

<td>{{ $student->id }}</td>

<td>{{ $student->name }}</td>

<td>{{ $student->father_name }}</td>

<td>{{ $student->class }}</td>

<td>{{ $student->mobile }}</td>

<td>{{ $student->gender }}</td>

<td>{{ $student->age }}</td>

<td>

@if($student->image)

<img src="{{ asset('images/'.$student->image) }}" width="50">

@endif

</td>

<td>

<a href="/student/edit/{{ $student->id }}">Edit</a>

|

<a href="/student/delete/{{ $student->id }}"
onclick="return confirm('Delete this student?')">

Delete

</a>

</td>

</tr>

@endforeach

</table>

</div>

</body>
</html>