<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

<h2>Edit Student</h2>

@if($errors->any())
<ul style="color:red">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
@endif

@if(session('success'))
<p style="color:green">{{ session('success') }}</p>
@endif


<form action="{{ route('principal.student.update', $user->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')


<h3>User Information</h3>

<p>
<label>Name</label>
<input type="text" name="name" value="{{ old('name',$user->name) }}">
</p>

<p>
<label>Father Name</label>
<input type="text" name="father_name" value="{{ old('father_name',$user->father_name) }}">
</p>

<p>
<label>Mobile</label>
<input type="text" name="mobile" value="{{ old('mobile',$user->mobile) }}">
</p>

<p>
<label>Address</label>
<textarea name="address">{{ old('address',$user->address) }}</textarea></p>

<p>
<label>Gender</label><br>

<input type="radio" name="gender" value="male"
{{ old('gender',$user->gender)=='male' ? 'checked' : '' }}> Male

<input type="radio" name="gender" value="female"
{{ old('gender',$user->gender)=='female' ? 'checked' : '' }}> Female

</p>

<p>
<label>Email</label>
<input type="email" name="email" value="{{ old('email',$user->email) }}">
</p>

<hr>


<h3>extra add Student Details</h3>

 
<label>Class</label>

<select name="class_id">

<option value="">Select Class</option>

@foreach($classes as $cls)

<option value="{{ $cls->id }}"
{{ ($user->student->class_id ?? '') == $cls->id ? 'selected' : '' }}>

Class {{ $cls->class }} - {{ $cls->section }}

</option>

@endforeach

</select>
<p>
<label>Age</label>
<input type="number" name="age" value="{{ old('age',$user->student->age ?? '') }}">
</p>

 

 


<h3>Change Password (Optional)</h3>

<p>
<label>New Password</label>
<input type="password" name="password">
</p>

<p>
<label>Confirm Password</label>
<input type="password" name="password_confirmation">
</p>


<p>
<label>Current Image</label><br>

@if($user->image)
<img src="{{ asset('storage/'.$user->image) }}" width="60">
@endif

</p>

<p>
<label>Change Image</label>
<input type="file" name="image">
</p>


<button type="submit">Update Student</button>

<br><br>

<a href="{{ route('principal.dashboard') }}">Back</a>

</form>

</div>

</body>
</html>