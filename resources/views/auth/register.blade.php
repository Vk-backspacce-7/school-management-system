<!DOCTYPE html>
<html>
<head>
<title>Register</title>
 
<style>
body{
font-family: Arial;
background:#f4f4f4;
}

.container{
width:80%;
margin:auto;
background:white;
padding:20px;
margin-top:20px;
}

h2{
background:#2c3e50;
color:white;
padding:10px;
}

input,select,textarea{
width:100%;
padding:8px;
margin-top:5px;
margin-bottom:15px;
}

button{
background:green;
color:white;
padding:10px 20px;
border:none;
cursor:pointer;
}
</style>
</head>

<body>

<div class="container">

<h2>Register Form</h2>

@if(session('success'))
<p style="color:green">{{ session('success') }}</p>
@endif

@if($errors->any())
<ul style="color:red">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form action="/register" method="POST" enctype="multipart/form-data">
@csrf

 

<label>  Name</label>
<input type="text" name="name" value="{{ old('name') }}">

 

<label>Date of Birth</label>
<input type="date" name="dob" value="{{ old('dob') }}">

<label>Gender</label>

<input type="radio" name="gender" value="male" {{ old('gender')=='male'?'checked':'' }}> Male
<input type="radio" name="gender" value="female" {{ old('gender')=='female'?'checked':'' }}> Female
<input type="radio" name="gender" value="other" {{ old('gender')=='other'?'checked':'' }}> Other

<br><br>

<label>Father Name</label>
<input type="text" name="father_name" value="{{ old('father_name') }}">


<label>Email</label>
<input type="email" name="email" value="{{ old('email') }}" required>

<label>Mobile Number</label>
<input type="tel" name="mobile" value="{{ old('mobile') }}">
 

<label> Address</label>
<textarea name=" address">{{ old('permanent_address') }}</textarea>
 
<label>Upload Photo</label>
<input type="file" name="image">

<label>Password</label>
<input type="password" name="password" required>

<label>Confirm Password</label>
<input type="password" name="password_confirmation" required>

<label>Select Role</label>
<select name="role" required>

<option value="">-- Select Role --</option>

@foreach($roles as $role)

<option value="{{ $role->name }}"
{{ old('role')==$role->name?'selected':'' }}>
{{ $role->name }}
</option>

@endforeach

</select>

<br><br>

<button type="submit">Register</button>

</form>

</div>

</body>
</html>