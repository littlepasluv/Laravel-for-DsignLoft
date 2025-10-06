<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DsignLoft') }} - @yield('title', 'Creative Brief Flow')</title>

    <!-- Favicon -->
    <link href="https://assets.zyrosite.com/YleqxM2lNkfl3kLp/favicon-dsignloft-YKbl23wxwNT9WK37.png" rel="icon" type="image/png"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Custom CSS -->
    @stack('styles')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head-scripts')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @yield('content')
    </div>

    <!-- Firebase Config -->
    <script type="module">
        // Firebase configuration will be loaded here
        @stack('firebase-config')
    </script>

    @stack('scripts')
</body>
</html>

