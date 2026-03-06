 <!DOCTYPE html>
<html>
<head>
<title>Login</title> 
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">
<h2>Login</h2>
    <div class="from">
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <label>Email:</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    <label> Password:</label>
                    <input type="password" name="password" required>
                    <button type="submit">Login</button>
                </form>
    </div>

    <!-- successs msg -->
    @if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
    @endif

     <!-- errorr msg -->

        @if($errors->any())
        <ul style="color:red">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
        @endif
        @if(session('error'))
            <p style="color:red">{{ session('error') }}</p>
        @endif

        <br><br>
            <div>
            <p>Don't have an account? <button> <a href="{{ route('register') }}">Register here</a></button></p>
            </div>
        </div>

</body>
</html>
