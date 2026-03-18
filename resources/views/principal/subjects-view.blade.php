
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Principal Dashboard | School Management</title>
</head>
<body>
    <section id="subjects" style="display:none;">
    <div class="container mt-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h2 class=" mb-0"><i class="bi bi-journal-text me-2"></i>Subjects Management</h2>
            <button type="button" class="btn btn-outline-secondary shadow-sm" data-section="mainContent">
                <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
            </button>
        </div>

        <div class="row">
            <div class="col-lg-4">
                
                <div class="card mb-4 shadow-sm border-0 bg-light">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Add New Subject</h5>
                        <form action="{{ route('principal.subjects.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Subject Name</label>
                                <input type="text" name="name" class="form-control border-primary" placeholder="e.g. Science" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100 shadow-sm">
                                <i class="bi bi-plus-lg"></i> Save Subject
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm border-0 bg-light">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3 text-info">Assign to Class</h5>
                        <form action="{{ route('principal.subjects.assign') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Select Class</label>
                                <select name="class_id" class="form-select border-info" required>
                                    <option value="">-- Choose Class --</option>
                                    @foreach($classes as $cls)
                                        <option value="{{ $cls->id }}">Class {{ $cls->class }} - {{ $cls->section }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Select Subjects</label>
                                <div class="p-3 border rounded bg-white" style="max-height: 200px; overflow-y: auto;">
                                    @foreach($subjects as $subject)
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" name="subjects[]" value="{{ $subject->id }}" id="sub_view_{{ $subject->id }}">
                                            <label class="form-check-label small" for="sub_view_{{ $subject->id }}">
                                                {{ $subject->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info text-white w-100 shadow-sm">
                                <i class="bi bi-link-45deg"></i> Assign Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-header bg-dark text-white py-2">
                        <span class="small fw-bold uppercase">All Available Subjects</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">ID</th>
                                        <th>Subject Name</th>
                                        <th class="text-end pe-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subjects as $subject)
                                        <tr>
                                            <td class="ps-3">{{ $subject->id }}</td>
                                            <td class="fw-medium">{{ $subject->name }}</td>
                                            <td class="text-end pe-3"> 
                                                <form action="{{ route('principal.dashboard.delete', $subject->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Delete this subject?')">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center py-3 text-muted">No subjects found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-2">
                        <span class="small fw-bold uppercase">Class-Subject Mapping</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Class</th>
                                        <th>Assigned Subjects</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($classes as $cls)
                                        <tr>
                                            <td class="ps-3 fw-bold text-dark">Cls {{ $cls->class }} ({{ $cls->section }})</td>
                                            <td>
                                                @forelse($cls->subjects as $sub)
                                                    <span class="badge bg-secondary rounded-pill me-1" style="font-size: 0.75rem;">{{ $sub->name }}</span>
                                                @empty
                                                    <span class="text-muted small">Not assigned</span>
                                                @endforelse
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('principal.class-subjects.edit',$cls->id) }}" class="btn btn-sm btn-outline-warning py-0 px-2">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center py-3 text-muted">No classes available.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> </div> </div>
</section>
</body>
</html>

