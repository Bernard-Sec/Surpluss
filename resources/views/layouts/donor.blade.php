<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard - Surplus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .navbar-custom {
            background-color: #198754;
            background: linear-gradient(135deg, #198754 0%, #157347 100%);
            box-shadow: 0 4px 20px rgba(25, 135, 84, 0.15);
        }
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.85) !important;
        }
        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            transform: translateY(-1px);
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #ffffff;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after, .nav-link.active::after {
            width: 80%;
        }
        .navbar-brand {
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 sticky-top">
        <div class="container">
            
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2 fs-4" href="{{ route('home') }}">
                <i class="bi bi-flower1"></i> Surplus
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-center gap-2">

                    @guest
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('how') ? 'active' : '' }}" href="{{ route('how') }}">
                                How It Works
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                                About Us
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-light text-success fw-bold px-4 rounded-pill shadow-sm" href="{{ route('login') }}">
                                Login
                            </a>
                        </li>
                    @endguest
                    
                    @auth
                        @if(auth()->user()->role === 'donor')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('donor.dashboard') ? 'active' : '' }}" href="{{ route('donor.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                        @elseif(auth()->user()->role === 'receiver')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('receiver.dashboard') ? 'active' : '' }}" href="{{ route('receiver.dashboard') }}">
                                    Home
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->role === 'donor')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('donor.profile') ? 'active' : '' }}" href="{{ route('donor.profile') }}">
                                    Profile
                                </a>
                            </li>
                        @endif

                        <li class="nav-item ms-lg-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-danger px-4 rounded-pill shadow-sm bg-gradient border-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>

                    @endauth

                    <li class="nav-item ms-lg-3">
                        <div class="bg-white bg-opacity-25 rounded-pill px-2 py-1">
                             <x-language-switch />
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </nav>


    <div class="container mt-5 pt-2 pb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>