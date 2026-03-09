<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
    <link rel="stylesheet" href="{{ asset('css/edit-teachers.css') }}">
</head>
<body>

<div class="container">

   

    <!-- Error Messages -->
    @if($errors->any())
        <ul class="error-list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('principal.teacher.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="form-group">
            <label for="name">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name', $teacher->name) }}" required>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $teacher->email) }}" required>
        </div>

        <!-- Date of Birth -->
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input id="dob" type="date" name="dob" value="{{ old('dob', $teacher->dob) }}" required>
        </div>

        <!-- Gender -->
        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male" @selected(old('gender', $teacher->gender)==='male')>Male</option>
                <option value="female" @selected(old('gender', $teacher->gender)==='female')>Female</option>
                <option value="other" @selected(old('gender', $teacher->gender)==='other')>Other</option>
            </select>
        </div>

        <!-- Father's Name -->
        <div class="form-group">
            <label for="father_name">Father's Name</label>
            <input id="father_name" type="text" name="father_name" value="{{ old('father_name', $teacher->father_name) }}">
        </div>

        <!-- Mobile -->
        <div class="form-group">
            <label for="mobile">Mobile Number</label>
            <input id="mobile" type="text" name="mobile" value="{{ old('mobile', $teacher->mobile) }}">
        </div>

        <!-- Address -->
        <div class="form-group">
            <label for="address">Address</label>
            <textarea id="address" name="address">{{ old('address', $teacher->address) }}</textarea>
        </div>

        <!-- Current Image -->
        @if($teacher->image)
        <div class="form-group">
            <label>Current Image</label>
            <img src="{{ asset('storage/'.$teacher->image) }}" alt="Teacher Image" width="80">
        </div>
        @endif

        <!-- Upload New Image -->
        <div class="form-group">
            <label for="image">Upload New Image</label>
            <input id="image" type="file" name="image">
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">New Password (optional)</label>
            <input id="password" type="password" name="password" placeholder="New password">
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm password">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Teacher</button>
    </form>
<br><br>
    <a href="{{ route('principal.dashboard') }}">Back</a>
</div>
 
</body>
</html>