<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WebSecService')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body {
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
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="{{ url('/') }}">WebSecService</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->path() === '/' ? 'active' : '' }}" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('hlow') ? 'active' : '' }}" href="{{ url('/hlow') }}">Status</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('even-numbers') ? 'active' : '' }}" href="{{ url('/even-numbers') }}">Even</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('odd-numbers') ? 'active' : '' }}" href="{{ url('/odd-numbers') }}">Odd</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('prime-numbers') ? 'active' : '' }}" href="{{ url('/prime-numbers') }}">Prime</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('square-numbers') ? 'active' : '' }}" href="{{ url('/square-numbers') }}">Square</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('multiplication*') ? 'active' : '' }}" href="{{ url('/multiplication') }}">Multiplication</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products_list') }}">Products</a></li>
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
