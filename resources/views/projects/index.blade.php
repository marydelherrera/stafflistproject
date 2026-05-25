@extends('layouts.main')

@section('content')
<div style="display: flex; min-height: 100vh;">

    {{-- ─── SIDEBAR ─────────────────────────────────────────── --}}
    <div style="width: 230px; background: #f3c9d9; padding: 20px; overflow-y: auto; flex-shrink: 0;">
        <div style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; color: #a04070; margin-bottom: 30px; font-weight: 600;">Sakura</div>

        <div style="font-size: 10px; color: #a06080; margin-top: 15px; margin-bottom: 8px; letter-spacing: 1px; font-weight: 600;">MAIN</div>
        <a href="/admin/dashboard" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: transparent;">
            <i class="bi bi-bar-chart"></i> Overview
        </a>
        <a href="/admin/users" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: transparent;">
            <i class="bi bi-people"></i> Staff List
        </a>
        <a href="/admin/projects" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: #f7dce8;">
            <i class="bi bi-briefcase"></i> Projects
        </a>

        <div style="font-size: 10px; color: #a06080; margin-top: 20px; margin-bottom: 8px; letter-spacing: 1px; font-weight: 600;">ACCOUNT</div>
        <a href="/profile" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: transparent;">
            <i class="bi bi-person"></i> Profile
        </a>
        <a href="/settings" class="btn btn-sm w-100 text-start" style="color: #a04070; background: transparent;">
            <i class="bi bi-gear"></i> Settings
        </a>
    </div>

    {{-- ─── MAIN CONTENT ─────────────────────────────────────── --}}
    <div style="flex: 1; padding: 25px; overflow-y: auto;">

        {{-- TOP BAR --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h2 style="font-family: 'Cormorant Garamond', serif; color: #a04070; font-size: 2rem; margin: 0;">Projects Management</h2>
                <div style="font-size: 12px; color: #c07090;">Create, assign, and manage all projects</div>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <button class="btn btn-sm text-white" style="background: #d4608a;"
                    data-bs-toggle="modal" data-bs-target="#addProjectModal">
                    <i class="bi bi-plus-lg"></i> New Project
                </button>
                <form action="/logout" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        {{-- FLASH MESSAGES --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- STATS --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 30px;">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div style="font-size: 12px; color: #c07090; font-weight: 600;">TOTAL PROJECTS</div>
                    <h3 style="color: #a04070;">{{ $projects->count() }}</h3>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div style="font-size: 12px; color: #c07090; font-weight: 600;">ACTIVE</div>
                    <h3 style="color: #d4608a;">{{ $projects->where('status', 'active')->count() }}</h3>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div style="font-size: 12px; color: #c07090; font-weight: 600;">COMPLETED</div>
                    <h3 style="color: #a04070;">{{ $projects->where('status', 'completed')->count() }}</h3>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div style="font-size: 12px; color: #c07090; font-weight: 600;">ON HOLD</div>
                    <h3 style="color: #a04070;">{{ $projects->where('status', 'hold')->count() }}</h3>
                </div>
            </div>
        </div>

        {{-- PROJECTS TABLE --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header" style="background: #f7dce8; border: none; padding: 15px;">
                <strong style="color: #a04070;">ALL PROJECTS</strong>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead style="background: #fdf0f5;">
                        <tr>
                            <th style="color: #c07090; font-weight: 600;">ID</th>
                            <th style="color: #c07090; font-weight: 600;">PROJECT NAME</th>
                            <th style="color: #c07090; font-weight: 600;">START DATE</th>
                            <th style="color: #c07090; font-weight: 600;">END DATE</th>
                            <th style="color: #c07090; font-weight: 600;">PROGRESS</th>
                            <th style="color: #c07090; font-weight: 600;">STATUS</th>
                            <th style="color: #c07090; font-weight: 600;">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                        <tr>
                            <td>#{{ $project->id }}</td>
                            <td><strong>{{ $project->name }}</strong></td>
                            <td>{{ $project->user->name ?? '—' }}</td>
                            <td>{{ $project->start_date->format('M d, Y') }}</td>
                            <td>{{ $project->end_date ? $project->end_date->format('M d, Y') : '—' }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <div class="progress" style="flex:1; height:7px; border-radius:4px; min-width:60px;">
                                        <div class="progress-bar" style="width:{{ $project->progress ?? 0 }}%; background:#d4608a;"></div>
                                    </div>
                                    <span style="font-size:11px; color:#a04070; min-width:35px;">{{ $project->progress ?? 0 }}%</span>
                                </div>
                            </td>
                            <td>
                                @php
                                    $bg = match($project->status) {
                                        'active'    => '#d4608a',
                                        'completed' => '#a04070',
                                        default     => '#f3c9d9',
                                    };
                                    $fg = $project->status === 'hold' ? '#a04070' : '#fff';
                                @endphp
                                <span class="badge" style="background:{{ $bg }}; color:{{ $fg }};">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td style="white-space: nowrap;">
                                <button class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="modal" data-bs-target="#editProjectModal"
                                    onclick="editProject(
                                        {{ $project->id }},
                                        '{{ addslashes($project->name) }}',
                                        '{{ addslashes($project->description ?? '') }}',
                                        '{{ $project->start_date->format('Y-m-d') }}',
                                        '{{ $project->end_date ? $project->end_date->format('Y-m-d') : '' }}',
                                        '{{ $project->status }}',
                                        {{ $project->progress ?? 0 }}
                                    )">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteProject({{ $project->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No projects found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>{{-- end main content --}}
</div>

{{-- ADD PROJECT MODAL --}}
<div class="modal fade" id="addProjectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #f3c9d9; border: none;">
                <h5 class="modal-title" style="color: #a04070; font-weight: 600;">Create New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Project Name</label>
                    <input type="text" id="addName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea id="addDescription" class="form-control" rows="3"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" id="addStartDate" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" id="addEndDate" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select id="addStatus" class="form-control" required>
                            <option value="active">Active</option>
                            <option value="hold">On Hold</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Progress (%)</label>
                        <input type="number" id="addProgress" class="form-control" min="0" max="100" value="0">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn text-white" style="background: #d4608a;" onclick="handleAddProject()">
                    Create Project
                </button>
            </div>
        </div>
    </div>
</div>

{{-- EDIT PROJECT MODAL --}}
<div class="modal fade" id="editProjectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #f3c9d9; border: none;">
                <h5 class="modal-title" style="color: #a04070; font-weight: 600;">Edit Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Project Name</label>
                    <input type="text" id="editName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea id="editDescription" class="form-control" rows="3"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" id="editStartDate" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" id="editEndDate" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select id="editStatus" class="form-control" required>
                            <option value="active">Active</option>
                            <option value="hold">On Hold</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Progress (%)</label>
                        <input type="number" id="editProgress" class="form-control" min="0" max="100">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn text-white" style="background: #d4608a;" onclick="handleEditProject()">
                    Update Project
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentProjectId = null;

    function editProject(id, name, description, startDate, endDate, status, progress) {
        currentProjectId = id;
        document.getElementById('editName').value        = name;
        document.getElementById('editDescription').value = description;
        document.getElementById('editStartDate').value   = startDate;
        document.getElementById('editEndDate').value     = endDate;
        document.getElementById('editStatus').value      = status;
        document.getElementById('editProgress').value    = progress;
    }

    function handleAddProject() {
        const formData = new FormData();
        formData.append('_token',      '{{ csrf_token() }}');
        formData.append('name',        document.getElementById('addName').value);
        formData.append('description', document.getElementById('addDescription').value);
        formData.append('start_date',  document.getElementById('addStartDate').value);
        formData.append('end_date',    document.getElementById('addEndDate').value);
        formData.append('status',      document.getElementById('addStatus').value);
        formData.append('progress',    document.getElementById('addProgress').value);

        fetch('/admin/projects', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                alert('Project created successfully!');
                bootstrap.Modal.getInstance(document.getElementById('addProjectModal')).hide();
                setTimeout(() => location.reload(), 1000);
            } else {
                alert(data.message || 'Error creating project');
            }
        })
        .catch(() => alert('Error creating project'));
    }

    function handleEditProject() {
        if (!currentProjectId) return;

        const formData = new FormData();
        formData.append('_token',      '{{ csrf_token() }}');
        formData.append('name',        document.getElementById('editName').value);
        formData.append('description', document.getElementById('editDescription').value);
        formData.append('start_date',  document.getElementById('editStartDate').value);
        formData.append('end_date',    document.getElementById('editEndDate').value);
        formData.append('status',      document.getElementById('editStatus').value);
        formData.append('progress',    document.getElementById('editProgress').value);

        fetch(`/admin/projects/${currentProjectId}/update`, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                alert('Project updated successfully!');
                bootstrap.Modal.getInstance(document.getElementById('editProjectModal')).hide();
                setTimeout(() => location.reload(), 1000);
            } else {
                alert(data.message || 'Error updating project');
            }
        })
        .catch(() => alert('Error updating project'));
    }

    function deleteProject(id) {
        if (confirm('Are you sure you want to delete this project?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/projects/${id}/delete`;
            form.innerHTML = `@csrf`;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection