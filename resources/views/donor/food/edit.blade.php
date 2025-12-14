@extends('layouts.donor')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<style>
    #map { height: 300px; width: 100%; border-radius: 12px; z-index: 1; }
    .leaflet-touch .leaflet-control-layers, .leaflet-touch .leaflet-bar { border: none; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-dark mb-1">Edit Donasi</h3>
                    <p class="text-muted mb-0">Perbarui informasi makanan yang Anda bagikan.</p>
                </div>
                <a href="{{ route('donor.dashboard') }}" class="btn btn-outline-secondary pill px-4">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Form Edit Makanan</h6>
                </div>
                
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('donor.food.update', $foodItem->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 
                        <div class="row g-4 mb-4">
                            <div class="col-md-4 text-center">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Foto Makanan</label>
                                <div class="position-relative">
                                    <div class="ratio ratio-1x1 bg-light rounded-4 border border-dashed d-flex align-items-center justify-content-center overflow-hidden" 
                                         style="border-style: dashed !important; cursor: pointer;" 
                                         onclick="document.getElementById('photoInput').click()">
                                        
                                        <img id="imagePreview" 
                                             src="{{ $foodItem->photo ? $foodItem->photo_url : '#' }}" 
                                             alt="Preview" 
                                             class="w-100 h-100 object-fit-cover {{ $foodItem->photo ? '' : 'd-none' }}">
                                        
                                        <div id="uploadPlaceholder" class="text-center p-3 {{ $foodItem->photo ? 'd-none' : '' }}">
                                            <i class="bi bi-camera fs-1 text-muted opacity-50"></i>
                                            <div class="small text-muted mt-2">Klik untuk ganti foto</div>
                                        </div>
                                    </div>
                                    <input type="file" name="photo" id="photoInput" class="d-none" accept="image/*" onchange="previewImage(this)">
                                </div>
                                <div class="form-text small text-center mt-2">Biarkan kosong jika tidak ingin mengubah foto.</div>
                                @error('photo') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Makanan <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control bg-light" 
                                           placeholder="Contoh: Roti Manis Isi Coklat" 
                                           value="{{ old('name', $foodItem->name) }}" required>
                                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-select bg-light" required>
                                            <option value="">-- Pilih --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                    {{ old('category_id', $foodItem->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Jumlah Porsi <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control bg-light" 
                                                   placeholder="0" min="1" 
                                                   value="{{ old('quantity', $foodItem->quantity) }}" required>
                                            <span class="input-group-text bg-white text-muted">Porsi</span>
                                        </div>
                                        @error('quantity') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="border-light my-4">

                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-geo-alt me-2"></i>Detail Pengambilan</h6>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kedaluwarsa <span class="text-danger">*</span></label>
                                <input type="date" name="expires_at" class="form-control bg-light" 
                                       value="{{ old('expires_at', \Carbon\Carbon::parse($foodItem->expires_at)->format('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Waktu Pickup <span class="text-danger">*</span></label>
                                <input type="text" name="pickup_time" class="form-control bg-light" 
                                       placeholder="Cth: 15.00 - 18.00" 
                                       value="{{ old('pickup_time', $foodItem->pickup_time) }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Lokasi Pickup <span class="text-danger">*</span></label>
                            
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-white text-muted"><i class="bi bi-geo-alt-fill text-danger"></i></span>
                                
                                <input type="text" id="pickup_location" name="pickup_location" class="form-control bg-light" 
                                       placeholder="Cari di peta atau ketik alamat..." 
                                       value="{{ old('pickup_location', $foodItem->pickup_location) }}" required>
                                
                                <button class="btn btn-outline-secondary" type="button" onclick="locateUser()" title="Gunakan Lokasi Saya Saat Ini">
                                    <i class="bi bi-crosshair"></i> Lokasi Saya
                                </button>
                            </div>

                            <div id="map" class="border shadow-sm"></div>
                            <div class="form-text small text-muted"><i class="bi bi-info-circle"></i> Alamat di atas adalah lokasi tersimpan. Geser marker di peta jika ingin mengubah alamat.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi Tambahan <span class="opacity-50">(Opsional)</span></label>
                            <textarea name="description" class="form-control bg-light" rows="3" 
                                      placeholder="Jelaskan kondisi makanan...">{{ old('description', $foodItem->description) }}</textarea>
                            @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('donor.dashboard') }}" class="btn btn-light btn-md px-4 text-secondary w-50">Batal</a>
                            <button type="submit" class="btn btn-success btn-md px-5 shadow-sm w-50">
                                <i class="bi bi-check-circle me-2"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    let locateUser; 

    document.addEventListener('DOMContentLoaded', function() {
        
        let defaultLat = -6.175392; 
        let defaultLng = 106.827153;
        
        var map = L.map('map').setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

        async function getAddress(lat, lng) {
            document.getElementById('pickup_location').placeholder = "Sedang mencari nama jalan...";
            try {
                let response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
                let data = await response.json();
                if(data && data.display_name) {
                    let shortAddress = data.display_name.split(',').slice(0, 4).join(',');
                    document.getElementById('pickup_location').value = shortAddress;
                }
            } catch (error) {
                console.error("Gagal mengambil alamat:", error);
            }
        }

        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            getAddress(position.lat, position.lng);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            getAddress(e.latlng.lat, e.latlng.lng);
        });

        locateUser = function() {
            if (navigator.geolocation) {
                document.getElementById('pickup_location').placeholder = "Mendeteksi lokasi GPS...";
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var userLat = position.coords.latitude;
                        var userLng = position.coords.longitude;
                        map.setView([userLat, userLng], 16);
                        marker.setLatLng([userLat, userLng]);
                        getAddress(userLat, userLng);
                    },
                    function(error) {
                        console.warn("Akses lokasi ditolak/error:", error.message);
                    },
                    { enableHighAccuracy: true }
                );
            } else {
                alert("Browser ini tidak mendukung Geolocation.");
            }
        }
    });
</script>
@endsection