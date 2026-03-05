<!DOCTYPE html>
<html>
<head>
<title>Edit Teacher</title>
 

</head>

<body>

<div class="container">

<h2>Edit Teacher</h2>

@if($errors->any())

<ul style="color:red">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

@endif

<form action="/teacher/update/{{ $teacher->id }}" method="POST" enctype="multipart/form-data">

@csrf

<p>
<label>Name</label>
<input type="text" name="name" value="{{ $teacher->name }}">
</p>

<p>
<label>Email</label>
<input type="email" name="email" value="{{ $teacher->email }}">
</p>

<p>
<label>Gender</label>

<select name="gender">

<option value="male" {{ $teacher->gender == 'male' ? 'selected' : '' }}>Male</option>

<option value="female" {{ $teacher->gender == 'female' ? 'selected' : '' }}>Female</option>

<option value="other" {{ $teacher->gender == 'other' ? 'selected' : '' }}>Other</option>

</select>

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

@if($teacher->image)

<img src="{{ asset('images/'.$teacher->image) }}" width="80">

@endif

</p>

<p>

<label>Change Image</label>

<input type="file" name="image">

</p>

<button type="submit">Update Teacher</button>

<br><br>

<a href="/principal/dashboard">Back</a>

</form>

</div>

</body>

</html>