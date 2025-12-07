@extends('layouts.donor')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Permintaan Masuk (Pending)</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Penerima</th>
                        <th>Makanan Diminta</th>
                        <th>Pesan</th>
                        <th>Tanggal Request</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($claims as $claim)
                    <tr>
                        <td>
                            <strong>{{ $claim->receiver->name }}</strong><br>
                            <small class="text-muted">{{ $claim->receiver->phone }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($claim->fooditems->photo)
                                    <img src="{{ asset($claim->fooditems->photo) }}" width="40" class="rounded me-2">
                                @endif
                                <span>{{ $claim->fooditems->name }}</span>
                            </div>
                        </td>
                        <td>{{ $claim->message ?? '-' }}</td>
                        <td>{{ $claim->created_at->diffForHumans() }}</td>
                        <td>
                            <form action="{{ route('donor.requests.approve', $claim->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-success">✓ Terima</button>
                            </form>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $claim->id }}">
                                ✗ Tolak
                            </button>
                            <div class="modal fade" id="rejectModal-{{ $claim->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('donor.requests.reject', $claim->id) }}" method="POST">
                                            @csrf 
                                            @method('PATCH')
                                            
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tolak Permintaan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <p>Anda akan menolak permintaan dari <strong>{{ $claim->receiver->name ?? 'User' }}</strong>.</p>
                                                
                                                <div class="mb-3">
                                                    <label for="reason-select-{{ $claim->id }}" class="form-label">Pilih Alasan Penolakan:</label>
                                                    
                                                    {{-- Langsung gunakan name="rejection_reason" di sini --}}
                                                    <select name="rejection_reason" id="reason-select-{{ $claim->id }}" class="form-select" required>
                                                        <option value="">-- Pilih Alasan --</option>
                                                        <option value="Maaf, lokasi Anda terlalu jauh untuk penjemputan.">Jarak Terlalu Jauh</option>
                                                        <option value="Maaf, makanan ini sudah didahulukan untuk orang yang lebih membutuhkan.">Sudah Ada Prioritas Lain</option>
                                                        <option value="Mohon maaf, kondisi makanan ternyata sudah tidak layak dikonsumsi.">Makanan Rusak/Basi</option>
                                                        <option value="Maaf, waktu penjemputan tidak sesuai dengan ketersediaan saya.">Waktu Tidak Cocok</option>
                                                        <option value="Maaf, stok makanan sudah habis.">Stok Habis</option>
                                                        <option value="Maaf, permintaan Anda kami tolak.">Lainnya</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada permintaan baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection