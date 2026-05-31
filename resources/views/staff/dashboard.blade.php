@extends('layouts.main')

@section('content')
<div style="display: flex; min-height: 100vh;">

    {{-- ─── SIDEBAR ─────────────────────────────────────────── --}}
    <div style="width: 230px; background: #f3c9d9; padding: 20px; overflow-y: auto; flex-shrink: 0;">
        <div style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; color: #a04070; margin-bottom: 30px; font-weight: 600;">
            Sakura
        </div>

        <div style="font-size: 10px; color: #a06080; margin-top: 15px; margin-bottom: 8px; letter-spacing: 1px; font-weight: 600;">MAIN</div>
        <a href="/profile" class="btn btn-sm w-100 text-start mb-2" style="color: #a04070; background: #f7dce8;">
            <i class="bi bi-house"></i> Dashboard
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

        {{-- WELCOME CARD --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body" style="padding: 30px; text-align: center;">
                <h3 style="color: #a04070; margin-bottom: 15px;">Welcome to Sakura!</h3>
                <p style="color: #c07090; margin-bottom: 0;">You are logged in as <strong>{{ session('user')['name'] }}</strong></p>
            </div>
        </div>

        {{-- QUICK LINKS --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center" style="padding: 20px;">
                    <i class="bi bi-person" style="font-size: 2rem; color: #d4608a;"></i>
                    <h5 style="color: #a04070; margin-top: 10px;">View Profile</h5>
                    <a href="/profile" class="btn btn-sm mt-2" style="background: #f3c9d9; color: #a04070;">
                        Go to Profile
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body text-center" style="padding: 20px;">
                    <i class="bi bi-box-arrow-right" style="font-size: 2rem; color: #d4608a;"></i>
                    <h5 style="color: #a04070; margin-top: 10px;">Logout</h5>
                    <form action="/logout" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm mt-2 btn-danger">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>{{-- end main content --}}
</div>
@endsection