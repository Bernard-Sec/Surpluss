@extends('layouts.receiver')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9">
            
            {{-- Breadcrumb Back Button --}}
            <div class="mb-3">
                <a href="{{ route('receiver.history') }}" class="text-decoration-none text-muted small hover-success">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
                </a>
            </div>

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                {{-- Hero Image --}}
                <div class="position-relative bg-light">
                    {{-- Logic Gambar --}}
                    @if($claim->fooditems && $claim->fooditems->photo)
                        <img src="{{ asset($claim->fooditems->photo_url) }}" 
                             class="w-100" 
                             style="height: 400px; object-fit: cover;" 
                             alt="{{ $claim->fooditems->name }}"
                             onerror="this.onerror=null; this.src='https://placehold.co/800x400?text=No+Image';">
                    @else
                        <div class="d-flex align-items-center justify-content-center text-muted" style="height: 300px;">
                            <div class="text-center">
                                <i class="bi bi-camera-video-off fs-1 opacity-25"></i>
                                <p class="small mt-2">Tidak ada foto tersedia</p>
                            </div>
                        </div>
                    @endif

                    {{-- Overlay Judul --}}
                    <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-dark text-white" 
                         style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                        <h2 class="fw-bold mb-0 text-white text-shadow">{{ $claim->fooditems->name ?? 'Item Dihapus' }}</h2>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="badge bg-success shadow-sm">{{ $claim->fooditems->category->name ?? 'Umum' }}</span>
                            <small><i class="bi bi-person-fill"></i> {{ $claim->fooditems->users->name ?? 'Donatur' }}</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Info Cards Grid --}}
                    <div class="row g-3 mb-4">
                        
                        {{-- === ROW 1 (3 Kolom) === --}}

                        {{-- 1. JUMLAH REQUEST (Green) --}}
                        <div class="col-4 col-md-4">
                            <div class="p-3 rounded-4 h-100 border border-success border-opacity-25 bg-success bg-opacity-10 position-relative overflow-hidden">
                                {{-- Icon: Basket/Bag --}}
                                <i class="bi bi-basket2 position-absolute top-0 end-0 display-4 text-success opacity-25" style="transform: translate(10%, -10%);"></i>
                                <div class="position-relative z-1">
                                    <small class="text-success fw-bold text-uppercase d-block mb-1" style="font-size: 0.65rem;">Jumlah Request</small>
                                    <div class="d-flex align-items-baseline">
                                        <span class="fs-3 fw-bold text-success me-1">{{ $claim->quantity }}</span>
                                        <span class="small text-success fw-semibold">Porsi</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. TANGGAL REQUEST (Secondary/Gray - History) --}}
                        <div class="col-4 col-md-4">
                            <div class="p-3 rounded-4 h-100 border border-secondary border-opacity-25 bg-secondary bg-opacity-10 position-relative overflow-hidden">
                                {{-- Icon: Calendar Check --}}
                                <i class="bi bi-calendar-check position-absolute top-0 end-0 display-4 text-secondary opacity-25" style="transform: translate(10%, -10%);"></i>
                                <div class="position-relative z-1">
                                    <small class="text-secondary fw-bold text-uppercase d-block mb-1" style="font-size: 0.65rem;">Waktu Request</small>
                                    <div class="fs-6 fw-bold text-secondary lh-1 mb-2">
                                        {{ $claim->created_at->format('d M') }}
                                    </div>
                                    <span class="badge bg-secondary bg-opacity-25 text-secondary border border-secondary border-opacity-25 rounded-pill" style="font-size: 0.6rem;">
                                        {{ $claim->created_at->format('H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- 3. WAKTU PICKUP (Yellow) --}}
                        <div class="col-4 col-md-4">
                            <div class="p-3 rounded-4 h-100 border border-warning border-opacity-50 bg-warning bg-opacity-10 position-relative overflow-hidden">
                                {{-- Icon: Alarm --}}
                                <i class="bi bi-alarm position-absolute top-0 end-0 display-4 text-warning opacity-25" style="transform: translate(10%, -10%);"></i>
                                <div class="position-relative z-1">
                                    <small class="text-warning text-opacity-75 fw-bold text-uppercase d-block mb-1" style="font-size: 0.65rem;">Pickup</small>
                                    <div class="fs-6 fw-bold text-dark lh-sm">
                                        {{ $claim->fooditems->pickup_time ?? '-' }} <span class="small text-muted fw-normal">WIB</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- === ROW 2 (Full Width) === --}}

                        {{-- 4. LOKASI (Blue - Full Width) --}}
                        <div class="col-12">
                            <div class="p-3 rounded-4 h-100 border border-primary border-opacity-25 bg-primary bg-opacity-10 position-relative overflow-hidden">
                                {{-- Icon: Map --}}
                                <i class="bi bi-geo-alt position-absolute top-0 end-0 display-4 text-primary opacity-25" style="transform: translate(10%, -10%);"></i>
                                <div class="position-relative z-1">
                                    <small class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 0.65rem;">Lokasi Pengambilan</small>
                                    <div class="fw-bold text-dark mb-2 small lh-sm">
                                        {{ $claim->fooditems->pickup_location ?? '-' }}
                                    </div>
                                    @if($claim->fooditems->pickup_location)
                                        <a href="https://maps.google.com/?q={{ urlencode($claim->fooditems->pickup_location) }}" target="_blank" class="text-decoration-none text-primary fw-bold" style="font-size: 0.7rem;">
                                            <i class="bi bi-map-fill me-1"></i>Buka Peta
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mb-5">
                        <h5 class="fw-bold text-success mb-3">Deskripsi & Kondisi</h5>
                        <p class="text-secondary lh-lg mb-0">{{ $claim->fooditems->description ?? 'Tidak ada deskripsi detail.' }}</p>
                    </div>

                    {{-- STATUS TRANSAKSI SECTION --}}
                    <div class="card border-0 shadow-sm rounded-3 p-4 {{ $claim->status == 'cancelled' || $claim->status == 'rejected' ? 'bg-danger bg-opacity-10' : ($claim->status == 'completed' ? 'bg-success bg-opacity-10' : 'bg-warning bg-opacity-10') }}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0 text-dark">Status Transaksi</h6>
                            
                            {{-- LOGIC BADGE STATUS --}}
                            @if($claim->status == 'pending')
                                <span class="badge bg-warning text-dark border border-warning px-3 py-2">Pending / Menunggu</span>
                            @elseif($claim->status == 'approved')
                                <span class="badge bg-success px-3 py-2">Disetujui & Siap Ambil</span>
                            @elseif($claim->status == 'completed')
                                <span class="badge bg-primary px-3 py-2">Selesai</span>
                            @elseif($claim->status == 'cancelled')
                                <span class="badge bg-secondary px-3 py-2">Dibatalkan</span>
                            @else
                                <span class="badge bg-danger px-3 py-2">Ditolak</span>
                            @endif
                        </div>

                        {{-- KODE VERIFIKASI (Hanya jika disetujui) --}}
                        @if($claim->status == 'approved')
                            <div class="text-center bg-white rounded-3 p-3 border border-success border-opacity-25 mt-2 shadow-sm">
                                <small class="text-muted text-uppercase d-block mb-1">Tunjukkan Kode Ini ke Donatur</small>
                                <div class="fs-1 fw-bold text-success letter-spacing-2 font-monospace">{{ $claim->verification_code }}</div>
                                <div class="small text-muted mt-1"><i class="bi bi-info-circle me-1"></i> Donatur akan memverifikasi kode ini saat pengambilan.</div>
                            </div>
                        @endif

                        {{-- ALASAN PENOLAKAN --}}
                        @if(($claim->status == 'rejected' || $claim->status == 'cancelled') && $claim->rejection_reason)
                            <div class="bg-white rounded-3 p-3 border border-danger border-opacity-25 mt-2">
                                <small class="text-danger fw-bold d-block">Alasan:</small>
                                <p class="mb-0 text-dark small">{{ $claim->rejection_reason }}</p>
                            </div>
                        @endif

                        {{-- TOMBOL BATAL --}}
                        @if(in_array($claim->status, ['pending', 'approved']))
                            <div class="mt-4 pt-3 border-top border-secondary border-opacity-10 text-end">
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                    <i class="bi bi-x-circle me-1"></i> Batalkan Permintaan
                                </button>
                            </div>
                            <div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold text-danger">Batalkan Permintaan?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center py-4">
                                            <div class="mb-3 text-danger opacity-75">
                                                <i class="bi bi-exclamation-circle display-1"></i>
                                            </div>
                                            <p class="text-dark fw-bold mb-1">
                                                Yakin ingin membatalkan permintaan ini?
                                            </p>
                                            <small class="text-muted d-block">
                                                Makanan akan kembali tersedia untuk orang lain yang membutuhkan.
                                            </small>
                                        </div>
                                        <div class="modal-footer border-0 justify-content-center pb-4 pt-0">
                                            <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" data-bs-dismiss="modal">Kembali</button>
                                            
                                            <form action="{{ route('receiver.claim.cancel', $claim->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger px-4 rounded-pill fw-bold">
                                                    Ya, Batalkan
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection