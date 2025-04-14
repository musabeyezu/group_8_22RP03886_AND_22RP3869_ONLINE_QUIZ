<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Online Quiz System</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #4338ca;
            --secondary-color: #64748b;
            --success-color: #22c55e;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --light-bg: #f8fafc;
            --dark-bg: #1e293b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--light-bg) 0%, #eef2ff 100%);
            min-height: 100vh;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,.04);
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--primary-color);
        }

        .nav-link {
            color: var(--secondary-color);
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,.1), 0 2px 4px -1px rgba(0,0,0,.06);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,.05);
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem;
        }

        .card-header h4 {
            color: var(--dark-bg);
            font-weight: 600;
            margin: 0;
        }

        .card-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79,70,229,.1);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-primary:focus {
            box-shadow: 0 0 0 4px rgba(79,70,229,.25);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.875rem;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.5rem;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.2s;
        }

        a:hover {
            color: var(--primary-dark);
        }

        .auth-wrapper {
            display: flex;
            align-items: center;
            min-height: calc(100vh - 76px);
            padding: 2rem 0;
        }

        .auth-card {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .auth-card .card-header {
            text-align: center;
            padding: 2rem 1.5rem;
        }

        .auth-card .card-header h4 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .auth-card .card-header p {
            color: var(--secondary-color);
            margin: 0;
        }

        .auth-brand {
            margin-bottom: 2rem;
            text-align: center;
        }

        .auth-brand h1 {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 2rem;
            margin: 0;
        }

        .auth-brand p {
            color: var(--secondary-color);
            margin: 0.5rem 0 0;
        }
    </style>

    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-graduation-cap me-2"></i>
                Online Quiz
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth('admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn nav-link border-0 bg-transparent">Logout</button>
                            </form>
                        </li>
                    @endauth
                    @auth('student')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('student.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn nav-link border-0 bg-transparent">Logout</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    @yield('scripts')
</body>
</html>
