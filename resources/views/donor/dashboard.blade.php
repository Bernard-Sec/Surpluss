@extends('layouts.donor')

@section('content')

<style>
    .nav-pills .nav-link.active {
        background-color: #198754 !important;
    }
    .nav-pills .nav-link {
        color: #198754 !important;
    }
    .nav-tabs .nav-link {
        color: #6c757d !important;
        border: none !important;
        border-bottom: 3px solid transparent !important;
        padding: 0.5rem 1rem !important;
        font-weight: 600;
    }
    
    .nav-tabs .nav-link.active {
        color: #198754 !important;
        border-bottom-color: #198754 !important;
        background-color: transparent !important;
    }

    .nav-pills .nav-link {
        color: #6c757d !important;
        background-color: transparent !important;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.95rem;
    }
    
    .nav-pills .nav-link.active {
        background-color: #198754 !important;
        color: white !important;
    }
</style>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold text-success">Halo, {{ $user->name }}! 👋</h2>
        <p class="text-muted">Yuk bantu kurangi food waste hari ini!</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('donor.food.create') }}" class="btn btn-success btn-md shadow-sm">
            + Donasi Makanan
        </a>
    </div>
</div>

<div class="row mb-5 g-2">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-dark h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 text-dark-50">Donasi Aktif</h5>
                    <h2 class="fw-bold mb-0">{{ $totalActive }}</h2>
                    <small class="text-dark-50">Siap diambil</small>
                </div>
                <div class="fs-1 opacity-25">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-dark h-100" style="background-color: #f75151;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 text-dark-50">Permintaan Masuk</h5>
                    <h2 class="fw-bold mb-0">{{ $totalRequests ?? $totalClaims }}</h2> {{-- Sesuaikan variable controller --}}
                    <small class="text-dark-50">Butuh respons</small>
                </div>
                <div class="fs-1 opacity-25">
                    <i class="bi bi-inbox-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-dark h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 text-dark-50">Klaim Selesai</h5>
                    <h2 class="fw-bold mb-0">{{ $totalClaimsCompleted }}</h2>
                    <small class="text-dark-50">Telah disalurkan</small>
                </div>
                <div class="fs-1 opacity-25">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-dark h-100" style="background-color: #53d170;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 text-dark-50">Donasi Selesai</h5>
                    <h2 class="fw-bold mb-0">{{ $totalCompleted }}</h2>
                    <small class="text-dark-50">Telah disalurkan</small>
                </div>
                <div class="fs-1 opacity-25">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-secondary fw-bold" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">
                    🟢 Sedang Aktif ({{ $activeItems->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-secondary fw-bold" id="requests-tab" data-bs-toggle="tab" data-bs-target="#requests" type="button" role="tab">
                    🔔 Permintaan ({{ $pendingClaims->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-secondary fw-bold" id="process-tab" data-bs-toggle="tab" data-bs-target="#process" type="button" role="tab">
                    🚚 Dalam Proses ({{ $ongoingItems->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-secondary fw-bold" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">
                    📜 Riwayat Selesai
                </button>
            </li>
        </ul>
    </div>
    
    <div class="card-body p-4">
        <div class="tab-content" id="myTabContent">
            
            <div class="tab-pane fade show active" id="active" role="tabpanel">
                @if($activeItems->isEmpty())
                    <p class="text-center text-muted py-4">Belum ada donasi aktif. Yuk donasi sekarang!</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Makanan</th>
                                    <th class="text-center">Jumlah Tersedia</th>
                                    <th>Waktu Pengambilan</th>
                                    <th>Tanggal Kedaluwarsa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->photo)
                                                <img src="{{ $item->photo_url }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                            @else
                                                <div class="rounded bg-secondary me-3 d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px;">?</div>
                                            @endif
                                            <div>
                                                <span class="d-block">{{ $item->name }}</span>
                                                <span class="badge bg-light text-secondary border mt-1">
                                                    {{ $item->category->name ?? 'Umum' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="text-dark">{{ $item->quantity }}</span> 
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center text-dark">
                                            <i class="bi bi-clock me-2 text-primary"></i>
                                            <span>{{ $item->pickup_time ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        @php $isExpired = \Carbon\Carbon::parse($item->expires_at)->isPast(); @endphp
                                        @if($isExpired)
                                            <span class="text-danger fw-bold">{{ \Carbon\Carbon::parse($item->expires_at)->format('d M Y') }}</span>
                                            <div class="small text-danger"><i class="bi bi-exclamation-circle"></i> Expired</div>
                                        @else
                                            <span class="text-dark">{{ \Carbon\Carbon::parse($item->expires_at)->format('d M Y') }}</span>
                                            <div class="small text-muted">
                                                {{ \Carbon\Carbon::parse($item->expires_at)->locale('id')->diffForHumans() }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        @if(!$isExpired)
                                            <a href="{{ route('donor.food.edit', $item->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('donor.food.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus item ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="tab-pane fade" id="requests" role="tabpanel">
                @if($pendingClaims->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada permintaan masuk saat ini.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Penerima</th>
                                    <th>Makanan Diminta</th>
                                    <th class="text-center">Jumlah Diminta</th>
                                    <th>Pesan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingClaims as $claim)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <i class="bi bi-person-circle fs-3 text-secondary"></i>
                                            </div>
                                            <div>
                                                <span class="d-block text-dark">{{ $claim->receiver->name ?? 'User' }}</span>
                                                <small class="text-muted">
                                                    <i class="bi bi-clock-history"></i> {{ $claim->created_at->locale('id')->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($claim->fooditems && $claim->fooditems->photo)
                                                <img src="{{ $claim->fooditems->photo_url }}" width="50" height="50" class="rounded me-3 object-fit-cover">
                                            @else
                                                <div class="rounded bg-light me-3 d-flex align-items-center justify-content-center text-muted border" style="width: 50px; height: 50px;">
                                                    <i class="bi bi-egg-fried"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <span class="d-block text-dark">{{ $claim->fooditems->name ?? '-' }}</span>
                                                <small class="text-secondary badge bg-light border text-dark">
                                                    Sisa: {{ $claim->fooditems->quantity ?? 0 }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="text-dark">{{ $claim->quantity }}</span>
                                    </td>

                                    <td>
                                        @if($claim->message)
                                            <div class="text-muted small fst-italic">"{{ Str::limit($claim->message, 50) }}"</div>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('donor.requests.approve', $claim->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm btn-outline-success px-3" title="Terima Permintaan">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>

                                            <button type="button" class="btn btn-sm btn-outline-danger px-3" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $claim->id }}" title="Tolak">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>

                                        <div class="modal fade" id="rejectModal-{{ $claim->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('donor.requests.reject', $claim->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title fw-bold">Tolak Permintaan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Anda yakin menolak permintaan dari <strong class="text-dark">{{ $claim->receiver->name ?? 'User' }}</strong>?</p>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold small">Pilih Alasan Penolakan:</label>
                                                                <select name="rejection_reason" class="form-select" required>
                                                                    <option value="">-- Pilih Alasan --</option>
                                                                    <option value="Maaf, sudah diambil orang lain">Sudah diambil orang lain</option>
                                                                    <option value="Jarak lokasi terlalu jauh">Jarak lokasi terlalu jauh</option>
                                                                    <option value="Waktu pengambilan tidak cocok">Waktu pengambilan tidak cocok</option>
                                                                    <option value="Stok makanan habis">Stok makanan habis</option>
                                                                    <option value="Lainnya">Lainnya</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Tolak Permintaan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="tab-pane fade" id="process" role="tabpanel">
                @if($ongoingItems->isEmpty())
                    <p class="text-center text-muted py-4">Tidak ada donasi yang sedang diproses.</p>
                @else
                    <div class="alert alert-info py-2 small">
                        <i class="bi bi-info-circle"></i> Item di sini sedang menunggu diambil oleh penerima. Anda tidak bisa mengedit data, tapi bisa membatalkan jika darurat.
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Penerima</th>
                                    <th>Nama Makanan</th>
                                    <th class="text-center">Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ongoingItems as $claim)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <i class="bi bi-person-circle fs-3 text-secondary"></i>
                                            </div>
                                            <div>
                                                <span class="d-block text-dark">{{ $claim->receiver->name ?? 'User' }}</span>
                                                <small class="text-muted" style="">
                                                    {{ $claim->receiver->phone ?? 'No Hp: -' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($claim->fooditems && $claim->fooditems->photo)
                                                <img src="{{ $claim->fooditems->photo_url }}" width="50" height="50" class="rounded me-3 object-fit-cover">
                                            @endif
                                            <span class="text-dark">{{ $claim->fooditems->name ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="">{{ $claim->quantity }}</span>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-success" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#verifyModal-{{ $claim->id }}">
                                                <i class="bi bi-qr-code-scan"></i> Konfirmasi
                                            </button>

                                            <form action="{{ route('donor.claims.cancel', $claim->id) }}" method="POST" onsubmit="return confirm('...');">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-x-circle"></i> Batalkan
                                                </button>
                                            </form>
                                        </div>

                                        <div class="modal fade" id="verifyModal-{{ $claim->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h6 class="modal-title fw-bold">Konfirmasi Donasi Selesai</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <p class="small text-muted mb-3">
                                                            Masukkan kode 4 digit yang ditunjukkan oleh <strong>{{ $claim->receiver->name }}</strong>:
                                                        </p>
                                                        
                                                        <form action="{{ route('donor.claims.verify', $claim->id) }}" method="POST">
                                                            @csrf @method('PATCH')
                                                            
                                                            <div class="mb-3">
                                                                <input type="text" 
                                                                    name="verification_code" 
                                                                    class="form-control form-control-lg text-center fw-bold text-uppercase letter-spacing-2" 
                                                                    placeholder="XXXX" 
                                                                    maxlength="4" 
                                                                    autocomplete="off"
                                                                    required>
                                                            </div>

                                                            <button type="submit" class="btn btn-success w-100">
                                                                Konfirmasi
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="tab-pane fade" id="history" role="tabpanel">

                <div class="card border-0 bg-light mb-3">
                    <div class="card-body p-2">
                        <ul class="nav nav-pills" id="historySubTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active small" id="history-claims-tab" data-bs-toggle="pill" data-bs-target="#history-claims" type="button" role="tab">
                                    <i class="bi bi-receipt-cutoff"></i> Riwayat Klaim
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link small" id="history-items-tab" data-bs-toggle="pill" data-bs-target="#history-items" type="button" role="tab">
                                    <i class="bi bi-box-seam"></i> Riwayat Donasi
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content" id="historySubTabContent">
                    
                    <div class="tab-pane fade show active" id="history-claims" role="tabpanel">
                        @if($historyClaims->isEmpty())
                            <p class="text-center text-muted py-4">Belum ada riwayat transaksi penerima.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal Selesai</th>
                                            <th>Penerima</th>
                                            <th>Nama Makanan</th>
                                            <th class="text-center">Jumlah</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($historyClaims as $claim)
                                        <tr>
                                            <td>
                                                <div class="">{{ $claim->updated_at->format('d M Y') }}</div>
                                                <small class="">{{ $claim->updated_at->format('H:i') }}  WIB</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-person-circle text-secondary fs-3 me-2"></i>
                                                    <span class="text-dark">{{ $claim->receiver->name ?? 'User' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($claim->fooditems && $claim->fooditems->photo)
                                                    <img src="{{ $claim->fooditems->photo_url }}" width="50" height="50" class="rounded me-3 object-fit-cover">
                                                @endif
                                                <span class="text-dark">{{ $claim->fooditems->name ?? '-' }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold">{{ $claim->quantity }}</span>
                                            </td>
                                            <td>
                                                @if($claim->status == 'completed')
                                                    <span class="badge bg-success">
                                                        Selesai
                                                    </span>
                                                    {{-- @if($claim->verification_code)
                                                        <div class="small text-muted mt-1" style="font-size: 0.7rem;">Code: {{ $claim->verification_code }}</div>
                                                    @endif --}}
                                                @elseif($claim->status == 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @elseif($claim->status == 'cancelled')
                                                    <span class="badge bg-secondary">Batal</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="history-items" role="tabpanel">
                        @if($historyItems->isEmpty())
                            <p class="text-center text-muted py-4">Belum ada riwayat stok makanan.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Makanan</th>
                                            <th>Status Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($historyItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->photo)
                                                        <img src="{{ $item->photo_url }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                                    @endif
                                                    <span class="">{{ $item->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($item->status == 'completed')
                                                    <span class="badge bg-success">Didonasikan</span>
                                                @elseif($item->status == 'cancelled')
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @elseif($item->status == 'expired')
                                                    <span class="badge bg-secondary">Kedaluwarsa</span>
                                                @else
                                                    <span class="badge bg-light text-dark border">{{ ucfirst($item->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection