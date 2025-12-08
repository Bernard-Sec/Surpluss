@extends('layouts.receiver')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 overflow-hidden">
                @if($foodItem->photo)
                    {{-- FIXED: Use exactly the same method as the dashboard. 
                         Do not manually add 'storage/' if it's already in the database. --}}
                    <img src="{{ asset($foodItem->photo) }}" 
                         class="card-img-top" 
                         style="height: 400px; object-fit: cover;" 
                         alt="{{ $foodItem->name }}"
                         onerror="this.onerror=null; this.src='https://placehold.co/800x400?text=Image+Load+Failed';">
                @else
                    <div class="bg-light text-center py-5 text-muted">
                        <p class="mb-0 fs-1">📷</p>
                        <p class="mb-0">Tidak ada foto tersedia</p>
                    </div>
                @endif
                
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-success mb-2">{{ $foodItem->category->name ?? 'Umum' }}</span>
                            <h2 class="card-title fw-bold mb-1">{{ $foodItem->name }}</h2>
                            <p class="text-muted mb-0">Donatur: <span class="fw-medium text-dark">{{ $foodItem->users->name }}</span></p>
                        </div>
                        <div class="text-end">
                             <small class="text-muted d-block">Kadaluarsa:</small>
                             <span class="fw-bold text-danger">{{ \Carbon\Carbon::parse($foodItem->expires_at)->format('d M Y') }}</span>
                             <small class="d-block text-muted">({{ \Carbon\Carbon::parse($foodItem->expires_at)->diffForHumans() }})</small>
                        </div>
                    </div>

                    <div class="row mb-4 g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded h-100">
                                <small class="text-muted d-block text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Jumlah</small>
                                <span class="fw-bold fs-5">{{ $foodItem->quantity }} Porsi/Pack</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded h-100">
                                <small class="text-muted d-block text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Lokasi</small>
                                <span class="fw-bold">{{ $foodItem->pickup_location }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold border-bottom pb-2">Deskripsi & Kondisi</h5>
                        <p class="text-secondary" style="line-height: 1.6;">{{ $foodItem->description ?? 'Tidak ada deskripsi detail.' }}</p>
                    </div>

                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <div>
                            Pastikan Anda bisa mengambil makanan di lokasi yang tertera sebelum mengajukan klaim.
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <form action="{{ route('receiver.claim.store', $foodItem->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold">
                                Ajukan Permintaan (Claim)
                            </button>
                        </form>
                        
                        <a href="{{ route('receiver.dashboard') }}" class="btn btn-outline-secondary btn-lg">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection