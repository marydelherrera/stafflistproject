@extends('layouts.main')

@section('content')
<div style="display: flex; min-height: 100vh;">

    {{-- ─── SIDEBAR ─────────────────────────────────────────── --}}
    <div style="width: 230px; background: #f3c9d9; padding: 20px; overflow-y: auto; flex-shrink: 0;">
        <div style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; color: #a04070; margin-bottom: 30px; font-weight: 600;">
            Sakura
        </div>

        <div style="font-size: 10px; color: #a06080; margin-top: 15px; margin-bottom: 8px; letter-spacing: 1px; font-weight: 600;">MAIN</div>
        <a href="/staff/dashboard" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: #f7dce8;">
            <i class="bi bi-house"></i> My Dashboard
        </a>
        <a href="/staff/tasks" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: transparent;">
            <i class="bi bi-list-check"></i> My Tasks
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
                <h2 style="font-family: 'Cormorant Garamond', serif; color: #a04070; font-size: 2rem; margin: 0;">My Dashboard</h2>
                <div style="font-size: 12px; color: #c07090;">Welcome back, {{ session('user')['name'] }}</div>
            </div>

            <div style="display: flex; align-items: center; gap: 15px;">
                <span class="badge" style="background: #f3c9d9; color: #a04070; font-size: 11px; padding: 6px 12px; border-radius: 20px;">
                    <i class="bi bi-person-badge"></i> Staff
                </span>
                <a href="/profile" class="btn btn-sm" style="background: #f3c9d9; color: #a04070;">
                    <i class="bi bi-person-circle"></i> Profile
                </a>
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

        {{-- STATS CARDS --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div style="font-size: 12px; color: #c07090; font-weight: 600;">MY PROJECTS</div>
                    <h3 style="color: #a04070; font-size: 2.5rem; margin: 10px 0;">{{ $staffProjects->count() }}</h3>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div style="font-size: 12px; color: #c07090; font-weight: 600;">ACTIVE</div>
                    <h3 style="color: #a04070; font-size: 2.5rem; margin: 10px 0;">{{ $staffProjects->where('status', 'active')->count() }}</h3>
                    <div style="font-size: 12px; color: #c07090;">In progress</div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div style="font-size: 12px; color: #c07090; font-weight: 600;">COMPLETED</div>
                    <h3 style="color: #a04070; font-size: 2.5rem; margin: 10px 0;">{{ $staffProjects->where('status', 'completed')->count() }}</h3>
                    <div style="font-size: 12px; color: #c07090;">Done</div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div style="font-size: 12px; color: #c07090; font-weight: 600;">ON HOLD</div>
                    <h3 style="color: #a04070; font-size: 2.5rem; margin: 10px 0;">{{ $staffProjects->where('status', 'hold')->count() }}</h3>
                    <div style="font-size: 12px; color: #c07090;">Paused</div>
                </div>
            </div>
        </div>

        {{-- MY PROJECTS TABLE --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header" style="background: #f7dce8; border: none; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                <strong style="color: #a04070;">MY ASSIGNED PROJECTS</strong>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead style="background: #fdf0f5;">
                        <tr>
                            <th style="color: #c07090; font-weight: 600;">#</th>
                            <th style="color: #c07090; font-weight: 600;">PROJECT NAME</th>
                            <th style="color: #c07090; font-weight: 600;">STATUS</th>
                            <th style="color: #c07090; font-weight: 600;">PROGRESS</th>
                            <th style="color: #c07090; font-weight: 600;">START DATE</th>
                            <th style="color: #c07090; font-weight: 600;">END DATE</th>
                            <th style="color: #c07090; font-weight: 600;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staffProjects as $project)
                        <tr>
                            <td>#{{ $project->id }}</td>
                            <td><strong>{{ $project->name }}</strong></td>
                            <td>
                                @php
                                    $statusColors = [
                                        'active'    => ['bg' => '#d4608a', 'text' => '#fff'],
                                        'completed' => ['bg' => '#a04070', 'text' => '#fff'],
                                        'hold'      => ['bg' => '#f3c9d9', 'text' => '#a04070'],
                                    ];
                                    $color = $statusColors[$project->status] ?? ['bg' => '#eee', 'text' => '#333'];
                                @endphp
                                <span class="badge" style="background: {{ $color['bg'] }}; color: {{ $color['text'] }};">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div class="progress" style="flex: 1; height: 8px; border-radius: 4px;">
                                        <div class="progress-bar" style="width: {{ $project->progress ?? 0 }}%; background: #d4608a; border-radius: 4px;"></div>
                                    </div>
                                    <span style="font-size: 12px; color: #a04070;">{{ $project->progress ?? 0 }}%</span>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($project->start_date)->format('M d, Y') }}</td>
                            <td>{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('M d, Y') : '—' }}</td>
                            <td>
                                <button class="btn btn-sm text-white" style="background: #d4608a;"
                                    data-bs-toggle="modal" data-bs-target="#submitModal"
                                    onclick="openSubmitModal({{ $project->id }}, '{{ addslashes($project->name) }}', {{ $project->progress ?? 0 }})">
                                    <i class="bi bi-upload"></i> Submit
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No projects assigned yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>{{-- end main content --}}
</div>

{{-- SUBMIT WORK MODAL --}}
<div class="modal fade" id="submitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #f3c9d9; border: none;">
                <h5 class="modal-title" style="color: #a04070; font-weight: 600;">
                    <i class="bi bi-upload"></i> Submit Work — <span id="modalProjectName"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="submitProjectId">

                <div class="mb-3">
                    <label class="form-label" style="color: #a04070; font-weight: 600;">Progress (%)</label>
                    <input type="range" class="form-range" id="progressRange" min="0" max="100" value="0"
                        oninput="document.getElementById('progressValue').textContent = this.value + '%'">
                    <div style="text-align: center; color: #d4608a; font-weight: 600;" id="progressValue">0%</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="color: #a04070; font-weight: 600;">Description</label>
                    <textarea class="form-control" id="submitDescription" rows="4" placeholder="Describe what you've done..." required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="color: #a04070; font-weight: 600;">Attachment <small style="color: #c07090;">(optional, max 5MB)</small></label>
                    <input type="file" class="form-control" id="submitAttachment">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn text-white" style="background: #d4608a;" onclick="submitWork()">
                    <i class="bi bi-send"></i> Submit
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openSubmitModal(projectId, projectName, progress) {
        document.getElementById('submitProjectId').value = projectId;
        document.getElementById('modalProjectName').textContent = projectName;
        document.getElementById('progressRange').value = progress;
        document.getElementById('progressValue').textContent = progress + '%';
        document.getElementById('submitDescription').value = '';
        document.getElementById('submitAttachment').value = '';
    }

    function submitWork() {
        const projectId   = document.getElementById('submitProjectId').value;
        const progress    = document.getElementById('progressRange').value;
        const description = document.getElementById('submitDescription').value.trim();
        const attachment  = document.getElementById('submitAttachment').files[0];

        if (!description) {
            alert('Please enter a description.');
            return;
        }

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('project_id', projectId);
        formData.append('progress', progress);
        formData.append('description', description);
        if (attachment) formData.append('attachment', attachment);

        fetch('/staff/submit', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('submitModal')).hide();
                alert('Work submitted successfully!');
                setTimeout(() => location.reload(), 1500);
            } else {
                alert(data.message || 'Error submitting work.');
            }
        })
        .catch(() => alert('Error submitting work.'));
    }
</script>
@endsection