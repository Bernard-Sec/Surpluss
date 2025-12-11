@extends('layouts.receiver')

@section('content')

{{-- LEAFLET CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<style>
    #map { height: 300px; width: 100%; border-radius: 12px; z-index: 1; }
    .leaflet-touch .leaflet-control-layers, .leaflet-touch .leaflet-bar { border: none; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Header Navigation --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-dark mb-1">Edit Profil Penerima</h3>
                    <p class="text-muted mb-0">Perbarui informasi pribadi dan alamat Anda.</p>
                </div>
                <a href="{{ route('receiver.profile') }}" class="btn btn-outline-secondary pill px-4">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-person-gear me-2"></i> Form Data Diri</h6>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('receiver.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Section 1: Data Akun --}}
                        <h6 class="fw-bold text-success mb-3">Informasi Akun</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control bg-light @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control bg-light @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">No. Telepon / WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-whatsapp"></i></span>
                                    <input type="text" class="form-control bg-light @error('phone') is-invalid @enderror" 
                                           name="phone" value="{{ old('phone', $user->phone) }}" placeholder="0812..." required>
                                </div>
                                @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="border-light my-4">

                        {{-- Section 2: Alamat & Peta --}}
                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-geo-alt me-2"></i>Lokasi Utama</h6>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            
                            {{-- Input Address Group --}}
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-white text-muted"><i class="bi bi-map"></i></span>
                                
                                <input type="text" id="address" name="address" 
                                       class="form-control bg-light @error('address') is-invalid @enderror" 
                                       placeholder="Cari di peta atau ketik manual..." 
                                       value="{{ old('address', $user->address) }}" required>
                                
                                {{-- Tombol Locate Me --}}
                                <button class="btn btn-outline-secondary" type="button" onclick="locateUser()" title="Gunakan Lokasi Saya Saat Ini">
                                    <i class="bi bi-crosshair"></i> Lokasi Saya
                                </button>
                            </div>
                            @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

                            {{-- Peta Leaflet --}}
                            <div id="map" class="border shadow-sm mt-2"></div>
                            <div class="form-text small text-muted mt-2">
                                <i class="bi bi-info-circle"></i> Geser marker merah di peta untuk memperbarui alamat secara otomatis.
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                            <a href="{{ route('receiver.profile') }}" class="btn btn-light btn-md px-4 text-secondary fw-bold">Batal</a>
                            <button type="submit" class="btn btn-success btn-md px-5 shadow-sm fw-bold">
                                <i class="bi bi-check-circle me-2"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- LEAFLET JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    let locateUser; 

    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Setup Peta (Default: Monas Jakarta)
        let defaultLat = -6.175392; 
        let defaultLng = 106.827153;
        
        var map = L.map('map').setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

        // 2. Fungsi Reverse Geocoding (LatLong -> Alamat)
        async function getAddress(lat, lng) {
            document.getElementById('address').placeholder = "Sedang mencari nama jalan...";
            try {
                let response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
                let data = await response.json();
                if(data && data.display_name) {
                    // Ambil 4 bagian pertama dari alamat agar tidak terlalu panjang
                    let shortAddress = data.display_name.split(',').slice(0, 4).join(',');
                    document.getElementById('address').value = shortAddress;
                }
            } catch (error) {
                console.error("Gagal mengambil alamat:", error);
            }
        }

        // 3. Event Listener Marker Digeser
        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            getAddress(position.lat, position.lng);
        });

        // 4. Event Listener Peta Diklik
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            getAddress(e.latlng.lat, e.latlng.lng);
        });

        // 5. Fungsi Lokasi Saya (GPS)
        locateUser = function() {
            if (navigator.geolocation) {
                document.getElementById('address').placeholder = "Mendeteksi lokasi GPS...";
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var userLat = position.coords.latitude;
                        var userLng = position.coords.longitude;
                        
                        map.setView([userLat, userLng], 16);
                        marker.setLatLng([userLat, userLng]);
                        
                        // Update input text dengan hasil GPS
                        getAddress(userLat, userLng);
                    },
                    function(error) {
                        alert("Gagal mendeteksi lokasi. Pastikan GPS aktif dan izin browser diberikan.");
                        console.warn(error.message);
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