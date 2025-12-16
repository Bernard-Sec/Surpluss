<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Surplus') }}</title>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    @livewireStyles
</head>

<body class="bg-light">

    {{-- Surplus Navbar --}}
    @include('components.navbar')

    <main class="py-4">
        {{ $slot }}
    </main>

    @include('components.footer')

    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
