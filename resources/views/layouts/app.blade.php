<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WebSecService')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }

        .app-shell {
            min-height: calc(100vh - 56px);
        }

        .app-main {
            padding-top: 1.5rem;
            padding-bottom: 2rem;
        }

        .navbar-brand {
            letter-spacing: 0.02em;
        }

        .content-card {
            border: 0;
            box-shadow: 0 0.5rem 1.5rem rgba(15, 23, 42, 0.08);
        }

        .navbar {
            margin-top: 0;
            border-top: 0;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="{{ route('home') }}">WebSecService</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('lab1/*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Lab 1</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('lab1.even') }}">Even Numbers</a></li>
                            <li><a class="dropdown-item" href="{{ route('lab1.odd') }}">Odd Numbers</a></li>
                            <li><a class="dropdown-item" href="{{ route('lab1.prime') }}">Prime Numbers</a></li>
                            <li><a class="dropdown-item" href="{{ route('lab1.square') }}">Square Numbers</a></li>
                            <li><a class="dropdown-item" href="{{ route('lab1.multiplication') }}">Multiplication</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('lab2/*') || request()->is('lab1/products*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Lab 2</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('lab1.products.index') }}">Products CRUD</a></li>
                            <li><a class="dropdown-item" href="{{ route('lab2.products.index') }}">Products + Cart</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('lab3/*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Lab 3</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if (! $lab3User)
                                <li><a class="dropdown-item" href="{{ route('lab3.login') }}">Login to Lab 3</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('lab2.transcript') }}">Transcript</a></li>
                                <li><a class="dropdown-item" href="{{ route('lab2.gpa_simulator') }}">GPA Simulator</a></li>

                                @if ($lab3User->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('lab3.users.index') }}">Users CRUD</a></li>
                                @endif

                                @if (in_array($lab3User->role, ['admin', 'instructor'], true))
                                    <li><a class="dropdown-item" href="{{ route('lab3.grades.index') }}">Grades CRUD</a></li>
                                    <li><a class="dropdown-item" href="{{ route('lab3.questions.index') }}">Questions CRUD</a></li>
                                @endif

                                <li><a class="dropdown-item" href="{{ route('lab3.exam.start') }}">Start Exam</a></li>
                            @endif
                        </ul>
                    </li>

                    @if ($lab3User)
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <span class="badge text-bg-secondary me-2">{{ ucfirst($lab3User->role) }}</span>
                        </li>
                        <li class="nav-item mt-2 mt-lg-0">
                            <form action="{{ route('lab3.logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="app-shell">
        <main class="app-main">
            <div class="container">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any() && !View::hasSection('suppress_global_errors'))
                    <div class="alert alert-danger">
                        <h6 class="fw-semibold mb-2">Please fix the following issues:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
