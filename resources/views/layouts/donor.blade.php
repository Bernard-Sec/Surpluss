<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('donor.dashboard') }} - Surplus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success py-3 shadow-sm">
        <div class="container">
            
            {{-- LOGO --}}
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                Surplus
            </a>

            {{-- Mobile Toggle --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    
                    {{-- =============================
                        GUEST USER
                        ============================== --}}
                    @guest

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'fw-bold text-white' : '' }}"
                        href="{{ route('home') }}">
                        {{ __('nav.home') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('how') ? 'fw-bold text-white' : '' }}"
                        href="{{ route('how') }}">
                        {{ __('nav.how') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'fw-bold text-white' : '' }}"
                        href="{{ route('about') }}">
                        {{ __('nav.about') }}
                        </a>
                    </li>

                    <li class="nav-item ms-3">
                        <a class="btn btn-light text-success fw-bold px-3"
                        href="{{ route('login') }}">
                        {{ __('nav.login') }}
                        </a>
                    </li>
                    @endguest
                    
                    
                    {{-- =============================
                        AUTHENTICATED USER
                        ============================== --}}
                    @auth
                        
                        {{-- Role-based Dashboard --}}
                        @if(auth()->user()->role === 'donor')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('donor.dashboard') }}">
                                {{ __('nav.dashboard') }}
                            </a>
                        </li>
                        @elseif(auth()->user()->role === 'receiver')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('receiver.dashboard') }}">
                                {{ __('nav.dashboard') }}
                            </a>
                        </li>
                        @endif

                        {{-- Extra Donor-only Links --}}
                        @if(auth()->user()->role === 'donor')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('donor.profile') }}">
                                    {{ __('nav.profile') }}
                                </a>
                            </li>
                        @endif

                        {{-- Logout --}}
                        <li class="nav-item ms-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-danger px-3">{{ __('nav.logout') }}</button>
                            </form>
                        </li>

                    @endauth

                    {{-- LANGUAGE SWITCH --}}
                    <li class="nav-item ms-4 mt-1">
                        <x-language-switch />
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-2">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>