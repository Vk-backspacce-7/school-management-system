 <!DOCTYPE html>
<html>
<head>
<title>Login</title> 
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<div class="container">

<h2>Login</h2>

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
@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form action="{{ route('login.store') }}" method="POST">
    @csrf
    <input type="email" name="email" value="{{ old('email') }}" required>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>
<br><br>
<p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
</div>

</body>
</html>
