<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<div class="container">

<h2>Register Form</h2>

@include('partials.flash-notifications')

<div class="form">
    <form action="{{ route('principal.register.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Name" class="@error('name') is-invalid @enderror" required>
        @error('name')
            <small class="field-error">{{ $message }}</small>
        @enderror

        <label for="gender">Gender</label>
        <label><input type="radio" name="gender" value="male" @checked(old('gender')==='male') required> Male</label>
        <label><input type="radio" name="gender" value="female" @checked(old('gender')==='female')> Female</label>
        <label><input type="radio" name="gender" value="other" @checked(old('gender')==='other')> Other</label>
        @error('gender')
            <small class="field-error">{{ $message }}</small>
        @enderror

        <label for="father_name">Father Name</label>
        <input type="text" id="father_name" name="father_name" value="{{ old('father_name') }}" placeholder="Father Name" class="@error('father_name') is-invalid @enderror" required>
        @error('father_name')
            <small class="field-error">{{ $message }}</small>
        @enderror

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" required>
        @error('email')
            <small class="field-error">{{ $message }}</small>
        @enderror

        <label for="mobile">Mobile</label>
        <input type="tel" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="10-digit mobile" pattern="[0-9]{10}" class="@error('mobile') is-invalid @enderror" required>
        @error('mobile')
            <small class="field-error">{{ $message }}</small>
        @enderror

        <label for="address">Address</label>
        <textarea id="address" name="address" class="@error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
        @error('address')
            <small class="field-error">{{ $message }}</small>
        @enderror

        <label for="image">Image</label>
        <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png" class="@error('image') is-invalid @enderror" required>
        @error('image')
            <small class="field-error">{{ $message }}</small>
        @enderror

        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="@error('password') is-invalid @enderror" required>
        @error('password')
            <small class="field-error">{{ $message }}</small>
        @enderror

        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="@error('password_confirmation') is-invalid @enderror" required>
        @error('password_confirmation')
            <small class="field-error">{{ $message }}</small>
        @enderror

        <label for="role">Role</label>
        <select id="role" name="role" class="@error('role') is-invalid @enderror" required>
            <option value="">-- Select Role --</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}" @selected(old('role') === $role->name)>{{ $role->name }}</option>
            @endforeach
        </select>
        @error('role')
            <small class="field-error">{{ $message }}</small>
        @enderror

        <button type="submit">Register</button>
    </form>
</div>

</div>
<a class="nav-link" href="{{ route('principal.dashboard') }}">Back</a>

</body>
</html>
