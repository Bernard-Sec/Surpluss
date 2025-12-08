@extends('layouts.donor')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Formulir Donasi Makanan</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('donor.food.update', $foodItem->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Makanan</label>
                        <input type="text" name="name" value="{{ $foodItem->name }}" class="form-control" placeholder="Contoh: Nasi Kotak Sisa Rapat" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih Kategori...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $cat->id == $foodItem->category_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah (Porsi/Pack)</label>
                            <input type="number" name="quantity" class="form-control" min="1" value="{{ $foodItem->quantity }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi & Kondisi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan detail makanan (misal: dimasak jam 8 pagi)">{{ $foodItem->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lokasi Pengambilan</label>
                        <textarea name="pickup_location" class="form-control" rows="2" required>{{ $foodItem->pickup_location }}</textarea> 
                        <small class="text-muted">Default: Alamat profil Anda.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Kadaluarsa (Estimasi)</label>
                            <input type="date" value="{{ \Carbon\Carbon::parse($foodItem->expires_at)->format('Y-m-d') }}" name="expires_at" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Foto Makanan</label>
                            
                            @if($foodItem->photo)
                                <div class="mb-2">
                                    <img src="{{ asset($foodItem->photo) }}" alt="Foto Lama" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            @endif

                            <input type="file" name="photo" class="form-control" accept="image/*">
                            @error('photo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">Update Donasi</button>
                        <a href="{{ route('donor.dashboard') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection