@extends('layouts.donor')

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
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="bg-success bg-gradient p-4 text-center" style="height: 100px;"></div>
                
                <div class="card-body text-center p-4 mt-n5">
                    <div class="position-relative d-inline-block mb-3">
                        <div class="rounded-circle bg-white p-1 shadow-sm">
                            @if(Laravel\Jetstream\Jetstream::managesProfilePhotos() && $user->profile_photo_path)
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="rounded-circle object-fit-cover" width="100" height="100">
                            @else
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" 
                                     style="width: 100px; height: 100px; font-size: 36px; font-weight: bold;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <h4 class="fw-bold text-dark mb-1">{{ $user->name }}</h4>
                    <span class="badge bg-light text-success border border-success mb-4 px-3 rounded-pill">
                        {{ __('donor.verified_donor') }}
                    </span>

                    <div class="text-start bg-light rounded-4 p-3 mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-success"><i class="bi bi-envelope"></i></div>
                            <div class="overflow-hidden">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">{{ __('donor.label_email') }}</small>
                                <span class="fw-medium text-dark text-truncate d-block">{{ $user->email }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-success"><i class="bi bi-telephone"></i></div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">{{ __('donor.label_phone') }}</small>
                                <span class="fw-medium text-dark">{{ $user->phone ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-success"><i class="bi bi-geo-alt"></i></div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">{{ __('donor.label_address') }}</small>
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

                    <a href="{{ route('donor.profile.edit') }}" class="btn btn-success w-100 rounded-pill py-2 shadow-sm">
                        <i class="bi bi-pencil-square me-2"></i> {{ __('donor.btn_edit_profile') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            
            <div class="row mb-4 g-2">
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm bg-primary text-white h-100 rounded-4">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-0 text-white-50 small">{{ __('donor.stat_active') }}</h6>
                                <h2 class="fw-bold mb-0">{{ $totalActive }}</h2>
                            </div>
                            <div class="fs-1 opacity-25">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100 rounded-4" style="background-color: #f75151; color: white;">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-0 text-white-50 small">{{ __('donor.tab_req') }}</h6>
                                <h2 class="fw-bold mb-0">{{ $totalRequests }}</h2>
                            </div>
                            <div class="fs-1 opacity-25">
                                <i class="bi bi-inbox-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm bg-warning text-dark h-100 rounded-4">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-0 text-dark-50 small">{{ __('donor.stat_claim') }}</h6>
                                <h2 class="fw-bold mb-0">{{ $totalClaimsCompleted }}</h2>
                            </div>
                            <div class="fs-1 opacity-25">
                                <i class="bi bi-receipt-cutoff"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100 rounded-4" style="background-color: #53d170; color: #004d1a;">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-0 small" style="opacity: 0.7;">{{ __('donor.stat_complete') }}</h6>
                                <h2 class="fw-bold mb-0">{{ $totalCompleted }}</h2>
                            </div>
                            <div class="fs-1 opacity-25">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-clock-history me-2 text-success"></i> {{ __('donor.recent_activity') }}</h5>
                    <a href="{{ route('donor.dashboard', ['tab' => 'history']) }}" class="btn btn-sm btn-light rounded-pill px-3 text-secondary fw-bold small">
                        {{ __('donor.btn_view_all') }} <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">{{ __('donor.th_food') }}</th>
                                    <th>{{ __('donor.label_category') }}</th>
                                    <th>{{ __('donor.th_time') }}</th>
                                    <th class="text-end pe-4">{{ __('donor.th_status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentDonations as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->photo_url }}" class="rounded me-3" width="40" height="40" style="object-fit: cover;">
                                                <div>
                                                    <span class="text-dark d-block">{{ $item->name }}</span>
                                                    <small class="text-muted">{{ $item->quantity }} {{ __('donor.unit_qty') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-secondary border">{{ $item->category ? __('categories.' . \Illuminate\Support\Str::slug($item->category->name)) : __('categories.general') }}</span>
                                        </td>
                                        <td>
                                            <small class="text-dark">{{ $item->created_at->format('d M Y') }}</small>
                                            <div class="text-muted small" style="font-size: 0.75rem;">{{ $item->created_at->format('H:i') }} WIB</div>
                                        </td>
                                        <td class="text-end pe-4">
                                            @if($item->status == 'available')
                                                <span class="badge bg-success rounded-pill px-3">{{ __('donor.status_active') }}</span>
                                            @elseif($item->status == 'completed')
                                                <span class="badge bg-primary rounded-pill px-3">{{ __('donor.status_completed') }}</span>
                                            @elseif($item->status == 'claimed')
                                                <span class="badge bg-warning text-dark rounded-pill px-3">{{ __('donor.status_process') }}</span>
                                            @elseif($item->status == 'expired')
                                                <span class="badge bg-secondary rounded-pill px-3">{{ __('donor.status_expired_badge') }}</span>
                                            @else
                                                <span class="badge bg-light text-dark border rounded-pill px-3">{{ ucfirst($item->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <p class="text-muted mb-0">{{ __('donor.activity_empty') }}</p>
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