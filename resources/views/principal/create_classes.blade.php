<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes</title>
</head>
<body>

<form action="{{ route('principal.classes.store') }}" method="POST">
    @csrf
    <label for="class">Class</label>
<select name="class" id="class">
    <option value="">Select Class</option>

    @for($i = 1; $i <= 12; $i++)
        <option value="{{ $i }}">Class {{ $i }}</option>
    @endfor

</select>>

    <br><br>

    <label for="section">Section</label>
<select name="section" id="section">

@foreach(['A','B','C','D'] as $sec)
<option value="{{ $sec }}">{{ $sec }}</option>
@endforeach

</select>

    <br><br>

    <button type="submit">Submit</button>

</form>

</body>
</html>