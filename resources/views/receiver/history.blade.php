@extends('layouts.receiver')

@section('content')
<div class="container py-4">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-success">Riwayat Permintaan</h3>
            <p class="text-muted mb-0">Pantau status permintaan makananmu di sini.</p>
        </div>
        
        <form action="{{ route('receiver.history') }}" method="GET" class="d-flex gap-2 align-items-center bg-white p-2 rounded shadow-sm border">
            <label class="text-muted small fw-bold ms-2">Urutkan:</label>
            <select name="sort" class="form-select form-select-sm border-0 bg-light" onchange="this.form.submit()">
                <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Tanggal Terbaru</option>
                <option value="food_name" {{ request('sort') == 'food_name' ? 'selected' : '' }}>Nama Makanan (A-Z)</option>
                <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>Status</option>
            </select>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary">
                            <th class="ps-4 py-3">Makanan</th>
                            <th class="py-3">Donor</th>
                            <th class="py-3">Waktu Request</th>
                            <th class="py-3">Status</th>
                            <th class="text-end pe-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($claimsHistory as $claim)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    @if($claim->fooditems && $claim->fooditems->photo)
                                        <img src="{{ asset($claim->fooditems->photo_url) }}" 
                                             class="rounded-3 shadow-sm object-fit-cover" width="50" height="50">
                                    @else
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted border" 
                                             style="width:50px; height:50px;"><i class="bi bi-egg-fried"></i></div>
                                    @endif
                                    <div>
                                        <div class="text-dark">{{ $claim->fooditems->name ?? 'Item Dihapus' }}</div>
                                        <small class="text-muted">{{ $claim->quantity }} Porsi</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center text-secondary">
                                    <i class="bi bi-person-circle fs-3 me-2"></i>
                                    {{ $claim->fooditems->users->name ?? 'Unknown' }}
                                </div>
                            </td>
                            <td>
                                <div class="text-dark">{{ $claim->created_at->format('d M Y') }}</div>
                                <small class="text-muted">{{ $claim->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                @if($claim->status == 'pending')
                                    <span class="badge bg-warning text-dark border border-warning">Pending</span>
                                @elseif($claim->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                    <div class="mt-2">
                                        <div class="badge bg-light text-dark font-monospace border shadow-sm p-2">
                                            KODE: <span class="fw-bold fs-6">{{ $claim->verification_code }}</span>
                                        </div>
                                    </div>
                                @elseif($claim->status == 'completed')
                                    <span class="badge bg-primary">Selesai</span>
                                @elseif($claim->status == 'cancelled')
                                    <span class="badge bg-secondary">Dibatalkan</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- PERBAIKAN LINK DETAIL: Menggunakan ID CLAIM, bukan Food ID --}}
                                    <a href="{{ route('receiver.history.show', $claim->id) }}" 
                                       class="btn btn-sm btn-outline-success">
                                        Detail
                                    </a>

                                    @if(in_array($claim->status, ['pending', 'claimed']))
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                title="Batalkan Permintaan"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#cancelModal-{{ $claim->id }}">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                        <div class="modal fade text-start" id="cancelModal-{{ $claim->id }}" tabindex="-1" aria-hidden="true">
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
                                                            Yakin ingin membatalkan request untuk <br>
                                                            "{{ $claim->fooditems->name ?? 'Item ini' }}"?
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
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="80" class="mb-3 opacity-25">
                                <p class="text-muted">Belum ada riwayat permintaan.</p>
                                <a href="{{ route('receiver.dashboard') }}" class="btn btn-success btn-sm">Cari Makanan</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3 mb-3">
                {{ $claimsHistory->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection