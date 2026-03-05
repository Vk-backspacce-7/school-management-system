<!DOCTYPE html>
<html>
<head>
<title>Edit Student</title>
 

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

<form action="/student/update/{{ $student->id }}" method="POST" enctype="multipart/form-data">

@csrf

<p>
<label>Name</label>
<input type="text" name="name" value="{{ $student->name }}">
</p>

<p>
<label>Father Name</label>
<input type="text" name="father_name" value="{{ $student->father_name }}">
</p>

<p>
<label>Class</label>
<input type="text" name="class" value="{{ $student->class }}">
</p>

<p>
<label>Mobile</label>
<input type="text" name="mobile" value="{{ $student->mobile }}">
</p>

<p>
<label>Address</label>
<textarea name="address">{{ $student->address }}</textarea>
</p>

<p>
<label>Gender</label><br>

<input type="radio" name="gender" value="male"
{{ $student->gender == 'male' ? 'checked' : '' }}> Male

<input type="radio" name="gender" value="female"
{{ $student->gender == 'female' ? 'checked' : '' }}> Female

</p>

<p>
<label>Age</label>
<input type="number" name="age" value="{{ $student->age }}">
</p>

<p>
<label>Email</label>
<input type="email" name="email" value="{{ $student->email }}">
</p>

<hr>

    <h3>Change Password (Optional)</h3>

    <p>
        <label>Old Password</label><br>
        <input type="password" name="old_password">
    </p>

    <p>
        <label>New Password</label><br>
        <input type="password" name="new_password">
    </p>

    <p>
        <label>Confirm Password</label><br>
        <input type="password" name="confirm_password">
    </p>

<p>
<label>Current Image</label><br>

@if($student->image)
<img src="{{ asset('images/'.$student->image) }}" width="80">
@endif

</p>

<p>
<label>Change Image</label>
<input type="file" name="image">
</p>

<button type="submit">Update Student</button>

<br><br>

<a href="/teacher/dashboard">Back</a>

</form>

</div>

</body>
</html>