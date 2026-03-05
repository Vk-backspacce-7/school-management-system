<!DOCTYPE html>
<html>
<head>
<title>Register Student</title>
 
</head>

<body>

<div class="container">

<h2>Register Student</h2>

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

<form action="/student/store" method="POST" enctype="multipart/form-data">

@csrf

<p>
<label>Name</label>
<input type="text" name="name" value="{{ old('name') }}">
</p>

<p>
<label>Father Name</label>
<input type="text" name="father_name" value="{{ old('father_name') }}">
</p>

<p>
<label>Class</label>
<input type="text" name="class" value="{{ old('class') }}">
</p>

<p>
<label>Mobile</label>
<input type="text" name="mobile" value="{{ old('mobile') }}">
</p>

<p>
<label>Address</label>
<textarea name="address">{{ old('address') }}</textarea>
</p>

<p>
<label>Gender</label><br>

<input type="radio" name="gender" value="male"
{{ old('gender') == 'male' ? 'checked' : '' }}> Male

<input type="radio" name="gender" value="female"
{{ old('gender') == 'female' ? 'checked' : '' }}> Female

</p>

<p>
<label>Age</label>
<input type="number" name="age" value="{{ old('age') }}">
</p>

<p>
<label>Email</label>
<input type="email" name="email" value="{{ old('email') }}">
</p>

<p>
<label>Password:</label><br>
<input type="password" name="password" required>
</p>

<p>
<label>Confirm Password:</label><br>
<input type="password" name="password_confirmation" required>
</p>

<p>
<label>Student Image</label>
<input type="file" name="image">
</p>

<button type="submit">Register Student</button>

<br><br>

<a href="/teacher/dashboard">Back</a>

</form>

</div>

</body>
</html>