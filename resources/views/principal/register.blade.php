<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            max-width: 700px;
            margin: auto;
        }
    </style>
</head>

<body>

<div class="container py-5">

    <!-- Back Button -->
    <a href="{{ route('principal.dashboard') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>

    <div class="card shadow">
        <div class="card-body">

            <h4 class="mb-4 text-center">Register Form</h4>

            @include('partials.flash-notifications')

            <form action="{{ route('principal.register.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                        class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gender -->
                <div class="mb-3">
                    <label class="form-label d-block">Gender</label>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="male" @checked(old('gender')==='male') required>
                        <label class="form-check-label">Male</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="female" @checked(old('gender')==='female')>
                        <label class="form-check-label">Female</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="other" @checked(old('gender')==='other')>
                        <label class="form-check-label">Other</label>
                    </div>

                    @error('gender')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Father Name -->
                <div class="mb-3">
                    <label class="form-label">Father Name</label>
                    <input type="text" name="father_name" value="{{ old('father_name') }}"
                        class="form-control @error('father_name') is-invalid @enderror" required>
                    @error('father_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mobile -->
                <div class="mb-3">
                    <label class="form-label">Mobile</label>
                    <input type="tel" name="mobile" value="{{ old('mobile') }}"
                        class="form-control @error('mobile') is-invalid @enderror"
                        pattern="[0-9]{10}" required>
                    @error('mobile')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address"
                        class="form-control @error('address') is-invalid @enderror"
                        rows="3" required>{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label class="form-label">Upload Image</label>
                    <input type="file" name="image"
                        class="form-control @error('image') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png" required>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role"
                        class="form-select @error('role') is-invalid @enderror" required>
                        <option value="">-- Select Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" @selected(old('role') === $role->name)>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Register
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>