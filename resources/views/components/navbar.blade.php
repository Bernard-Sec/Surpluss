<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
            
        {{-- Logo --}}
        <a class="navbar-brand fw-bold text-success" href="{{ route('home') }}">
            Surplus
        </a>

        {{-- Mobile toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">

                {{-- ====================================
                        GUEST MENU
                ===================================== --}}
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>

                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li> -->

                    <li class="nav-item ms-2">
                        <a class="btn btn-success px-3" href="{{ route('login') }}">Login</a>
                    </li>
                @endguest


                {{-- ====================================
                        AUTHENTICATED USER MENU
                ===================================== --}}
                @auth

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('how') }}">How it Works</a>
                    </li>

                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li> -->

                    <li class="nav-item ms-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger px-3">Logout</button>
                        </form>

                    </li>

                @endauth

                    <li class="nav-item ms-4 mt-1">
                        <x-language-switch />
                    </li>
            </ul>
        </div>
    </div>
</nav>
