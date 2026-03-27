<section class="teachers-section dashboard-section" id="teachers">
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="section-header">
            <div>
                <h2 class="section-title"><i class="bi bi-person-video3 me-2"></i>Teachers List</h2>
                <button type="button" class="btn btn-outline-dark btn-sm" data-section="mainContent">
                    <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
                </button>
            </div>
            <div class="action-buttons">
                <a href="{{ route('principal.register') }}" class="btn btn-dark">
                    <i class="bi bi-person-plus-fill me-1"></i> Register New Teacher
                </a>
                <a href="{{ route('invite.create') }}" class="btn btn-outline-dark">
                    <i class="bi bi-envelope-paper me-1"></i> Invite Teacher
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header py-3">
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
                                <th>Contact</th>
                                <th>Address</th>
                                <th class="text-center pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teachers as $teacher)
                                <tr>
                                    <td class="ps-3 fw-semibold">{{ $teacher->id }}</td>
                                    <td class="text-center">
                                        @if($teacher->image)
                                            <button
                                                type="button"
                                                class="btn p-0 border-0"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-image="{{ asset('storage/' . $teacher->image) }}"
                                                data-name="{{ $teacher->name }}"
                                                data-email="{{ $teacher->email }}"
                                                aria-label="View {{ $teacher->name }} image"
                                            >
                                                <img
                                                    src="{{ asset('storage/' . $teacher->image) }}"
                                                    class="rounded-circle border"
                                                    width="50"
                                                    height="50"
                                                    loading="lazy"
                                                    decoding="async"
                                                    style="object-fit: cover;"
                                                    alt="{{ $teacher->name }} photo"
                                                >
                                            </button>
                                        @else
                                            <span class="small text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $teacher->name }}</div>
                                        <div class="small text-muted">{{ $teacher->email }}</div>
                                    </td>
                                    <td>
                                        <div class="small"><strong>Gender:</strong> {{ ucfirst($teacher->gender) }}</div>
                                        <div class="small text-muted"><strong>Father:</strong> {{ $teacher->father_name }}</div>
                                    </td>
                                    <td>{{ $teacher->mobile }}</td>
                                    <td><small class="text-muted">{{ $teacher->address }}</small></td>
                                    <td class="text-center pe-3">
                                        <div class="btn-group">
                                            <a href="{{ route('principal.teacher.edit', $teacher->id) }}" class="btn btn-outline-dark btn-sm" title="Edit Teacher">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('principal.teacher.delete', $teacher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-dark btn-sm" title="Delete Teacher">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">No teachers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="teacherImageLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teacherImageLabel">Teacher Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="teacherImageModalSrc" src="" class="img-fluid rounded mb-3" style="max-height: 420px; object-fit: contain;" alt="Teacher image preview">
                    <p id="teacherImageModalEmail" class="small text-muted mb-0"></p>
                </div>
            </div>
        </div>
    </div>
</section>