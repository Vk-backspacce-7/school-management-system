<!DOCTYPE html>
<html>
<head>
<title>Edit Teacher</title>
 
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
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

<form action="{{ route('principal.teacher.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ old('name', $teacher->name) }}">
    <input type="email" name="email" value="{{ old('email', $teacher->email) }}">
    <input type="date" name="dob" value="{{ old('dob', $teacher->dob) }}">

    <select name="gender">
        <option value="">Select gender</option>
        <option value="male" @selected(old('gender', $teacher->gender)==='male')>Male</option>
        <option value="female" @selected(old('gender', $teacher->gender)==='female')>Female</option>
        <option value="other" @selected(old('gender', $teacher->gender)==='other')>Other</option>
    </select>

    <input type="text" name="father_name" value="{{ old('father_name', $teacher->father_name) }}">
    <input type="text" name="mobile" value="{{ old('mobile', $teacher->mobile) }}">
    <textarea name="address">{{ old('address', $teacher->address) }}</textarea>

    @if($teacher->image)
        <img src="{{ asset('storage/'.$teacher->image) }}" width="80">
    @endif
    <input type="file" name="image">

    <input type="password" name="password" placeholder="New password (optional)">
    <input type="password" name="password_confirmation" placeholder="Confirm new password">

    <button type="submit">Update Teacher</button>
</form>


</div>

</body>

</html>