@extends('layouts.receiver')

@section('content')

<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        transition: all 0.3s ease;
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>

{{-- HEADER SECTION (MATCHING DONOR STYLE) --}}
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h2 class="fw-bold text-success">Halo, {{ Auth::user()->name }}! 👋</h2>
        <p class="text-muted">Temukan makanan gratis di sekitarmu hari ini.</p>
    </div>
    {{-- Optional: Stat Cards if needed, otherwise kept simple --}}
</div>

{{-- SEARCH & FILTER CARD --}}
<div class="card border-0 shadow-sm mb-5 rounded-4">
    <div class="card-body p-4">
        <form action="{{ route('receiver.dashboard') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-bold text-success small">Cari Nama/Menu</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-start-0 ps-0" 
                               placeholder="Nasi goreng, Roti..." value="{{ request('search') }}">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label fw-bold text-success small">Kategori</label>
                    <select name="category_id" class="form-select bg-light">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold text-success small">Lokasi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" name="location" class="form-control bg-light border-start-0 ps-0" 
                               placeholder="Jakarta..." value="{{ request('location') }}">
                    </div>
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100 shadow-sm"><i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- FOOD GRID --}}
<div class="row g-4">
    @forelse($foods as $food)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
            {{-- Image Handling --}}
            <div class="position-relative">
                @if($food->photo)
                    <img src="{{ asset($food->photo) }}" class="card-img-top" alt="{{ $food->name }}" 
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