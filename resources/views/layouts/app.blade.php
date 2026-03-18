<!DOCTYPE html>
<html lang="en" style="background-color: #ffffff;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ticket Kinun - Your Ultimate Event Ticketing Platform')</title>
    <meta name="description" content="@yield('meta_description', 'Discover, book, and enjoy the best events. Ticket Kinun is your premier gateway to concerts, sports, festivals and more.')">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- Preload Critical Logo -->
    <link rel="preload" as="image" href="{{ asset('Blue_Simple_Technology_Logo.png') }}">

    <!-- DNS Prefetch & Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Critical Loader Styles (Inline for speed) -->
    <style>
        :root { color-scheme: light; }
        html, body { background-color: #ffffff !important; margin: 0; padding: 0; }
        #top-loader {
            position: fixed; top: 0; left: 0; width: 0%; height: 3px;
            background: linear-gradient(90deg, #520C6B, #FFE700);
            z-index: 10000; pointer-events: none; transition: width 0.1s ease-out;
        }
        [x-cloak] { display: none !important; }
    </style>

    <!-- Optimized Asset Bundle -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    @yield('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="overflow-x-hidden max-w-full">

    <!-- Top Loading Progress Bar -->
    <div id="top-loader"></div>

    <div id="swup-container" class="swup-transition-fade">
        @include('partials.header')

        <main class="pt-16 md:pt-32 lg:pt-32" id="main-content">
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    @yield('scripts')
</body>
</html>

