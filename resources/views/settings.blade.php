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
        <a href="/profile" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: transparent;">
            <i class="bi bi-person"></i> Profile
        </a>
        <a href="/settings" class="btn btn-sm w-100 text-start" style="color: #a04070; background: #f7dce8;">
            <i class="bi bi-gear"></i> Settings
        </a>
    </div>

    {{-- ─── MAIN CONTENT ─────────────────────────────────────── --}}
    <div style="flex: 1; padding: 40px; overflow-y: auto; display: flex; flex-direction: column; align-items: center;">

        {{-- TOP BAR --}}
        <div style="width: 100%; max-width: 600px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <div>
                <h2 style="font-family: 'Cormorant Garamond', serif; color: #a04070; font-size: 2rem; margin: 0;">Settings</h2>
                <div style="font-size: 12px; color: #c07090;">Manage your preferences</div>
            </div>
            <form action="/logout" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

        <div style="width: 100%; max-width: 600px;">

            {{-- NOTIFICATION SETTINGS --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background: #f7dce8; border: none; padding: 15px;">
                    <h5 style="color: #a04070; font-weight: 600; margin: 0;">
                        <i class="bi bi-bell"></i> Notifications
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                        <label class="form-check-label" for="emailNotif" style="color: #a04070; font-weight: 500;">
                            Email Notifications
                        </label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="projectNotif" checked>
                        <label class="form-check-label" for="projectNotif" style="color: #a04070; font-weight: 500;">
                            Project Updates
                        </label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="staffNotif">
                        <label class="form-check-label" for="staffNotif" style="color: #a04070; font-weight: 500;">
                            Staff Activity
                        </label>
                    </div>
                </div>
            </div>

            {{-- PRIVACY SETTINGS --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background: #f7dce8; border: none; padding: 15px;">
                    <h5 style="color: #a04070; font-weight: 600; margin: 0;">
                        <i class="bi bi-shield-lock"></i> Privacy
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" style="color: #a04070; font-weight: 600;">Profile Visibility</label>
                        <select class="form-control" id="profileVisibility">
                            <option selected>Everyone</option>
                            <option>Only Staff</option>
                            <option>Only Me</option>
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="activityShow" checked>
                        <label class="form-check-label" for="activityShow" style="color: #a04070;">
                            Show my activity status
                        </label>
                    </div>
                </div>
            </div>

            {{-- THEME SETTINGS --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background: #f7dce8; border: none; padding: 15px;">
                    <h5 style="color: #a04070; font-weight: 600; margin: 0;">
                        <i class="bi bi-palette"></i> Theme
                    </h5>
                </div>
                <div class="card-body">
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="theme" id="lightTheme" checked>
                        <label class="btn btn-outline-secondary" for="lightTheme">Light</label>

                        <input type="radio" class="btn-check" name="theme" id="darkTheme">
                        <label class="btn btn-outline-secondary" for="darkTheme">Dark</label>

                        <input type="radio" class="btn-check" name="theme" id="autoTheme">
                        <label class="btn btn-outline-secondary" for="autoTheme">Auto</label>
                    </div>
                </div>
            </div>

        </div>{{-- end max-width wrapper --}}
    </div>{{-- end main content --}}
</div>

<script>
    document.querySelectorAll('.form-check-input').forEach(toggle => {
        toggle.addEventListener('change', () => showToast('Settings saved!', 'success'));
    });

    document.getElementById('profileVisibility').addEventListener('change', () => {
        showToast('Settings updated!', 'success');
    });

    document.querySelectorAll('input[name="theme"]').forEach(radio => {
        radio.addEventListener('change', () => showToast('Theme saved!', 'success'));
    });
</script>
@endsection