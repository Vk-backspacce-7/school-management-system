<!DOCTYPE html>
<html>
<head>
    <title>Edit Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    @include('partials.flash-notifications')

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Edit Class</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('principal.classes.update',$cls->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">

                    <div class="col-md-6">
                        <label class="form-label">Class</label>
                        <select name="class" class="form-control @error('class') is-invalid @enderror" required>
                            <option value="">Select Class</option>
                            @for($i=1;$i<=12;$i++)
                                <option value="{{ $i }}" {{ old('class', $cls->class) == $i ? 'selected' : '' }}>
                                    Class {{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('class')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Section</label>
                        <select name="section" class="form-control @error('section') is-invalid @enderror" required>
                            @foreach(['A','B','C','D'] as $sec)
                                <option value="{{ $sec }}" {{ old('section', $cls->section) == $sec ? 'selected' : '' }}>
                                    {{ $sec }}
                                </option>
                            @endforeach
                        </select>
                        @error('section')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-success">Update Class</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>

            </form>

        </div>
    </div>

</div>

</body>
</html>
