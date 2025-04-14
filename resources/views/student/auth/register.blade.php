@extends('layouts.app')

@section('title', 'Student Registration')

@section('content')
<div class="auth-wrapper">
    <div class="container">
        <div class="auth-card">
            <div class="auth-brand">
                <h1><i class="fas fa-graduation-cap"></i> Online Quiz</h1>
                <p>Create your student account to get started!</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Student Registration</h4>
                    <p>Join our learning community</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('student.register') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="fullname" class="form-label">
                                <i class="fas fa-user me-2"></i>Full Name
                            </label>
                            <input type="text" class="form-control @error('fullname') is-invalid @enderror" 
                                id="fullname" name="fullname" value="{{ old('fullname') }}" 
                                placeholder="Enter your full name" required autofocus>
                            @error('fullname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email Address
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" 
                                placeholder="Enter your email" required>
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
                                placeholder="Create a strong password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-2"></i>Confirm Password
                            </label>
                            <input type="password" class="form-control" 
                                id="password_confirmation" name="password_confirmation" 
                                placeholder="Confirm your password" required>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Already have an account? 
                                <a href="{{ route('student.login') }}" class="fw-bold">
                                    <i class="fas fa-sign-in-alt me-1"></i>Login here
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
