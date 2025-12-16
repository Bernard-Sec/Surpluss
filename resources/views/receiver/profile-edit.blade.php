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
                    <h3 class="fw-bold text-dark mb-1">{{ __('receiver.edit_title') }}</h3>
                    <p class="text-muted mb-0">{{ __('receiver.edit_desc') }}</p>
                </div>
                <a href="{{ route('receiver.profile') }}" class="btn btn-outline-secondary pill px-4">
                    <i class="bi bi-arrow-left me-2"></i> {{ __('receiver.btn_back') }}
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-person-gear me-2"></i> {{ __('receiver.form_title') }}</h6>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('receiver.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Section 1: Data Akun --}}
                        <h6 class="fw-bold text-success mb-3">{{ __('receiver.account_info') }}</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('receiver.label_name') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control bg-light @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('receiver.label_email') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control bg-light @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">{{ __('receiver.label_phone') }}</label>
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
                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-geo-alt me-2"></i>{{ __('receiver.label_main_loc') }}</h6>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">{{ __('receiver.label_address') }}</label>
                            
                            {{-- Input Address Group --}}
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-white text-muted"><i class="bi bi-map"></i></span>
                                
                                <input type="text" id="address" name="address" 
                                       class="form-control bg-light @error('address') is-invalid @enderror" 
                                       placeholder="{{ __('receiver.ph_address') }}" 
                                       value="{{ old('address', $user->address) }}" required>
                                
                                {{-- Tombol Locate Me --}}
                                <button class="btn btn-outline-secondary" type="button" onclick="locateUser()" title="Gunakan Lokasi Saya Saat Ini">
                                    <i class="bi bi-crosshair"></i> {{ __('donor.btn_loc_me') }}
                                </button>
                            </div>
                            @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

                            {{-- Peta Leaflet --}}
                            <div id="map" class="border shadow-sm mt-2"></div>
                            <div class="form-text small text-muted mt-2">
                                <i class="bi bi-info-circle"></i> {{ __('receiver.help_map') }}
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                            <a href="{{ route('receiver.profile') }}" class="btn btn-light btn-md px-4 text-secondary fw-bold">{{ __('receiver.btn_cancel') }}</a>
                            <button type="submit" class="btn btn-success btn-md px-5 shadow-sm fw-bold">
                                <i class="bi bi-check-circle me-2"></i> {{ __('receiver.btn_save') }}
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
        
        let defaultLat = -6.175392; 
        let defaultLng = 106.827153;
        
        var map = L.map('map').setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

        async function getAddress(lat, lng) {
            document.getElementById('address').placeholder = "{{ __('receiver.js_searching') }}";
            try {
                let response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
                let data = await response.json();
                if(data && data.display_name) {
                    let shortAddress = data.display_name.split(',').slice(0, 4).join(',');
                    document.getElementById('address').value = shortAddress;
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
                document.getElementById('address').placeholder = "{{ __('receiver.js_detecting') }}";
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var userLat = position.coords.latitude;
                        var userLng = position.coords.longitude;
                        
                        map.setView([userLat, userLng], 16);
                        marker.setLatLng([userLat, userLng]);
                        
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