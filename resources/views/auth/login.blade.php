 <!DOCTYPE html>
<html>
<head>
<title>Login</title> 
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

<form action="/login" method="POST">

@csrf

<p>
<label>Email</label>
<input type="email" name="email" value="{{ old('email') }}" required>
</p>

<p>
<label>Password</label>
<input type="password" name="password" required>
</p>

<button type="submit">Login</button>

<br><br>

<p>
Don't have account? 
<a href="/register">Register</a>
</p>

</form>

</div>

</body>
</html>