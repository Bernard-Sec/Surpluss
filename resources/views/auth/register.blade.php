<x-app-layout>

    <x-auth-card :title="__('register.title')">

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <label class="fw-semibold">{{ __('register.name') }}</label>
            <input type="text" name="name" class="form-control mb-3" required>

            <label class="fw-semibold">{{ __('register.email') }}</label>
            <input type="email" name="email" class="form-control mb-3" required>

            <label class="fw-semibold">{{ __('register.password') }}</label>
            <input type="password" name="password" class="form-control mb-3" required>

            <label class="fw-semibold">{{ __('register.phone') }}</label>
            <input type="text" name="phone" class="form-control mb-3">

            <label class="fw-semibold">{{ __('register.address') }}</label>
            <input type="text" name="address" class="form-control mb-3">

            <label class="fw-semibold">{{ __('register.role') }}</label>
            <select name="role" class="form-select mb-3" required>
                <option value="" disabled selected>{{ __('register.select_role') }}</option>
                <option value="donor">{{ __('register.role_donor') }}</option>
                <option value="receiver">{{ __('register.role_receiver') }}</option>
            </select>

            <button class="btn btn-success w-100 mt-2">{{ __('register.btn_submit') }}</button>

            <div class="text-center mt-3">
                <span class="text-muted">{{ __('register.have_account') }}</span>
                <a href="{{ route('login') }}" class="text-success fw-semibold">
                    {{ __('register.login_link') }}
                </a>
            </div>
        </form>

    </x-auth-card>

</x-app-layout>