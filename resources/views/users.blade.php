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
        <a href="/users" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: #f7dce8;">
            <i class="bi bi-people"></i> Staff List
        </a>
        <a href="/projects" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: transparent;">
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
                <h2 style="font-family: 'Cormorant Garamond', serif; color: #a04070; font-size: 2rem; margin: 0;">Staff List</h2>
                <div style="font-size: 12px; color: #c07090;">Dashboard / Staff</div>
            </div>
            <form action="/logout" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
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

        {{-- STAFF TABLE --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header" style="background: #f7dce8; border: none; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                <strong style="color: #a04070;">ALL STAFF MEMBERS</strong>
                <button class="btn btn-sm text-white" style="background: #d4608a;"
                    data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-plus-lg"></i> Add Staff
                </button>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead style="background: #fdf0f5;">
                        <tr>
                            <th style="color: #c07090; font-weight: 600;">ID</th>
                            <th style="color: #c07090; font-weight: 600;">NAME</th>
                            <th style="color: #c07090; font-weight: 600;">EMAIL</th>
                            <th style="color: #c07090; font-weight: 600;">ROLE</th>
                            <th style="color: #c07090; font-weight: 600;">JOINED</th>
                            <th style="color: #c07090; font-weight: 600;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge" style="background: {{ $user->role === 'admin' ? '#d4608a' : '#f3c9d9' }}; color: {{ $user->role === 'admin' ? '#fff' : '#a04070' }};">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="modal" data-bs-target="#editUserModal"
                                    onclick="editUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}')">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteUser({{ $user->id }})">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No staff members found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>{{-- end main content --}}
</div>

{{-- ADD USER MODAL --}}
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #f3c9d9; border: none;">
                <h5 class="modal-title" style="color: #a04070; font-weight: 600;">Add New Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" id="addFullname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" id="addEmail" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" id="addPassword" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" id="addPasswordConfirm" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn text-white" style="background: #d4608a;" onclick="handleAddUser()">Add Staff</button>
            </div>
        </div>
    </div>
</div>

{{-- EDIT USER MODAL --}}
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #f3c9d9; border: none;">
                <h5 class="modal-title" style="color: #a04070; font-weight: 600;">Edit Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" id="editName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" id="editEmail" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn text-white" style="background: #d4608a;" onclick="handleEditUser()">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentUserId = null;

    function editUser(id, name, email) {
        currentUserId = id;
        document.getElementById('editName').value  = name;
        document.getElementById('editEmail').value = email;
    }

    function handleEditUser() {
        if (!currentUserId) return;

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('fullname', document.getElementById('editName').value);
        formData.append('email',    document.getElementById('editEmail').value);

        fetch(`/users/${currentUserId}/update`, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Staff member updated successfully!', 'success');
                bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast(data.message || 'Error updating staff member', 'error');
            }
        })
        .catch(() => showToast('Error updating staff member', 'error'));
    }

    function handleAddUser() {
        const fullname = document.getElementById('addFullname').value.trim();
        const email    = document.getElementById('addEmail').value.trim();
        const password = document.getElementById('addPassword').value;
        const confirm  = document.getElementById('addPasswordConfirm').value;

        if (!fullname || !email || !password) {
            showToast('All fields are required.', 'error');
            return;
        }
        if (password !== confirm) {
            showToast('Passwords do not match.', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('_token',               '{{ csrf_token() }}');
        formData.append('fullname',             fullname);
        formData.append('email',                email);
        formData.append('password',             password);
        formData.append('password_confirmation', confirm);

        fetch('/users', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Staff member added successfully!', 'success');
                bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast(data.message || 'Error adding staff member', 'error');
            }
        })
        .catch(() => showToast('Error adding staff member', 'error'));
    }

    function deleteUser(id) {
        if (confirm('Are you sure you want to delete this staff member?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/users/${id}/delete`;
            form.innerHTML = `@csrf`;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection