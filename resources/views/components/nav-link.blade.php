<div class="offcanvas-body">

    <a href="{{ route('home') }}" class="nav-link">Beranda</a>
    <a href="{{ route('about') }}" class="nav-link">Tentang Kami</a>
    <a href="{{ route('how') }}" class="nav-link">Cara Kerja</a>

    @guest
        <a href="{{ route('login') }}" class="btn btn-outline-success w-100 mt-3">Masuk</a>
        <a href="{{ route('register') }}" class="btn btn-success w-100 mt-2">Daftar</a>
    @endguest

    @auth
        <a href="{{ route('dashboard') }}" class="nav-link mt-3">Dasbor</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger w-100 mt-3">Keluar</button>
        </form>
    @endauth

</div>