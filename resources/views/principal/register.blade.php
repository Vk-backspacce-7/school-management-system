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

    <!-- Notification Container -->
<div class="notification-container">
    @if(session('success'))
        <div class="notification success">
            <span class="icon">✔</span>
            <span class="message">{{ session('success') }}</span>
            <button class="close-btn">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="notification error">
            <span class="icon">⚠</span>
            <span class="message">{{ session('error') }}</span>
            <button class="close-btn">&times;</button>
        </div>
    @endif

    @if(session('info'))
        <div class="notification info">
            <span class="icon">ℹ</span>
            <span class="message">{{ session('info') }}</span>
            <button class="close-btn">&times;</button>
        </div>
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="notification error">
                <span class="icon">⚠</span>
                <span class="message">{{ $error }}</span>
                <button class="close-btn">&times;</button>
            </div>
        @endforeach
    @endif
</div>
 
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>

    
document.addEventListener('DOMContentLoaded', function () {
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach((notification, index) => {
        notification.style.animationDelay = `${index * 0.1}s`;

        const timeout = setTimeout(() => removeNotification(notification), 4000);

        const closeBtn = notification.querySelector('.close-btn');
        closeBtn.addEventListener('click', () => {
            clearTimeout(timeout);
            removeNotification(notification);
        });
    });

    function removeNotification(notification) {
        notification.style.animation = 'slideFadeOut 0.4s ease forwards';
        setTimeout(() => notification.remove(), 400);
    }
});

    </script>

</body>
</html>