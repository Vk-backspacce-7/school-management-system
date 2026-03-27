<section id="subjects" class="dashboard-section">
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="section-header">
            <div>
                <h2 class="section-title"><i class="bi bi-book me-2"></i>Subjects Management</h2>
                <button type="button" class="btn btn-outline-dark btn-sm" data-section="mainContent">
                    <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
                </button>
            </div>
        </div>

        <div class="row g-3 g-lg-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-3">Add New Subject</h5>
                        <form action="{{ route('principal.subjects.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Subject Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Science" required>
                                @error('name')
                                    <small class="field-error">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-dark w-100">
                                <i class="bi bi-plus-lg"></i> Save Subject
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-3">Assign to Class</h5>
                        <form action="{{ route('principal.subjects.assign') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Select Class</label>
                                <select name="class_id" class="form-select @error('class_id') is-invalid @enderror" required>
                                    <option value="">-- Choose Class --</option>
                                    @foreach($classes as $cls)
                                        <option value="{{ $cls->id }}" {{ old('class_id') == $cls->id ? 'selected' : '' }}>Class {{ $cls->class }} - {{ $cls->section }}</option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <small class="field-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Select Subjects</label>
                                <div class="subject-scroll-list">
                                    @foreach($subjects as $subject)
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" name="subjects[]" value="{{ $subject->id }}" id="sub_view_{{ $subject->id }}" {{ in_array($subject->id, old('subjects', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="sub_view_{{ $subject->id }}">
                                                {{ $subject->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('subjects')
                                    <small class="field-error">{{ $message }}</small>
                                @enderror
                                @error('subjects.*')
                                    <small class="field-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-dark w-100">
                                <i class="bi bi-link-45deg"></i> Assign Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm mb-3 border-0">
                    <div class="card-header py-2">
                        <span class="small fw-bold text-uppercase">All Available Subjects</span>
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
                                                    <button type="submit" class="btn btn-link p-0 text-dark" onclick="return confirm('Delete this subject?')">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-3 text-muted">No subjects found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header py-2">
                        <span class="small fw-bold text-uppercase">Class-Subject Mapping</span>
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
                                            <td class="ps-3 fw-semibold">Cls {{ $cls->class }} ({{ $cls->section }})</td>
                                            <td>
                                                @forelse($cls->subjects as $sub)
                                                    <span class="badge mono-badge me-1">{{ $sub->name }}</span>
                                                @empty
                                                    <span class="text-muted small">Not assigned</span>
                                                @endforelse
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('principal.class-subjects.edit', $cls->id) }}" class="btn btn-sm btn-outline-dark py-0 px-2" title="Edit class subjects">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-3 text-muted">No classes available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>