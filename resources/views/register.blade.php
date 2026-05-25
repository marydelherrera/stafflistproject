@extends('layouts.main')

@section('content')
<div style="background: linear-gradient(135deg, #f3c9d9 0%, #fce8f0 100%); min-height: 100vh; display: flex; align-items: center;">
    <div style="width: 100%; max-width: 450px; margin: 0 auto;">
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <h2 class="text-center mb-4" style="color: #a04070; font-weight: 600;">Create Account</h2>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="/register">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" style="color: #a04070;">Full Name</label>
                        <input type="text" name="fullname"
                               class="form-control @error('fullname') is-invalid @enderror"
                               placeholder="Enter your full name"
                               value="{{ old('fullname') }}" required>
                        @error('fullname')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: #a04070;">Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Enter your email"
                               value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: #a04070;">Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Enter password" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" style="color: #a04070;">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-control"
                               placeholder="Confirm password" required>
                    </div>

                    <button type="submit" class="btn w-100 text-white" style="background: #d4608a; font-weight: 600;">
                        Register
                    </button>
                </form>

                <p class="text-center mt-4">
                    Already have an account?
                    <a href="/login" style="color: #d4608a; text-decoration: none; font-weight: 600;">Login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection