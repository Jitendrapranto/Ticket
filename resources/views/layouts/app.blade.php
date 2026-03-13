<!DOCTYPE html>
<html lang="en" style="overflow-x:hidden;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ticket Kinun - Your Ultimate Event Ticketing Platform')</title>

    <!-- Removed Blocking FOUC style to improve TTI/LCP loading speed -->

    <!-- Tailwind & Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',     // Brand Purple
                        secondary: '#1B2B46',   // Deep Plum
                        accent: '#2563EB',      // Vibrant Blue
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

        /* ── Global horizontal overflow guard ── */
        html, body {
            overflow-x: hidden !important;
            max-width: 100vw;
        }
        section, .section-wrap {
            max-width: 100%;
            overflow-x: hidden;
        }

        /* Reveal once ready */
        html.ready {
            visibility: visible;
            opacity: 1;
            transition: opacity 0.15s ease-in;
        }
    </style>

    <!-- Reveal page once Tailwind is ready -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.documentElement.classList.add('ready');
        });
        // Fallback: reveal after short delay even if DOMContentLoaded already fired
        setTimeout(function() {
            document.documentElement.classList.add('ready');
        }, 100);
    </script>

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
