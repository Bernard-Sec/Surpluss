@extends('layouts.receiver')

@section('content')

<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        transition: all 0.3s ease;
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }

    .pagination .page-link {
        color: #198754; /* Teks Hijau */
        border: 1px solid #dee2e6;
        margin: 0 3px;
        border-radius: 50% !important; /* Bulat */
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .pagination .page-link:hover {
        background-color: #e9f7ef; /* Hijau muda saat hover */
        color: #157347;
        border-color: #198754;
    }

    .pagination .page-item.active .page-link {
        background-color: #198754 !important; /* Hijau solid saat aktif */
        border-color: #198754 !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(25, 135, 84, 0.3);
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border-color: #dee2e6;
        opacity: 0.5;
    }

    .transition-all { transition: all 0.2s ease-in-out; }
    .hover-bg-success:hover { background-color: #198754 !important; color: white !important; border-color: #198754 !important; }
    .letter-spacing-1 { letter-spacing: 0.5px; }
</style>

{{-- HEADER SECTION --}}
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h2 class="fw-bold text-success">Halo, {{ Auth::user()->name }}! 👋</h2>
        <p class="text-muted">Temukan makanan layak konsumsi di sekitarmu hari ini.</p>
    </div>
    {{-- Optional: Stat Cards if needed, otherwise kept simple --}}
</div>

{{-- SEARCH & FILTER SECTION --}}
<div class="card border-0 shadow-lg mb-5 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fcf9 100%);">
    <div class="card-body p-4 p-md-4">
        <form action="{{ route('receiver.dashboard') }}" method="GET">
            <div class="row g-3 align-items-end">
                
                {{-- 1. Input Pencarian --}}
                <div class="col-md-5">
                    <label class="form-label fw-bold text-success small text-uppercase letter-spacing-1">
                        <i class="bi bi-search me-1"></i> Apa yang kamu cari?
                    </label>
                    <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                        <span class="input-group-text bg-white border-0 ps-3 text-muted"><i class="bi bi-egg-fried"></i></span>
                        <input type="text" name="search" class="form-control border-0 bg-white fs-6 py-3" 
                               placeholder="Cth: Nasi Goreng, Roti..." 
                               value="{{ request('search') }}"
                               style="box-shadow: none;">
                    </div>
                </div>
                
                {{-- 2. Dropdown Kategori --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold text-success small text-uppercase letter-spacing-1">
                        <i class="bi bi-grid me-1"></i> Kategori
                    </label>
                    <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                        <span class="input-group-text bg-white border-0 ps-3 text-muted"><i class="bi bi-list-task"></i></span>
                        <select name="category_id" class="form-select border-0 bg-white fs-6 py-3" style="box-shadow: none; cursor: pointer;">
                            <option value="">Semua</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- 3. Input Lokasi --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold text-success small text-uppercase letter-spacing-1">
                        <i class="bi bi-geo-alt me-1"></i> Lokasi
                    </label>
                    <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                        <span class="input-group-text bg-white border-0 ps-3 text-danger"><i class="bi bi-geo-alt-fill"></i></span>
                        <input type="text" name="location" class="form-control border-0 bg-white fs-6 py-3" 
                               placeholder="Jakarta..." 
                               value="{{ request('location') }}"
                               style="box-shadow: none;">
                    </div>
                </div>

                {{-- 4. Tombol Submit --}}
                <div class="col-md-1">
                    <button type="submit" class="btn btn-success btn-lg w-100 shadow-md rounded-3 py-3" data-bs-toggle="tooltip" title="Cari Makanan">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            
            {{-- Quick Filter Tags  --}}
            <div class="mt-3 d-flex gap-2 align-items-center overflow-auto pb-2" style="scrollbar-width: none;">
                <span class="small text-muted fw-semibold me-1 text-nowrap">Populer:</span>
                <a href="{{ route('receiver.dashboard', ['search' => 'Nasi']) }}" class="badge bg-white text-secondary border shadow-sm text-decoration-none rounded-pill px-3 py-2 fw-normal hover-bg-success hover-text-white transition-all">
                    🍚 Nasi
                </a>
                <a href="{{ route('receiver.dashboard', ['search' => 'Roti']) }}" class="badge bg-white text-secondary border shadow-sm text-decoration-none rounded-pill px-3 py-2 fw-normal hover-bg-success hover-text-white transition-all">
                    🍞 Roti
                </a>
                <a href="{{ route('receiver.dashboard', ['search' => 'Sayur']) }}" class="badge bg-white text-secondary border shadow-sm text-decoration-none rounded-pill px-3 py-2 fw-normal hover-bg-success hover-text-white transition-all">
                    🥦 Sayur
                </a>
                @if(request()->hasAny(['search', 'category_id', 'location']))
                    <a href="{{ route('receiver.dashboard') }}" class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 text-decoration-none rounded-pill px-3 py-2 fw-bold ms-auto">
                        <i class="bi bi-x-circle me-1"></i> Reset Filter
                    </a>
                @endif
            </div>

        </form>
    </div>
</div>

<style>
    /* Tambahan CSS kecil untuk efek hover badge */
    .transition-all { transition: all 0.2s ease-in-out; }
    .hover-bg-success:hover { background-color: #198754 !important; color: white !important; border-color: #198754 !important; }
    .letter-spacing-1 { letter-spacing: 0.5px; }
</style>

{{-- FOOD GRID --}}
<div class="row g-4">
    @forelse($foods as $food)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
            {{-- Image Handling --}}
            <div class="position-relative">
                @if($food->photo)
                    <img src="{{ asset($food->photo_url) }}" class="card-img-top" alt="{{ $food->name }}" 
                         style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center text-muted" 
                         style="height: 200px;">
                        <i class="bi bi-camera-video-off fs-1 opacity-25"></i>
                    </div>
                @endif
                
                {{-- Category Badge --}}
                <span class="position-absolute top-0 end-0 m-3 badge bg-white text-success shadow-sm fw-bold border">
                    {{ $food->category->name ?? 'Umum' }}
                </span>
            </div>

            <div class="card-body p-4">
                <h5 class="card-title fw-bold text-dark mb-1">{{ $food->name }}</h5>
                <p class="text-muted small mb-3">
                    <i class="bi bi-person-circle me-1"></i> {{ $food->users->name ?? 'Donatur' }}
                </p>

                <p class="card-text text-secondary small mb-3">
                    {{ Str::limit($food->description, 60) }}
                </p>

                <div class="d-flex align-items-center text-muted small mb-2">
                    <i class="bi bi-geo-alt-fill text-danger me-2"></i> 
                    <span class="text-truncate">{{ Str::limit($food->pickup_location, 30) }}</span>
                </div>
                
                <div class="d-flex align-items-center text-muted small">
                    <i class="bi bi-clock-history text-warning me-2"></i>
                    <span>Exp: {{ \Carbon\Carbon::parse($food->expires_at)->format('d M, H:i') }}</span>
                </div>
            </div>
            
            <div class="card-footer bg-white border-top-0 p-4 pt-0">
                <div class="d-grid">
                    <a href="{{ route('receiver.food.show', $food->id) }}" class="btn btn-outline-success fw-bold">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="opacity-50 mb-3">
            <i class="bi bi-inbox fs-1 text-muted"></i>
        </div>
        <h5 class="fw-bold text-muted">Belum ada makanan tersedia.</h5>
        <p class="text-secondary">Coba ubah filter pencarianmu atau kembali lagi nanti.</p>
        <a href="{{ route('receiver.dashboard') }}" class="btn btn-sm btn-outline-success">Reset Filter</a>
    </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-5">
    {{ $foods->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

@endsection