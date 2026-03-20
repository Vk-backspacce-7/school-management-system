<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

<h2>Edit Student</h2>

@include('partials.flash-notifications')

<form action="{{ route('principal.student.update', $user->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<h3>User Information</h3>

<p>
<label>Name</label>
<input type="text" name="name" value="{{ old('name',$user->name) }}" class="@error('name') is-invalid @enderror" required>
@error('name')
<small class="field-error">{{ $message }}</small>
@enderror
</p>

<p>
<label>Father Name</label>
<input type="text" name="father_name" value="{{ old('father_name',$user->father_name) }}" class="@error('father_name') is-invalid @enderror" required>
@error('father_name')
<small class="field-error">{{ $message }}</small>
@enderror
</p>

<p>
<label>Mobile</label>
<input type="text" name="mobile" value="{{ old('mobile',$user->mobile) }}" pattern="[0-9]{10}" class="@error('mobile') is-invalid @enderror" required>
@error('mobile')
<small class="field-error">{{ $message }}</small>
@enderror
</p>

<p>
<label>Address</label>
<textarea name="address" class="@error('address') is-invalid @enderror" required>{{ old('address',$user->address) }}</textarea>
@error('address')
<small class="field-error">{{ $message }}</small>
@enderror
</p>

<p>
<label>Gender</label><br>

<input type="radio" name="gender" value="male"
{{ old('gender',$user->gender)=='male' ? 'checked' : '' }} required> Male

<input type="radio" name="gender" value="female"
{{ old('gender',$user->gender)=='female' ? 'checked' : '' }}> Female

<input type="radio" name="gender" value="other"
{{ old('gender',$user->gender)=='other' ? 'checked' : '' }}> Other

@error('gender')
<small class="field-error">{{ $message }}</small>
@enderror

</p>

<p>
<label>Email</label>
<input type="email" name="email" value="{{ old('email',$user->email) }}" class="@error('email') is-invalid @enderror" required>
@error('email')
<small class="field-error">{{ $message }}</small>
@enderror
</p>

<hr>

<h3>extra add Student Details</h3>

<label>Class</label>
<select name="class_id" class="@error('class_id') is-invalid @enderror" required>
<option value="">Select Class</option>
@foreach($classes as $cls)
<option value="{{ $cls->id }}"
{{ old('class_id', ($user->student->class_id ?? '')) == $cls->id ? 'selected' : '' }}>
Class {{ $cls->class }} - {{ $cls->section }}
</option>
@endforeach
</select>
@error('class_id')
<small class="field-error">{{ $message }}</small>
@enderror

<p>
<label>Age</label>
<input type="number" name="age" value="{{ old('age',$user->student->age ?? '') }}" min="1" max="120" class="@error('age') is-invalid @enderror" required>
@error('age')
<small class="field-error">{{ $message }}</small>
@enderror
</p>

<h3>Change Password (Optional)</h3>

<p>
<label>New Password</label>
<input type="password" name="password" class="@error('password') is-invalid @enderror">
@error('password')
<small class="field-error">{{ $message }}</small>
@enderror
</p>

<p>
<label>Confirm Password</label>
<input type="password" name="password_confirmation" class="@error('password_confirmation') is-invalid @enderror">
@error('password_confirmation')
<small class="field-error">{{ $message }}</small>
@enderror
</p>

<p>
<label>Current Image</label><br>
@if($user->image)
<img src="{{ asset('storage/'.$user->image) }}" width="60">
@endif
</p>

<p>
<label>Change Image</label>
<input type="file" name="image" accept=".jpg,.jpeg,.png" class="@error('image') is-invalid @enderror">
@error('image')
<small class="field-error">{{ $message }}</small>
@enderror
</p>

<button type="submit">Update Student</button>

<br><br>

<a href="{{ route('principal.dashboard') }}">Back</a>

</form>

</div>

</body>
</html>
