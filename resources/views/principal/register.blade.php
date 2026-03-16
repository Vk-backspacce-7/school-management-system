<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<div class="container">

<h2>Register Form</h2>

                <div class="form">
            <form action="{{ route('principal.register.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="name">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Name">

                 

                    <label for="gender">Gender</label>
                <label><input type="radio" name="gender" value="male" @checked(old('gender')==='male')> Male</label>
                <label><input type="radio" name="gender" value="female" @checked(old('gender')==='female')> Female</label>
                <label><input type="radio" name="gender" value="other" @checked(old('gender')==='other')> Other</label>

                    <label for="father_name">Father Name</label>
                <input type="text" name="father_name" value="{{ old('father_name') }}" placeholder="Father Name">

                    <label for="email">email</label>
                <input type="email" name="email" value="{{ old('email') }}"  >

                    <label for="mobile">mobile</label>
                <input type="tel" name="mobile" value="{{ old('mobile') }}" placeholder="10-digit mobile">

                    <label for="address">address</label>
                <textarea name="address">{{ old('address') }}</textarea>

                    <label>Image</label>
                <input type="file" name="image">

                    <label for="password">Password</label>
                <input type="password" name="password"  >

                    <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation"  >

                    <label for="role">Role</label>

                    <select name="role"  >
                        <option value="">-- Select Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" @selected(old('role') === $role->name)>{{ $role->name }}</option>
                        @endforeach
                    </select>

                <button type="submit">Register</button>
            </form>
</div>      


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

 
</div>
<a class="nav-link" href="{{ route('principal.dashboard') }}">Back</a>
</body>
</html>