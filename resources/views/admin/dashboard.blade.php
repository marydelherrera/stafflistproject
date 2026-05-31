@extends('layouts.main')

@section('content')
<div style="display: flex; min-height: 100vh;">

    {{-- ─── SIDEBAR ─────────────────────────────────────────── --}}
    <div style="width: 230px; background: #f3c9d9; padding: 20px; overflow-y: auto; flex-shrink: 0;">
        <div style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; color: #a04070; margin-bottom: 30px; font-weight: 600;">Sakura</div>

        <div style="font-size: 10px; color: #a06080; margin-top: 15px; margin-bottom: 8px; letter-spacing: 1px; font-weight: 600;">MAIN</div>
        <a href="/admin/dashboard" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: #f7dce8;">
            <i class="bi bi-bar-chart"></i> Dashboard
        </a>
        <a href="/admin/users" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: transparent;">
            <i class="bi bi-people"></i> Staff List
        </a>

        <div style="font-size: 10px; color: #a06080; margin-top: 20px; margin-bottom: 8px; letter-spacing: 1px; font-weight: 600;">ACCOUNT</div>
        <a href="/profile" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: transparent;">
            <i class="bi bi-person"></i> Profile
        </a>
    </div>

    {{-- ─── MAIN CONTENT ─────────────────────────────────────── --}}
    <div style="flex: 1; padding: 25px; overflow-y: auto;">

        {{-- TOP BAR --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h2 style="font-family: 'Cormorant Garamond', serif; color: #a04070; font-size: 2rem; margin: 0;">Admin Dashboard</h2>
                <div style="font-size: 12px; color: #c07090;">Welcome back, {{ session('user')['name'] }}</div>
            </div>

            <div style="display: flex; align-items: center; gap: 15px;">
                <span class="badge" style="background: #f3c9d9; color: #a04070; font-size: 11px; padding: 6px 12px; border-radius: 20px;">
                    <i class="bi bi-shield-check"></i> Admin
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
                    <div style="font-size: 12px; color: #c07090; font-weight: 600;">TOTAL STAFF</div>
                    <h3 style="color: #a04070; font-size: 2.5rem; margin: 10px 0;">{{ $users->count() }}</h3>
                    <div style="font-size: 12px; color: #c07090;">Registered members</div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div style="font-size: 12px; color: #c07090; font-weight: 600;">ADMINS</div>
                    <h3 style="color: #a04070; font-size: 2.5rem; margin: 10px 0;">{{ $users->where('role', 'admin')->count() }}</h3>
                    <div style="font-size: 12px; color: #c07090;">Administrator accounts</div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div style="font-size: 12px; color: #c07090; font-weight: 600;">STAFF MEMBERS</div>
                    <h3 style="color: #a04070; font-size: 2.5rem; margin: 10px 0;">{{ $users->where('role', 'staff')->count() }}</h3>
                    <div style="font-size: 12px; color: #c07090;">Regular staff</div>
                </div>
            </div>
        </div>

        {{-- STAFF TABLE --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header" style="background: #f7dce8; border: none; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                <strong style="color: #a04070;">ALL STAFF MEMBERS</strong>
                <a href="/admin/users" class="btn btn-sm text-white" style="background: #d4608a;">
                    <i class="bi bi-plus-lg"></i> Manage Staff
                </a>
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
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No staff members found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>{{-- end main content --}}
</div>
@endsection