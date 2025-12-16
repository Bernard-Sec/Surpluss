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
                    <h3 class="fw-bold text-dark mb-1">{{ __('donor.create_title') }}</h3>
                    <p class="text-muted mb-0">{{ __('donor.create_subtitle') }}</p>
                </div>
                <a href="{{ route('donor.dashboard') }}" class="btn btn-outline-secondary pill px-4">
                    <i class="bi bi-arrow-left me-2"></i> {{ __('donor.btn_back') }}
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-basket me-2"></i> {{ __('donor.form_title') }}</h6>
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

                    <form action="{{ route('donor.food.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4 mb-4">
                            <div class="col-md-4 text-center">
                                <label class="form-label fw-bold">{{ __('donor.label_photo') }}</label>
                                <div class="position-relative">
                                    <div class="ratio ratio-1x1 bg-light rounded-4 border border-dashed d-flex align-items-center justify-content-center overflow-hidden" 
                                         style="border-style: dashed !important; cursor: pointer;" 
                                         onclick="document.getElementById('photoInput').click()">
                                        
                                        <img id="imagePreview" src="#" alt="Preview" class="w-100 h-100 object-fit-cover d-none">
                                        
                                        <div id="uploadPlaceholder" class="text-center p-3">
                                            <i class="bi bi-camera fs-1 text-muted opacity-50"></i>
                                            <div class="small text-muted mt-2">{{ __('donor.label_click_upload') }}</div>
                                        </div>
                                    </div>
                                    <input type="file" name="photo" id="photoInput" class="d-none" accept="image/*" onchange="previewImage(this)">
                                </div>
                                @error('photo') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">{{ __('donor.label_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control bg-light" placeholder="{{ __('donor.ph_name') }}" value="{{ old('name') }}" required>
                                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">{{ __('donor.label_category') }} <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-select bg-light" required>
                                            <option value="">{{ __('donor.select_default') }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ __('categories.' . \Illuminate\Support\Str::slug($category->name)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">{{ __('donor.label_qty') }} <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control bg-light" placeholder="0" min="1" value="{{ old('quantity') }}" required>
                                            <span class="input-group-text bg-white text-muted">{{ __('donor.unit_qty') }}</span>
                                        </div>
                                        @error('quantity') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="border-light my-4">

                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-geo-alt me-2"></i>{{ __('donor.title_pickup') }}</h6>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('donor.label_exp') }} <span class="text-danger">*</span></label>
                                <input type="date" name="expires_at" class="form-control bg-light" value="{{ old('expires_at') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('donor.label_time') }} <span class="text-danger">*</span></label>
                                <input type="text" name="pickup_time" class="form-control bg-light" placeholder="{{ __('donor.ph_time') }}" value="{{ old('pickup_time') }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">{{ __('donor.label_loc') }} <span class="text-danger">*</span></label>
                            
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-white text-muted"><i class="bi bi-geo-alt-fill text-danger"></i></span>
                                
                                <input type="text" id="pickup_location" name="pickup_location" class="form-control bg-light" 
                                    placeholder="{{ __('donor.ph_loc') }}" 
                                    value="{{ old('pickup_location', auth()->user()->address) }}" required>
                                
                                <button class="btn btn-outline-secondary" type="button" onclick="locateUser()" title="{{ __('donor.btn_loc_me') }}">
                                    <i class="bi bi-crosshair"></i> {{ __('donor.btn_loc_me') }}
                                </button>
                            </div>

                            <div id="map" class="border shadow-sm"></div>
                            <div class="form-text small text-muted"><i class="bi bi-info-circle"></i> {{ __('donor.help_map') }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">{{ __('donor.label_desc') }} <span class="opacity-50">{{ __('donor.label_desc_opt') }}</span></label>
                            <textarea name="description" class="form-control bg-light" rows="3" placeholder="{{ __('donor.ph_desc') }}"></textarea>
                            @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('donor.dashboard') }}" class="btn btn-light btn-md px-4 text-secondary w-50">{{ __('donor.btn_cancel') }}</a>
                            <button type="submit" class="btn btn-success btn-md px-5 shadow-sm w-50">
                                {{ __('donor.btn_upload') }}
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
            document.getElementById('pickup_location').placeholder = "{{ __('donor.js_searching') }}";
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
                document.getElementById('pickup_location').placeholder = "{{ __('donor.js_detecting') }}";
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var userLat = position.coords.latitude;
                        var userLng = position.coords.longitude;

                        map.setView([userLat, userLng], 16);
                        marker.setLatLng([userLat, userLng]);

                        getAddress(userLat, userLng);
                    },
                    function(error) {
                        console.warn("Akses lokasi ditolak atau error:", error.message);
                    },
                    { enableHighAccuracy: true } 
                );
            } else {
                alert("Browser ini tidak mendukung Geolocation.");
            }
        }

        let currentAddress = document.getElementById('pickup_location').value;
        if (!currentAddress || currentAddress.trim() === "") {
            locateUser();
        } else {
        }
    });
</script>
@endsection