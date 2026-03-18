<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Principal Dashboard | School Management</title>
 
    
</head>
<body>
<section class="students-section" id="students" style="display:none;">
    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark"><i class="bi bi-mortarboard-fill me-2"></i>Students List</h2>
                <button type="button" class="btn btn-outline-secondary btn-sm shadow-sm" data-section="mainContent">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </button>
            </div>
            <div class="action-buttons">
                <a href="{{ route('principal.register') }}" class="btn btn-primary shadow-sm px-4">
                    <i class="bi bi-person-plus-fill me-1"></i> Register New Student
                </a>
            </div>
        </div>

        <div class="card shadow border-0">
            <div class="card-header py-3">
                <h5 class="mb-0 small fw-bold text-uppercase">Student Records</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">ID</th>
                                <th>Photo</th>
                                <th>Student Details</th>
                                <th>Personal Info</th>
                                <th>Contact Info</th>
                                <th>Address</th>
                                <th class="text-center pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td class="ps-3 fw-bold">{{ $student->id }}</td>
                                    <td>
                                        @if($student->image)
                                            <img src="{{ asset('storage/'.$student->image) }}" class="rounded-circle border shadow-sm" width="50" height="50" style="object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px;">
                                                <i class="bi bi-person text-secondary fs-4"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $student->name }}</div>
                                        <div class="small text-muted">{{ $student->email }}</div>
                                        <span class="badge">{{ ucfirst($student->gender) }}</span>
                                    </td>
                                    <td>
                                        <div class="small"><strong>Age:</strong> {{ $student->student->age ?? 'N/A' }}</div>
                                        <div class="small text-muted"><strong>Class:</strong> {{ $student->student->class->class ?? 'N/A' }} - {{ $student->student->class->section ?? '' }}</div>
                                    </td>
                                    <td>
                                        <div class="badge"><i class="bi bi-phone me-1"></i>{{ $student->mobile }}</div>
                                        <div class="small text-muted"><strong>Father:</strong> {{ $student->father_name }}</div>
                                    </td>
                                    <td>
                                        <small class="text-muted d-inline-block text-truncate" style="max-width: 150px;" title="{{ $student->address }}">
                                            {{ $student->address }}
                                        </small>
                                    </td>
                                    <td class="text-center pe-3">
                                        <div class="btn-group shadow-sm">
                                            <a href="{{ route('principal.student.edit', $student->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('principal.student.delete', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-people text-muted fs-1 d-block mb-2"></i>
                                        <span class="text-muted">No students found.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-2">
                <small class="text-muted">Total Students: {{ count($students) }}</small>
            </div>
        </div>
    </div>
</section>
</body>
</html>