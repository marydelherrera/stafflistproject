@extends('layouts.main')

@section('content')
<div style="display: flex; min-height: 100vh;">

    {{-- ─── SIDEBAR ─────────────────────────────────────────── --}}
    <div style="width: 230px; background: #f3c9d9; padding: 20px; overflow-y: auto; flex-shrink: 0;">
        <div style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; color: #a04070; margin-bottom: 30px; font-weight: 600;">Sakura</div>

        <div style="font-size: 10px; color: #a06080; margin-top: 15px; margin-bottom: 8px; letter-spacing: 1px; font-weight: 600;">MAIN</div>

        @if(session('user')['role'] === 'admin')
            <a href="/admin/dashboard" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: transparent;">
                <i class="bi bi-bar-chart"></i> Overview
            </a>
            <a href="/users" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: transparent;">
                <i class="bi bi-people"></i> Staff List
            </a>
            <a href="/projects" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: transparent;">
                <i class="bi bi-briefcase"></i> Projects
            </a>
        @else
            <a href="/staff/dashboard" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: transparent;">
                <i class="bi bi-house"></i> My Dashboard
            </a>
            <a href="/staff/tasks" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: transparent;">
                <i class="bi bi-list-check"></i> My Tasks
            </a>
        @endif

        <div style="font-size: 10px; color: #a06080; margin-top: 20px; margin-bottom: 8px; letter-spacing: 1px; font-weight: 600;">ACCOUNT</div>
        <a href="/profile" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: #f7dce8;">
            <i class="bi bi-person"></i> Profile
        </a>
        <a href="/settings" class="btn btn-sm w-100 text-start" style="color: #a04070; background: transparent;">
            <i class="bi bi-gear"></i> Settings
        </a>
    </div>

    {{-- ─── MAIN CONTENT ─────────────────────────────────────── --}}
    <div style="flex: 1; padding: 40px; overflow-y: auto; display: flex; flex-direction: column; align-items: center;">

        {{-- TOP BAR --}}
        <div style="width: 100%; max-width: 700px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <div>
                <h2 style="font-family: 'Cormorant Garamond', serif; color: #a04070; font-size: 2rem; margin: 0;">My Profile</h2>
                <div style="font-size: 12px; color: #c07090;">Update your account information</div>
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
            <div class="alert alert-success alert-dismissible fade show w-100" style="max-width: 700px;" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div style="width: 100%; max-width: 700px;">

            {{-- PROFILE PICTURE --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center py-5">
                    <div style="width: 120px; height: 120px; border-radius: 50%; background: #d4608a; color: white; font-size: 3rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; position: relative; overflow: hidden;">
                        <span id="avatarText">{{ strtoupper(substr(session('user')['name'], 0, 1)) }}</span>
                        <img id="profileImg" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; display: none; position: absolute; top: 0; left: 0;">
                    </div>

                    <h4 style="color: #a04070; font-weight: 600; margin-bottom: 5px;">{{ session('user')['name'] }}</h4>
                    <p style="color: #c07090; margin-bottom: 5px;">{{ session('user')['email'] }}</p>
                    <p style="margin-bottom: 20px;">
                        <span class="badge" style="background: {{ session('user')['role'] === 'admin' ? '#d4608a' : '#f3c9d9' }}; color: {{ session('user')['role'] === 'admin' ? '#fff' : '#a04070' }};">
                            {{ ucfirst(session('user')['role']) }}
                        </span>
                    </p>

                    <input type="file" id="profilePicture" accept="image/*" style="display: none;">
                    <button type="button" class="btn text-white" style="background: #d4608a;"
                        onclick="document.getElementById('profilePicture').click();">
                        <i class="bi bi-upload"></i> Change Picture
                    </button>
                </div>
            </div>

            {{-- PROFILE INFORMATION --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background: #f7dce8; border: none; padding: 15px;">
                    <h5 style="color: #a04070; font-weight: 600; margin: 0;">Profile Information</h5>
                </div>
                <div class="card-body">
                    <form id="profileForm" method="POST" action="/profile/update">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" style="color: #a04070; font-weight: 600;">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ session('user')['name'] }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: #a04070; font-weight: 600;">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ session('user')['email'] }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: #a04070; font-weight: 600;">Phone</label>
                            <input type="tel" name="phone" class="form-control" placeholder="+63 900 000 0000">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: #a04070; font-weight: 600;">Department</label>
                            <select name="department" class="form-control">
                                <option value="">Select Department</option>
                                <option>Human Resources</option>
                                <option>Finance</option>
                                <option>Marketing</option>
                                <option>Operations</option>
                                <option>Technology</option>
                            </select>
                        </div>

                        <div style="text-align: right;">
                            <button type="submit" class="btn text-white" style="background: #d4608a;">
                                <i class="bi bi-check-lg"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- CHANGE PASSWORD --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background: #f7dce8; border: none; padding: 15px;">
                    <h5 style="color: #a04070; font-weight: 600; margin: 0;">Change Password</h5>
                </div>
                <div class="card-body">
                    <form id="passwordForm" method="POST" action="/profile/change-password">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" style="color: #a04070; font-weight: 600;">Current Password</label>
                            <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: #a04070; font-weight: 600;">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter new password (min 6 chars)" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: #a04070; font-weight: 600;">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" required>
                        </div>

                        <div style="text-align: right;">
                            <button type="submit" class="btn text-white" style="background: #a04070;">
                                <i class="bi bi-lock"></i> Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>{{-- end max-width wrapper --}}
    </div>{{-- end main content --}}
</div>

<script>
    // Profile picture preview
    document.getElementById('profilePicture').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                const img        = document.getElementById('profileImg');
                const avatarText = document.getElementById('avatarText');
                img.src          = event.target.result;
                img.style.display    = 'block';
                avatarText.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });

    // Profile form
    document.getElementById('profileForm').addEventListener('submit', function (e) {
        e.preventDefault();
        fetch('/profile/update', {
            method: 'POST',
            body: new FormData(this),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Profile updated successfully!', 'success');
            } else {
                showToast(data.message || 'Error updating profile', 'error');
            }
        })
        .catch(() => showToast('Error updating profile', 'error'));
    });

    // Password form
    document.getElementById('passwordForm').addEventListener('submit', function (e) {
        e.preventDefault();
        fetch('/profile/change-password', {
            method: 'POST',
            body: new FormData(this),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Password changed successfully!', 'success');
                this.reset();
            } else {
                showToast(data.message || 'Error changing password', 'error');
            }
        })
        .catch(() => showToast('Error changing password', 'error'));
    });
</script>
@endsection