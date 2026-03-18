<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/student-dashboard.css') }}">
 
</head>

<body>

<div class="container-fluid">
             <div class="row">
                        <div class="col-md-3 sidebar text-center">
                                    <h4 class="mb-3">Student Dashboard</h4>

                                                @if($student->image)
                                                    <img src="{{ asset('storage/'.$student->image) }}" class="profile-img mb-3">
                                                @else
                                                    <img src="https://via.placeholder.com/100" class="profile-img mb-3">
                                                @endif
                                    <h5>{{ $student->name }}</h5>
                                    <p class="small">{{ $student->email }}</p>
                                    <hr>
                                    <p><strong>Mobile:</strong> {{ $student->mobile }}</p>
                                    <p><strong>Father:</strong> {{ $student->father_name }}</p>
                                    <p><strong>Gender:</strong> {{ ucfirst($student->gender) }}</p>
                                    <p><strong>DOB:</strong> {{ $student->dob }}</p>

                                    <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-danger btn-sm mt-3">Logout</button>
                                    </form>
                        </div>
                     <div class="col-md-9 p-4">
                        <div class="card shadow mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="bi bi-mortarboard-fill me-2"></i>Academic Information</h5>
                                </div>
                                    <div class="card-body">
                                        <p>
                                            <strong>Class :</strong>
                                                {{ $student->student->class->class ?? 'N/A' }}
                                                    - {{ $student->student->class->section ?? '' }}
                                        </p>
                                            <p>
                                                <strong>Age :</strong>
                                                {{ $student->student->age ?? 'N/A' }} Years
                                            </p>

                                    </div>
                        </div>
                           <div class="card shadow mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="bi bi-book-fill me-2"></i>Subjects</h5>
                                </div>
                                    <div class="card-body">

                                        <ul class="list-group">
                                             @forelse($student->student->class->subjects ?? [] as $subject)
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle text-success me-2"></i>
                                                     {{ $subject->name }}
                                                </li>
                                            @empty
                                                <li class="list-group-item text-muted">
                                                  No Subjects Found
                                                </li>
                                            @endforelse
                                        </ul>

                                    </div>
                          </div>
                    <div class="card shadow">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Address</h5>
                                </div>
                                    <div class="card-body">
                                                {{ $student->address }}
                                </div>
                 </div>

        </div>
    </div>
</div>

</body>
</html>