<!DOCTYPE html>
<html>
<head>
    <title>Edit Assigned Subjects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-3">
        <h2>Edit Assigned Subjects</h2>
        <a href="{{ route('principal.dashboard.index') }}" class="btn btn-secondary">Back</a>
    </div>
 
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('principal.class-subjects.update', $class->id) }}" method="POST">
                @csrf
                @method('PUT')
 
                <div class="mb-3">
                    <label>Class:</label>
                    <input type="text" class="form-control" value="Class {{ $class->class }} - {{ $class->section }}" disabled>
                </div>

   
                <div class="mb-3">
                    <label>Subjects:</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($subjects as $subject)
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="subjects[]" 
                                    value="{{ $subject->id }}" 
                                    id="subject{{ $subject->id }}"
                                    {{ $class->subjects->contains($subject->id) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="subject{{ $subject->id }}">
                                    {{ $subject->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Update Subjects</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>