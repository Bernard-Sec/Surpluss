@extends('layouts.receiver')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9">
            
            {{-- Breadcrumb-like Back Button --}}
            <div class="mb-3">
                <a href="{{ route('receiver.dashboard') }}" class="text-decoration-none text-muted small hover-success">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                {{-- Hero Image --}}
                <div class="position-relative bg-light">
                    @if($foodItem->photo)
                        <img src="{{ asset($foodItem->photo) }}" 
                             class="w-100" 
                             style="height: 400px; object-fit: cover;" 
                             alt="{{ $foodItem->name }}"
                             onerror="this.onerror=null; this.src='https://placehold.co/800x400?text=No+Image';">
                    @else
                        <div class="d-flex align-items-center justify-content-center text-muted" style="height: 300px;">
                            <div class="text-center">
                                <i class="bi bi-camera-video-off fs-1 opacity-25"></i>
                                <p class="small mt-2">Tidak ada foto tersedia</p>
                            </div>
                        </div>
                    @endif

                    {{-- Status Overlay --}}
                    <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-dark text-white" 
                         style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                        <h2 class="fw-bold mb-0 text-white text-shadow">{{ $foodItem->name }}</h2>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="badge bg-success shadow-sm">{{ $foodItem->category->name ?? 'Umum' }}</span>
                            <small><i class="bi bi-person-fill"></i> {{ $foodItem->users->name }}</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Info Cards Grid (Updated to 4 items) --}}
                    <div class="row g-3 mb-4">
                        {{-- 1. STOK --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 h-100 border border-light">
                                <small class="text-success fw-bold text-uppercase" style="font-size: 0.7rem;">Stok</small>
                                <div class="fs-5 fw-bold text-dark">{{ $foodItem->quantity }} <span class="fs-6 text-muted fw-normal">Porsi</span></div>
                            </div>
                        </div>

                        {{-- 2. KADALUARSA --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 h-100 border border-light">
                                <small class="text-danger fw-bold text-uppercase" style="font-size: 0.7rem;">Kadaluarsa</small>
                                <div class="fs-5 fw-bold text-dark">{{ \Carbon\Carbon::parse($foodItem->expires_at)->format('d M') }}</div>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($foodItem->expires_at)->diffForHumans() }}</small>
                            </div>
                        </div>

                        {{-- 3. WAKTU PICKUP (NEW) --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 h-100 border border-light">
                                <small class="text-warning fw-bold text-uppercase" style="font-size: 0.7rem;">Waktu Pickup</small>
                                <div class="fw-bold text-dark"><i class="bi bi-clock me-1"></i>{{ $foodItem->pickup_time ?? '-' }}</div>
                            </div>
                        </div>

                        {{-- 4. LOKASI --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 h-100 border border-light">
                                <small class="text-primary fw-bold text-uppercase" style="font-size: 0.7rem;">Lokasi</small>
                                <div class="fw-bold text-dark small text-truncate"><i class="bi bi-geo-alt-fill me-1"></i>{{ $foodItem->pickup_location }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h5 class="fw-bold text-success mb-3">Deskripsi & Kondisi</h5>
                        <p class="text-secondary lh-lg mb-0">{{ $foodItem->description ?? 'Tidak ada deskripsi detail.' }}</p>
                    </div>

                    {{-- Claim Action Area --}}
                    <div class="card border-success border-opacity-25 bg-success bg-opacity-10 rounded-3 p-4">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <i class="bi bi-info-circle-fill text-success fs-4"></i>
                            <div>
                                <h6 class="fw-bold text-success mb-1">Sebelum Mengajukan Klaim</h6>
                                <p class="small text-secondary mb-0">Pastikan Anda dapat mengambil makanan di lokasi dan waktu yang ditentukan oleh donatur. Makanan yang tidak diambil merugikan orang lain yang membutuhkan.</p>
                            </div>
                        </div>

                        <form action="{{ route('receiver.claim.store', $foodItem->id) }}" method="POST">
                            @csrf
                            <label class="form-label fw-bold text-dark small">Jumlah Permintaan</label>
                            <div class="row g-2 align-items-center">
                                <div class="col-8 col-md-9">
                                    <div class="input-group input-group-lg">
                                        <button class="btn btn-outline-success" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                                        <input type="number" 
                                            name="quantity" 
                                            class="form-control text-center fw-bold border-success text-success" 
                                            value="1" 
                                            min="1" 
                                            max="{{ $foodItem->quantity }}" 
                                            required>
                                        <button class="btn btn-outline-success" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                                    </div>
                                </div>
                                <div class="col-4 col-md-3">
                                    <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm fw-bold">
                                        Klaim
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection