@extends('layouts.receiver')

@section('content')
<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
            <i class="bi bi-check-circle-fill fs-4 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- KIRI: KARTU PROFIL --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="bg-success bg-gradient p-4 text-center" style="height: 100px;"></div>
                
                <div class="card-body text-center p-4 mt-n5">
                    <div class="position-relative d-inline-block mb-3">
                        <div class="rounded-circle bg-white p-1 shadow-sm">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" 
                                 style="width: 100px; height: 100px; font-size: 36px; font-weight: bold;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>

                    <h4 class="fw-bold text-dark mb-1">{{ $user->name }}</h4>
                    <span class="badge bg-light text-success border border-success mb-4 px-3 rounded-pill">
                        {{ __('receiver.verified_label') }}
                    </span>

                    <div class="text-start bg-light rounded-4 p-3 mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-success"><i class="bi bi-envelope"></i></div>
                            <div class="overflow-hidden">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">{{ __('receiver.label_email') }}</small>
                                <span class="fw-medium text-dark text-truncate d-block">{{ $user->email }}</span>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-success"><i class="bi bi-telephone"></i></div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">{{ __('receiver.label_phone') }}</small>
                                <span class="fw-medium text-dark">{{ $user->phone ?? '-' }}</span>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-success"><i class="bi bi-geo-alt"></i></div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">{{ __('receiver.label_main_loc') }}</small>
                                <span class="fw-medium text-dark">{{ $user->address ?? '-' }}</span>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-success"><i class="bi bi-calendar-check"></i></div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">{{ __('donor.join_since') }}</small>
                                <span class="fw-medium text-dark">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('receiver.profile-edit') }}" class="btn btn-success w-100 rounded-pill py-2 shadow-sm">
                        <i class="bi bi-pencil-square me-2"></i> {{ __('receiver.edit_title') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- KANAN: STATISTIK & HISTORY --}}
        <div class="col-md-8">
            <div class="row mb-4 g-2">
                {{-- 1. Total Request (Biru) --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-primary text-white h-100 rounded-4">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-0 text-white-50 small">{{ __('receiver.stat_total') }}</h6>
                                <h2 class="fw-bold mb-0">{{ $totalClaims }}</h2>
                            </div>
                            <div class="fs-1 opacity-25">
                                <i class="bi bi-inbox-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Menunggu (Kuning) --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-warning text-dark h-100 rounded-4">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-0 text-dark-50 small">{{ __('receiver.stat_waiting') }}</h6>
                                <h2 class="fw-bold mb-0">{{ $pendingClaims }}</h2>
                            </div>
                            <div class="fs-1 opacity-25">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. Berhasil/Selesai (Hijau) --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4" style="background-color: #53d170; color: #004d1a;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-0 small" style="opacity: 0.7;">{{ __('receiver.stat_success') }}</h6>
                                <h2 class="fw-bold mb-0">{{ $approvedClaims }}</h2>
                            </div>
                            <div class="fs-1 opacity-25">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABEL RIWAYAT TRANSAKSI TERAKHIR (Preview) --}}
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-clock-history me-2 text-success"></i> {{ __('receiver.activity_title') }}
                    </h5>
                    <a href="{{ route('receiver.history') }}" class="btn btn-sm btn-light rounded-pill px-3 text-secondary fw-bold small">
                        {{ __('receiver.btn_view_all') }} <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr class="text-uppercase small text-secondary">
                                    <th class="ps-4">{{ __('receiver.th_food') }}</th>
                                    <th>{{ __('receiver.th_donor') }}</th>
                                    <th>{{ __('receiver.th_status') }}</th>
                                    <th class="text-end pe-4">{{ __('receiver.sort_date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($claimsHistory as $claim)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($claim->fooditems && $claim->fooditems->photo)
                                                <img src="{{ asset($claim->fooditems->photo_url) }}" 
                                                     class="rounded shadow-sm object-fit-cover" width="40" height="40">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted border" 
                                                     style="width:40px; height:40px;"><i class="bi bi-egg-fried"></i></div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark small">{{ $claim->fooditems->name ?? __('receiver.item_deleted') }}</div>
                                                <small class="text-muted" style="font-size: 0.75rem;">{{ $claim->quantity ?? '-' }} {{ __('receiver.unit') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center text-secondary small">
                                            <i class="bi bi-person-circle me-2"></i>
                                            {{ $claim->fooditems->users->name ?? 'Unknown' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($claim->status == 'pending')
                                            <span class="badge bg-warning text-dark border border-warning rounded-pill px-3">{{ __('receiver.status_pending') }}</span>
                                        @elseif($claim->status == 'approved')
                                            <span class="badge bg-success rounded-pill px-3">{{ __('receiver.status_approved') }}</span>
                                        @elseif($claim->status == 'completed')
                                            <span class="badge bg-primary rounded-pill px-3">{{ __('receiver.status_completed') }}</span>
                                        @elseif($claim->status == 'cancelled')
                                            <span class="badge bg-secondary rounded-pill px-3">{{ __('receiver.status_cancelled') }}</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3">{{ __('receiver.status_rejected') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="text-dark small fw-medium">{{ $claim->created_at->format('d M') }}</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $claim->created_at->format('H:i') }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <p class="text-muted mb-0 small">{{ __('receiver.empty_activity') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection