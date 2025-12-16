@extends('layouts.receiver')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9">
            
            {{-- Breadcrumb-like Back Button --}}
            <div class="mb-3">
                <a href="{{ route('receiver.dashboard') }}" class="text-decoration-none text-muted small hover-success">
                    <i class="bi bi-arrow-left me-1"></i> {{ __('receiver.back_dashboard') }}
                </a>
            </div>

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                {{-- Hero Image --}}
                <div class="position-relative bg-light">
                    @if($foodItem->photo)
                        <img src="{{ asset($foodItem->photo_url) }}" 
                             class="w-100" 
                             style="height: 400px; object-fit: cover;" 
                             alt="{{ $foodItem->name }}"
                             onerror="this.onerror=null; this.src='https://placehold.co/800x400?text=No+Image';">
                    @else
                        <div class="d-flex align-items-center justify-content-center text-muted" style="height: 300px;">
                            <div class="text-center">
                                <i class="bi bi-camera-video-off fs-1 opacity-25"></i>
                                <p class="small mt-2">{{ __('receiver.no_photo') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Status Overlay --}}
                    <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-dark text-white" 
                         style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                        <h2 class="fw-bold mb-0 text-white text-shadow">{{ $foodItem->name }}</h2>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="badge bg-success shadow-sm">
                                {{ $foodItem->category ? __('categories.' . \Illuminate\Support\Str::slug($foodItem->category->name)) : __('categories.general') }}
                            </span>
                            <small><i class="bi bi-person-fill"></i> {{ $foodItem->users->name }}</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Info Cards Grid --}}
                    <div class="row g-3 mb-4">
                        
                        {{-- 1. STOK --}}
                        <div class="col-4 col-md-4">
                            <div class="p-3 rounded-4 h-100 border border-success border-opacity-25 bg-success bg-opacity-10 position-relative overflow-hidden">
                                <i class="bi bi-box-seam position-absolute top-0 end-0 display-4 text-success opacity-25" style="transform: translate(10%, -10%);"></i>
                                <div class="position-relative z-1">
                                    <small class="text-success fw-bold text-uppercase d-block mb-1" style="font-size: 0.65rem;">{{ __('receiver.label_stock') }}</small>
                                    <div class="d-flex align-items-baseline">
                                        <span class="fs-3 fw-bold text-success me-1">{{ $foodItem->quantity }}</span>
                                        <span class="small text-success fw-semibold">{{ __('receiver.unit') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. KADALUARSA --}}
                        <div class="col-4 col-md-4">
                            <div class="p-3 rounded-4 h-100 border border-danger border-opacity-25 bg-danger bg-opacity-10 position-relative overflow-hidden">
                                <i class="bi bi-hourglass-split position-absolute top-0 end-0 display-4 text-danger opacity-25" style="transform: translate(10%, -10%);"></i>
                                <div class="position-relative z-1">
                                    <small class="text-danger fw-bold text-uppercase d-block mb-1" style="font-size: 0.65rem;">{{ __('receiver.label_expired') }}</small>
                                    <div class="fs-6 fw-bold text-danger lh-1 mb-2">
                                        {{ \Carbon\Carbon::parse($foodItem->expires_at)->format('d M') }}
                                    </div>
                                    <span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-25 rounded-pill" style="font-size: 0.6rem;">
                                        {{ \Carbon\Carbon::parse($foodItem->expires_at)->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- 3. WAKTU PICKUP --}}
                        <div class="col-4 col-md-4">
                            <div class="p-3 rounded-4 h-100 border border-warning border-opacity-50 bg-warning bg-opacity-10 position-relative overflow-hidden">
                                <i class="bi bi-alarm position-absolute top-0 end-0 display-4 text-warning opacity-25" style="transform: translate(10%, -10%);"></i>
                                <div class="position-relative z-1">
                                    <small class="text-warning text-opacity-75 fw-bold text-uppercase d-block mb-1" style="font-size: 0.65rem;">{{ __('receiver.label_pickup') }}</small>
                                    <div class="fs-6 fw-bold text-dark lh-sm">
                                        {{ $foodItem->pickup_time ?? '-' }} <span class="small text-muted fw-normal">WIB</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 4. LOKASI (Full Width) --}}
                        <div class="col-12">
                            <div class="p-3 rounded-4 h-100 border border-primary border-opacity-25 bg-primary bg-opacity-10 position-relative overflow-hidden">
                                <i class="bi bi-geo-alt position-absolute top-0 end-0 display-4 text-primary opacity-25" style="transform: translate(10%, -10%);"></i>
                                <div class="position-relative z-1">
                                    <small class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 0.65rem;">{{ __('receiver.label_loc_pickup') }}</small>
                                    <div class="fw-bold text-dark mb-2 small lh-sm">
                                        {{ $foodItem->pickup_location }}
                                    </div>
                                    <a href="https://maps.google.com/?q={{ urlencode($foodItem->pickup_location) }}" target="_blank" class="text-decoration-none text-primary fw-bold" style="font-size: 0.7rem;">
                                        <i class="bi bi-map-fill me-1"></i>{{ __('receiver.link_map') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mb-5">
                        <h5 class="fw-bold text-success mb-3">{{ __('receiver.title_desc') }}</h5>
                        <p class="text-secondary lh-lg mb-0">{{ $foodItem->description ?? __('receiver.no_desc') }}</p>
                    </div>

                    {{-- Claim Action Area --}}
                    <div class="card border-success border-opacity-25 bg-success bg-opacity-10 rounded-3 p-4">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <i class="bi bi-info-circle-fill text-success fs-4"></i>
                            <div>
                                <h6 class="fw-bold text-success mb-1">{{ __('receiver.title_warning') }}</h6>
                                <p class="small text-secondary mb-0">{{ __('receiver.text_warning') }}</p>
                            </div>
                        </div>

                        <form action="{{ route('receiver.claim.store', $foodItem->id) }}" method="POST">
                            @csrf
                            <label class="form-label fw-bold text-dark small">{{ __('receiver.label_req_qty') }}</label>
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
                                        {{ __('receiver.btn_claim') }}
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