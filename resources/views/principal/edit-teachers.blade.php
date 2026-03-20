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

    @include('partials.flash-notifications')

    <form action="{{ route('principal.teacher.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name', $teacher->name) }}" class="@error('name') is-invalid @enderror" required>
            @error('name')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $teacher->email) }}" class="@error('email') is-invalid @enderror" required>
            @error('email')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" class="@error('gender') is-invalid @enderror" required>
                <option value="">Select Gender</option>
                <option value="male" @selected(old('gender', $teacher->gender)==='male')>Male</option>
                <option value="female" @selected(old('gender', $teacher->gender)==='female')>Female</option>
                <option value="other" @selected(old('gender', $teacher->gender)==='other')>Other</option>
            </select>
            @error('gender')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="father_name">Father's Name</label>
            <input id="father_name" type="text" name="father_name" value="{{ old('father_name', $teacher->father_name) }}" class="@error('father_name') is-invalid @enderror" required>
            @error('father_name')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="mobile">Mobile Number</label>
            <input id="mobile" type="text" name="mobile" value="{{ old('mobile', $teacher->mobile) }}" pattern="[0-9]{10}" class="@error('mobile') is-invalid @enderror" required>
            @error('mobile')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea id="address" name="address" class="@error('address') is-invalid @enderror" required>{{ old('address', $teacher->address) }}</textarea>
            @error('address')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        @if($teacher->image)
        <div class="form-group">
            <label>Current Image</label>
            <img src="{{ asset('storage/'.$teacher->image) }}" alt="Teacher Image" width="80">
        </div>
        @endif

        <div class="form-group">
            <label for="image">Upload New Image</label>
            <input id="image" type="file" name="image" class="@error('image') is-invalid @enderror">
            @error('image')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">New Password (optional)</label>
            <input id="password" type="password" name="password" placeholder="New password" class="@error('password') is-invalid @enderror">
            @error('password')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm password" class="@error('password_confirmation') is-invalid @enderror">
            @error('password_confirmation')
                <small class="field-error">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Teacher</button>
    </form>
<br><br>
    <a href="{{ route('principal.dashboard') }}">Back</a>
</div>

</body>
</html>
