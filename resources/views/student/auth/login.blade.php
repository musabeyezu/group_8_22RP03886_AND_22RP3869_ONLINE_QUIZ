@extends('layouts.app')

@section('title', 'Student Login')

@section('content')
<div class="auth-wrapper">
    <div class="container">
        <div class="auth-card">
            <div class="auth-brand">
                <h1><i class="fas fa-graduation-cap"></i> Online Quiz</h1>
                <p>Welcome back, student! Please login to continue.</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Student Login</h4>
                    <p>Access your learning dashboard</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('student.login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email Address
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" 
                                placeholder="Enter your email" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password" 
                                placeholder="Enter your password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    <i class="fas fa-clock me-2"></i>Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Don't have an account? 
                                <a href="{{ route('student.register') }}" class="fw-bold">
                                    <i class="fas fa-user-plus me-1"></i>Register here
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
