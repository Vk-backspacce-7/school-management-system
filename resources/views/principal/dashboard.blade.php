<!DOCTYPE html>
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
</html>