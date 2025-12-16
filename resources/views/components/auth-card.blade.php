<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    
    <div class="card shadow-lg p-4 rounded-4" style="width: 420px;">
        
        {{-- Logo or Back --}}
        <div class="mb-4 d-flex justify-content-between">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                ← {{ __('login.back') }}
            </a>

            <h4 class="fw-bold text-success m-0">{{ $title }}</h4>
        </div>

        {{ $slot }}
    </div>

</div>