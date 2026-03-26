<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Principal Dashboard | School Management</title>
</head>
<body>
    <section class="teachers-section" id="teachers" style="display:none;">
    <div class="container mt-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark"><i class="bi bi-person-video3 me-2"></i>Teachers List</h2>
                <button type="button" class="btn btn-outline-secondary btn-sm shadow-sm" data-section="mainContent">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </button>
            </div>
            <div class="action-buttons">
                <a href="{{ route('principal.register') }}" class="btn btn-primary shadow-sm px-4">
                    <i class="bi bi-person-plus-fill me-1"></i> Register New Teacher
                </a>
                <a href="{{ route('invite.create') }}" class="btn btn-outline-primary shadow-sm px-4 ms-2">
                    <i class="bi bi-envelope-paper me-1"></i> Invite Teacher
                </a>
            </div>
        </div>

        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0 small fw-bold text-uppercase">Faculty Records</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">ID</th>
                                <th>Photo</th>
                                <th>Teacher Details</th>
                                <th>Personal Info</th>
                                <th>Contact Details</th>
                                <th>Address</th>
                                <th class="text-center pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teachers as $teacher)
                                <tr>
                                    <td class="ps-3 fw-bold">{{ $teacher->id }}</td>

                                    {{--}}
                                    {{-- <td>
                                        @if($teacher->image)
                                            <img src="{{ asset('storage/'.$teacher->image) }}" 
                                                 class="rounded border shadow-sm" 
                                                 width="50" height="50" 
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px;">
                                                <i class="bi bi-person-badge text-secondary fs-4"></i>
                                            </div>
                                        @endif
                                    </td>
                                      --}}
                                    <td class="text-center">
                                        @if($teacher->image)
                                            <img src="{{ asset('storage/'.$teacher->image) }}"
                                                 class="rounded-circle border"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#imageModal{{ $teacher->id }}"
                                                 style="cursor:pointer;width:50px;height:50px;object-fit:cover;">
                                        @else
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border"
                                                 style="width:50px;height:50px;">
                                                <i class="bi bi-person text-secondary"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $teacher->name }}</div>
                                        <div class="small text-muted">{{ $teacher->email }}</div>
                                    </td>
                                    <td>
                                        <div class="small"><strong>Gender:</strong> {{ ucfirst($teacher->gender) }}</div>
                                        <div class="small text-muted"><strong>Father:</strong> {{ $teacher->father_name }}</div>
                                    </td>
                                    <td>
                                        <div class="badge bg-light text-dark border">
                                            <i class="bi bi-phone me-1"></i>{{ $teacher->mobile }}
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted d-inline-block text-truncate" style="max-width: 150px;" title="{{ $teacher->address }}">
                                            {{ $teacher->address }}
                                        </small>
                                    </td>
                                    <td class="text-center pe-3">
                                        <div class="btn-group shadow-sm">
                                            <a href="{{ route('principal.teacher.edit', $teacher->id) }}" 
                                               class="btn btn-warning btn-sm" title="Edit Teacher">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            
                                            <form action="{{ route('principal.teacher.delete', $teacher->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <span class="text-muted">No teachers found in the system.</span>
                                    </td>
                                </tr>
                            @endforelse  
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-2 text-end">
                <small class="text-muted">Total Faculty: {{ count($teachers) }}</small>
            </div>
        </div>
    </div>
</section>


@foreach($teachers as $teacher)
    @if($teacher->image)
    <div class="modal fade" id="imageModal{{ $teacher->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5 class="modal-title">Teacher Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <img src="{{ asset('storage/'.$teacher->image) }}"
                         class="img-fluid rounded"
                         style="max-height:500px;object-fit:contain;">
                </div>

            </div>
        </div>
    </div>
    @endif
@endforeach

</body>
</html>
