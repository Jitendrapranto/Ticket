<!DOCTYPE html>
<html lang="en" style="overflow-x:hidden; background-color: #ffffff;">
<head>
    <!-- Critical: Force light mode and white background immediately to prevent dark flashing -->
    <style>
        :root { color-scheme: light; }
        html, body { 
            background-color: #ffffff !important; 
            background: #ffffff !important; 
            color: #000000; 
            visibility: visible !important; 
            opacity: 1 !important;
        }
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ticket Kinun - Your Ultimate Event Ticketing Platform')</title>
    <meta name="description" content="@yield('meta_description', 'Discover, book, and enjoy the best events. Ticket Kinun is your premier gateway to concerts, sports, festivals and more.')">

    <!-- DNS Prefetch & Preconnect for all CDN domains -->
    <link rel="dns-prefetch" href="https://cdn.tailwindcss.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Critical: Tailwind CDN (required for rendering) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',
                        secondary: '#1B2B46',
                        accent: '#2563EB',
                        dark: '#0F172A',
                        brand: '#520C6B',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'premium': '0 20px 50px -12px rgba(0, 0, 0, 0.08)',
                        'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.07)',
                    }
                }
            }
        }
    </script>

    <!-- Fonts: preload critical subset, swap display -->
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet"></noscript>

    <!-- Font Awesome: defer loading (non-critical for initial paint) -->
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>

    <!-- Alpine.js: deferred -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- SweetAlert2: lazy-loaded on first use -->
    <script>
        window._swalLoaded = false;
        window._swalQueue = [];
        function ensureSwal(cb) {
            if (window.Swal) { cb(); return; }
            if (!window._swalLoaded) {
                window._swalLoaded = true;
                var s = document.createElement('script');
                s.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                s.onload = function() {
                    window._swalQueue.forEach(function(fn) { fn(); });
                    window._swalQueue = [];
                    if (cb) cb();
                };
                document.head.appendChild(s);
            } else {
                window._swalQueue.push(cb);
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif !important; font-style: normal !important; }
        * { font-style: normal !important; }
        *:not(i):not([class*="fa"]) { font-family: 'Inter', sans-serif !important; }
        .fas, .far, .fab, .fa-solid, .fa-regular, .fa-brands { font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important; }
        i, em, q, dfn { font-style: normal !important; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp {
            animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .hero-banner { height: 600px; }
        @media (max-width: 768px) { .hero-banner { height: auto; min-height: 500px; } }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        .bento-card {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .bento-card:hover {
            transform: translateY(-8px) scale(1.01);
        }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: marquee 30s linear infinite;
        }
        .animate-marquee-slow {
            animation: marquee 150s linear infinite;
        }
        .pause-on-hover:hover .animate-marquee,
        .pause-on-hover:hover .animate-marquee-slow {
            animation-play-state: paused;
        }

        [x-cloak] { display: none !important; }

        /* ── Global horizontal overflow guard ── */
        html, body {
            overflow-x: hidden !important;
            max-width: 100vw;
            background-color: #ffffff !important;
        }
    </style>

    @yield('styles')
</head>
<body class="font-sans bg-[#fdfdfc] text-slate-900 leading-relaxed overflow-x-hidden max-w-full">

    @include('partials.header')

    <main class="pt-20 md:pt-36 lg:pt-40">
        @yield('content')
    </main>

    @include('partials.footer')

    <script>
        // ── Header scroll behavior ──
        window.addEventListener('scroll', function () {
            var header = document.querySelector('header');
            if (!header) return;
            if (window.scrollY > 50) { header.classList.add('shadow-md'); }
            else { header.classList.remove('shadow-md'); }
        });

        // ── Mobile Menu & Search ──
        // This script runs at the BOTTOM of body - DOM is already fully parsed.
        // DOMContentLoaded has already fired, so we use an IIFE instead.
        (function () {
            var menuBtn   = document.getElementById('mobile-menu-btn');
            var closeBtn  = document.getElementById('close-drawer');
            var drawer    = document.getElementById('mobile-drawer');
            var overlay   = document.getElementById('mobile-drawer-overlay');
            var srchBtn   = document.getElementById('mobile-search-btn');
            var srchBar   = document.getElementById('mobile-search-bar');

            function open() {
                if (!drawer || !overlay) return;
                drawer.classList.remove('translate-x-full');
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                overlay.classList.add('opacity-100');
                document.body.style.overflow = 'hidden';
            }
            function close() {
                if (!drawer || !overlay) return;
                drawer.classList.add('translate-x-full');
                overlay.classList.add('opacity-0', 'pointer-events-none');
                overlay.classList.remove('opacity-100');
                document.body.style.overflow = '';
            }

            if (menuBtn)  menuBtn.addEventListener('click', open);
            if (closeBtn) closeBtn.addEventListener('click', close);
            if (overlay)  overlay.addEventListener('click', close);

            if (drawer) {
                drawer.querySelectorAll('a').forEach(function (a) {
                    a.addEventListener('click', close);
                });
            }

            if (srchBtn && srchBar) {
                srchBtn.addEventListener('click', function () {
                    srchBar.classList.toggle('hidden');
                    if (!srchBar.classList.contains('hidden')) {
                        var inp = srchBar.querySelector('input');
                        if (inp) inp.focus();
                    }
                });
            }
        })();
    </script>
    @yield('scripts')
</body>
</html>
