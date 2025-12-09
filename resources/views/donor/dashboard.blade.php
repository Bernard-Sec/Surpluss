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
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0">Total Donasi</h5>
                    <h2 class="fw-bold mb-0">{{ $totalDonated }}</h2>
                </div>
                <div style="font-size: 3rem; opacity: 0.3;">🎁</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-warning text-dark">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0">Permintaan Masuk</h5>
                    <h2 class="fw-bold mb-0">{{ $totalClaims }}</h2>
                </div>
                <div style="font-size: 3rem; opacity: 0.3;">📩</div>
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
                                    <th>Jumlah</th>
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
                                                <span class="fw-bold d-block">{{ $item->name }}</span>
                                                <small class="text-muted">{{ $item->pickup_location }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->quantity }} Porsi</td>
                                    <td>
                                        @php
                                            $isExpired = \Carbon\Carbon::parse($item->expires_at)->isPast();
                                        @endphp

                                        @if($isExpired)
                                            {{-- Jika sudah lewat tanggal tapi status masih available --}}
                                            <span class="text-danger fw-bold">
                                                {{ \Carbon\Carbon::parse($item->expires_at)->format('d M Y') }}
                                            </span>
                                            <div class="small text-danger">
                                                <i class="bi bi-exclamation-circle"></i> Sudah lewat!
                                            </div>
                                        @else
                                            {{-- Normal --}}
                                            {{ \Carbon\Carbon::parse($item->expires_at)->format('d M Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($isExpired)
                                            {{-- Jika expired, jangan kasih tombol Edit, paksa Hapus --}}
                                            <form action="{{ route('donor.food.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Makanan ini sudah expired. Hapus sekarang?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Hapus / Arsipkan
                                                </button>
                                            </form>
                                        @else
                                            {{-- Tombol Normal --}}
                                            <a href="{{ route('donor.food.edit', $item->id) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                            <form action="{{ route('donor.food.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        @endif
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
                                    <th>Pesan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingClaims as $claim)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $claim->receiver->name ?? 'User' }}</div>
                                        <div class="small text-muted">{{ $claim->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($claim->fooditems->photo)
                                                {{-- Gunakan Accessor photo_url jika sudah dibuat --}}
                                                <img src="{{ asset($claim->fooditems->photo) }}" width="50" height="50"  class="rounded me-2">
                                            @endif
                                            <span>{{ $claim->fooditems->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $claim->message ?? '-' }}</td>
                                    <td>
                                        {{-- Tombol Approve --}}
                                        <form action="{{ route('donor.requests.approve', $claim->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-success fw-bold px-3">
                                                Terima
                                            </button>
                                        </form>

                                        {{-- Tombol Modal Reject --}}
                                        <button type="button" class="btn btn-sm btn-danger fw-bold px-3" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $claim->id }}">
                                            Tolak
                                        </button>

                                        {{-- MODAL REJECT (INCLUDE DI SINI) --}}
                                        <div class="modal fade" id="rejectModal-{{ $claim->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('donor.requests.reject', $claim->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tolak Permintaan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Tolak permintaan dari <strong>{{ $claim->receiver->name }}</strong>?</p>
                                                            <div class="mb-3">
                                                                <label class="form-label">Alasan:</label>
                                                                <select name="rejection_reason" class="form-select" required>
                                                                    <option value="">-- Pilih Alasan --</option>
                                                                    <option value="Jarak terlalu jauh">Jarak terlalu jauh</option>
                                                                    <option value="Sudah diberikan ke yang lain">Sudah diberikan ke yang lain</option>
                                                                    <option value="Makanan rusak/basi">Makanan rusak/basi</option>
                                                                    <option value="Waktu tidak cocok">Waktu tidak cocok</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Tolak</button>
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
                                    <th>Nama Makanan</th>
                                    <th>Penerima (Claimer)</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ongoingItems as $item)
                                <tr>
                                    <td class="fw-bold">{{ $item->name }}</td>
                                    <td>
                                        {{-- Logic simple ambil nama claimer terakhir yg disetujui --}}
                                        {{-- Idealnya relasi 'acceptedClaim' dipanggil, tapi ini shortcut --}}
                                        Menunggu Pickup
                                    </td>
                                    <td><span class="badge bg-warning text-dark">Sedang Dijemput</span></td>
                                    <td>
                                        <form action="{{ route('donor.food.cancel', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan donasi ini? Penerima mungkin sudah di jalan.');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-danger">Batalkan Donasi</button>
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
                                                <i class="bi bi-calendar-x"></i> Kedaluwarsa
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