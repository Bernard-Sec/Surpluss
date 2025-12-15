<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receiver - Surplus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
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

                    <!-- {{-- =============================
                        UNIVERSAL LINKS (GUEST + AUTH)
                    ============================== --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'fw-bold text-white' : '' }}"
                        href="{{ route('home') }}">
                        Home
                        </a>
                    </li> -->

                    
                    
                    {{-- =============================
                        GUEST USER
                        ============================== --}}
                        @guest

                        <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'fw-bold text-white' : '' }}"
                        href="{{ route('home') }}">
                        Beranda
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('how') ? 'fw-bold text-white' : '' }}"
                        href="{{ route('how') }}">
                        Cara Kerja
                        </a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'fw-bold text-white' : '' }}"
                            href="{{ route('about') }}">
                            Tentang Kami
                            </a>
                        </li>
        


                        <li class="nav-item ms-3">
                            <a class="btn btn-light text-success fw-bold px-3"
                            href="{{ route('login') }}">
                            Masuk
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
                                Dasbor
                            </a>
                        </li>
                        @elseif(auth()->user()->role === 'receiver')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('receiver.dashboard') }}">
                                Dasbor
                            </a>
                        </li>
                        @endif
                        {{-- <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('how') ? 'fw-bold text-white' : '' }}"
                            href="{{ route('how') }}">
                            Cara Kerja
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'fw-bold text-white' : '' }}"
                            href="{{ route('about') }}">
                            Tentang Kami
                            </a>
                        </li> --}}
                        <!-- 55555 -->
                        {{-- Extra Donor-only Links --}}
                        @if(auth()->user()->role === 'receiver')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('receiver.profile') ? 'active' : '' }}" 
                                href="{{ route('receiver.profile') }}">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('receiver.history') ? 'active' : '' }}" 
                                href="{{ route('receiver.history') }}">Riwayat</a>
                            </li>
                        @endif
                        <!-- 55555 -->
                        {{-- Logout --}}
                        <li class="nav-item ms-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-danger px-3">Keluar</button>
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
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>