<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
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
<img src="{{ asset('uploads/students/'.$student->image) }}">
@else
<img src="https://via.placeholder.com/120">
@endif

<h2>{{ $student->name }}</h2>

</div>

<table>

<tr>
<td class="label">Father Name</td>
<td>{{ $student->father_name }}</td>
</tr>

<tr>
<td class="label">Class</td>
<td>{{ $student->class }}</td>
</tr>

<tr>
<td class="label">Mobile</td>
<td>{{ $student->mobile }}</td>
</tr>

<tr>
<td class="label">Email</td>
<td>{{ $student->email }}</td>
</tr>

<tr>
<td class="label">Gender</td>
<td>{{ $student->gender }}</td>
</tr>

<tr>
<td class="label">Age</td>
<td>{{ $student->age }}</td>
</tr>

<tr>
<td class="label">Address</td>
<td>{{ $student->address }}</td>
</tr>

</table>

</div>

</div>

</body>
</html>