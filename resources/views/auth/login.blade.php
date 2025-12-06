<x-app-layout>

    <x-auth-card :title="__('login.title')">

        {{-- ERROR MESSAGE --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <label class="fw-semibold">{{ __('login.email_label') }}</label>
            <input type="email" name="email" class="form-control mb-3"
                   placeholder="{{ __('login.placeholder_email') }}" required>

            <label class="fw-semibold">{{ __('login.password_label') }}</label>
            <input type="password" name="password" class="form-control mb-3"
                   placeholder="••••••••" required>

            <button class="btn btn-success w-100 mt-2">
                {{ __('login.button') }}
            </button>

            <div class="text-center mt-3">
                <a href="{{ route('password.request') }}" class="text-muted">
                    {{ __('login.forgot_password') }}
                </a>
            </div>

            <div class="text-center mt-3">
                <span class="text-muted">{{ __('login.no_account') }}</span>
                <a href="{{ route('register') }}" class="text-success fw-semibold">
                    {{ __('login.register_link') }}
                </a>
            </div>

        </form>

    </x-auth-card>

</x-app-layout>