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

                    {{-- Extra Donor-only Links --}}
                    @if(auth()->user()->role === 'donor')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('donor.requests.index') }}">
                                Permintaan Masuk
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('donor.profile') }}">
                                Profil
                            </a>
                        </li>
                    @endif

                    {{-- Logout --}}
                    <li class="nav-item ms-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger px-3">Logout</button>
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
