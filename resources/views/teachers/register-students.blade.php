<!DOCTYPE html>
<html>
<head>
    <title>Register Student</title>
 <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">
    <h2>Register Student</h2>

    <!-- Success Message -->
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <!-- Validation Errors -->
    @if($errors->any())
        <ul class="error">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <!-- Registration Form -->
    <form action="{{ route('teacher.student.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Student Name" required>

        <label>Father Name</label>
        <input type="text" name="father_name" value="{{ old('father_name') }}" placeholder="Father Name">
 

        <label>Gender</label>
        <label><input type="radio" name="gender" value="male" @checked(old('gender')==='male')> Male</label>
        <label><input type="radio" name="gender" value="female" @checked(old('gender')==='female')> Female</label>
        <label><input type="radio" name="gender" value="other" @checked(old('gender')==='other')> Other</label>

        <label>Mobile</label>
        <input type="text" name="mobile" value="{{ old('mobile') }}" placeholder="10-digit mobile">

        <label>Address</label>
        <textarea name="address" placeholder="Address">{{ old('address') }}</textarea>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required>

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

        <label>Student Image</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">Register Student</button>
    </form>

    <br>
    <a href="{{ route('teacher.dashboard') }}">Back to Dashboard</a>
</div>

</body>
</html>