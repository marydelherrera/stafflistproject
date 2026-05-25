@extends('layouts.main')

@section('content')
<div style="background: linear-gradient(135deg, #f3c9d9 0%, #fce8f0 100%); min-height: 100vh; display: flex; align-items: center;">
    <div style="width: 100%; max-width: 450px; margin: 0 auto;">
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <h2 class="text-center mb-4" style="color: #a04070; font-weight: 600;">Login</h2>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="/login">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label" style="color: #a04070;">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               placeholder="Enter your email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" style="color: #a04070;">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Enter your password" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn w-100 text-white" style="background: #d4608a; font-weight: 600;">
                        Login
                    </button>
                </form>

                <p class="text-center mt-4">
                    Don't have an account? <a href="/register" style="color: #d4608a; text-decoration: none; font-weight: 600;">Register</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection