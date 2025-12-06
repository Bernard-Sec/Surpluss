<x-guest-layout>    

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-success">{{ __('home.welcome_title') }}</h1>
            <p class="lead text-muted">
                {{ __('home.welcome_desc') }}
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-6">
                <div class="card shadow-sm p-4 h-100">
                    <h4 class="fw-bold text-success">{{ __('home.why_title') }}</h4>
                    <p class="text-muted mt-2">
                        {{ __('home.why_desc') }}
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm p-4 h-100">
                    <h4 class="fw-bold text-success">{{ __('home.join_title') }}</h4>
                    <p class="text-muted mt-2">
                        {!! __('home.join_desc') !!}
                    </p>
                    <a href="{{ route('register') }}" class="btn btn-success w-50 mt-3">
                        {{ __('home.btn_register') }}
                    </a>
                </div>
            </div>

        </div>

    </div>

</x-guest-layout>