@extends('layouts.donor')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold text-success">Halo, {{ $user->name }}! 👋</h2>
        <p class="text-muted">Siap menyelamatkan makanan hari ini?</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('donor.food.create') }}" class="btn btn-success btn-lg shadow-sm">
            + Donasi Makanan
        </a>
    </div>
</div>

<div class="row mb-5">
    {{-- KOLOM 1: DONASI AKTIF (Biru) --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 text-white-50">Donasi Aktif</h5>
                    <h2 class="fw-bold mb-0">{{ $totalActive }}</h2>
                    <small class="text-white-50">Siap diambil</small>
                </div>
                <div class="fs-1 opacity-25">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- KOLOM 2: DONASI SELESAI (Hijau) --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 text-white-50">Donasi Selesai</h5>
                    <h2 class="fw-bold mb-0">{{ $totalCompleted }}</h2>
                    <small class="text-white-50">Telah disalurkan</small>
                </div>
                <div class="fs-1 opacity-25">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- KOLOM 3: PERMINTAAN MASUK (Kuning) --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-warning text-dark h-100">
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
                                                <img src="{{ asset($item->photo) }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                            @else
                                                <div class="rounded bg-secondary me-3 d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px;">?</div>
                                            @endif
                                            <div>
                                                <span class="d-block">{{ $item->name }}</span>
                                                {{-- Tampilkan Kategori sebagai badge kecil --}}
                                                <span class="badge bg-light text-secondary border mt-1">
                                                    {{ $item->category->name ?? 'Umum' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        {{-- Hapus fw-bold dan fs-5 --}}
                                        <span class="text-dark">{{ $item->quantity }}</span> 
                                        <small class="text-muted d-block">Porsi</small>
                                    </td>

                                    {{-- TAMPILKAN PICKUP TIME DI SINI --}}
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
                                            {{-- Hitung sisa hari --}}
                                            <div class="small text-muted">
                                                {{ \Carbon\Carbon::parse($item->expires_at)->diffForHumans() }}
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
                                    {{-- KOLOM PENERIMA --}}
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <i class="bi bi-person-circle fs-3 text-secondary"></i>
                                            </div>
                                            <div>
                                                <span class="d-block text-dark">{{ $claim->receiver->name ?? 'User' }}</span>
                                                {{-- Waktu Request --}}
                                                <small class="text-muted">
                                                    <i class="bi bi-clock-history"></i> {{ $claim->created_at->locale('id')->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- KOLOM MAKANAN --}}
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($claim->fooditems && $claim->fooditems->photo)
                                                <img src="{{ asset($claim->fooditems->photo) }}" width="50" height="50" class="rounded me-3 object-fit-cover">
                                            @else
                                                <div class="rounded bg-light me-3 d-flex align-items-center justify-content-center text-muted border" style="width: 50px; height: 50px;">
                                                    <i class="bi bi-egg-fried"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <span class="d-block text-dark">{{ $claim->fooditems->name ?? '-' }}</span>
                                                {{-- Info Sisa Stok (Opsional, membantu keputusan) --}}
                                                <small class="text-secondary badge bg-light border text-dark">
                                                    Sisa: {{ $claim->fooditems->quantity ?? 0 }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="text-dark">{{ $claim->quantity }}</span>
                                        <span class="d-block small text-muted">Porsi</span>
                                    </td>

                                    {{-- KOLOM PESAN --}}
                                    <td>
                                        @if($claim->message)
                                            <div class="text-muted small fst-italic">"{{ Str::limit($claim->message, 50) }}"</div>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>

                                    {{-- KOLOM AKSI --}}
                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- Tombol TERIMA --}}
                                            <form action="{{ route('donor.requests.approve', $claim->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm btn-outline-success px-3" title="Terima Permintaan">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>

                                            {{-- Tombol TOLAK (Modal Trigger) --}}
                                            <button type="button" class="btn btn-sm btn-outline-danger px-3" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $claim->id }}" title="Tolak">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>

                                        {{-- MODAL REJECT (Tetap di dalam loop agar ID unik) --}}
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
                                        {{-- END MODAL --}}
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
                                    {{-- KOLOM PENERIMA --}}
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <i class="bi bi-person-circle fs-3 text-secondary"></i>
                                            </div>
                                            <div>
                                                <span class="d-block text-dark">{{ $claim->receiver->name ?? 'User' }}</span>
                                                {{-- Opsional: Info Kontak --}}
                                                <small class="text-muted" style="">
                                                    {{ $claim->receiver->phone ?? 'No Hp: -' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- KOLOM NAMA MAKANAN --}}
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($claim->fooditems && $claim->fooditems->photo)
                                                <img src="{{ asset($claim->fooditems->photo) }}" width="40" height="40" class="rounded me-2 object-fit-cover">
                                            @endif
                                            <span class="text-dark">{{ $claim->fooditems->name ?? '-' }}</span>
                                        </div>
                                    </td>

                                    {{-- KOLOM JUMLAH --}}
                                    <td class="text-center">
                                        <span class="">{{ $claim->quantity }}</span>
                                        <span class="d-block small text-muted">Porsi</span>
                                    </td>

                                    {{-- KOLOM AKSI --}}
                                    <td>
                                        <form action="{{ route('donor.claims.cancel', $claim->id) }}" method="POST" onsubmit="return confirm('Batalkan pickup untuk {{ $claim->receiver->name }}? Stok akan dikembalikan.');">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-50">
                                                <i class="bi bi-x-circle"></i> Batalkan
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

            <div class="tab-pane fade" id="history" role="tabpanel">
                @if($historyItems->isEmpty())
                    <p class="text-center text-muted py-4">Belum ada riwayat donasi.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Makanan</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Status Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historyItems as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if($item->status == 'completed')
                                            <span class="badge bg-success">Selesai (Disalurkan)</span>
                                        @elseif($item->status == 'cancelled')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        {{-- TAMBAHAN: Badge Khusus Expired --}}
                                        @elseif($item->status == 'expired')
                                            <span class="badge bg-secondary">
                                                Kedaluwarsa
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
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
@endsection