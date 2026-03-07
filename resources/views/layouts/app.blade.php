<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Web Service')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/even-numbers">Even Numbers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/odd-numbers">Odd Numbers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/prime-numbers">Prime Numbers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/square-numbers">Square Numbers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/multiplication">Multiplication Table</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/products">Products</a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
