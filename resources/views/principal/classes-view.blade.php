<section class="classes-section" id="classes" style="display:none;">
    <div class="container mt-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h2 class="fw-bold text-dark mb-0"><i class="bi bi-door-open-fill me-2"></i>Classes Management</h2>
            <button type="button" class="btn btn-outline-secondary btn-sm shadow-sm" data-section="mainContent">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </button>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="mb-0 small fw-bold text-uppercase">Add New Class</h5>
                    </div>
                    <div class="card-body bg-light">
                        <form action="{{ route('principal.classes.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                               
                                <label class="form-label small fw-bold">Select Class</label>

                                    <select name="class" class="form-select border-success" required>
                                        
                                        <option value="">-- Choose Class --</option>
                                        @for($i=1; $i<=12; $i++)
                                            <option value="{{ $i }}">Class {{ $i }}</option>
                                        @endfor
                                    </select>
                            </div>

                            <div class="mb-3">
                               
                                <select name="section" class="form-select border-success" required>
                                     <option value="">-- Choose  section --</option>
                                    @foreach(['A','B','C','D','E'] as $sec)
                                        <option value="{{ $sec }}">Section {{ $sec }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success w-100 shadow-sm mt-2">
                                <i class="bi bi-plus-square me-1"></i> Create Class
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0 small fw-bold text-uppercase">Existing Classes & Sections</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">ID</th>
                                        <th>Class Name</th>
                                        <th>Section</th>
                                        <th>Created Date</th>
                                        <th class="text-center pe-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($classes as $cls)
                                        <tr>
                                            <td class="ps-3 fw-bold">{{ $cls->id }}</td>
                                            <td>
                                                <span class="badge bg-primary rounded-pill px-3">
                                                    Class {{ $cls->class }}
                                                </span>
                                            </td>
                                            <td class="fw-bold text-secondary text-center" style="width: 100px;">
                                                {{ $cls->section }}
                                            </td>
                                            <td class="small text-muted">
                                                {{ $cls->created_at->format('d M, Y') }}
                                            </td>
                                            <td class="text-center pe-3">
                                                <div class="btn-group">
                                                    <a href="{{ route('principal.classes.edit', $cls->id) }}" 
                                                       class="btn btn-outline-primary btn-sm" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    
                                                    <form action="{{ route('principal.classes.delete', $cls->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this class?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="bi bi-exclamation-circle d-block fs-2 mb-2"></i>
                                                No classes have been created yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white py-2">
                        <small class="text-muted">Total Active Classes: {{ count($classes) }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>