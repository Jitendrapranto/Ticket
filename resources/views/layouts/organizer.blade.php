<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Organizer Dashboard') | Ticket Kinun</title>

    <!-- Prevent FOUC: Hide body until styles are ready -->
    <style>
        html { visibility: hidden; opacity: 0; }
    </style>

    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',     // Brand Purple
                        secondary: '#1B2B46',   // Deep Plum
                        accent: '#FF7D52',      // Brand Orange
                        dark: '#0F172A',
                        'slate-custom': '#F8FAFC',
                        'brand-red': '#E11D48',
                    },
                    brand: '#520C6B',
                    fontFamily: {
                        sans: ['Arial', 'Helvetica', 'sans-serif'],
                        outfit: ['Arial', 'Helvetica', 'sans-serif'],
                        plus: ['Arial', 'Helvetica', 'sans-serif'],
                    },
                    boxShadow: {
                        'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.15)',
                        'soft': '0 10px 30px -5px rgba(0, 0, 0, 0.05)',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; }
        * { font-style: normal !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        [x-cloak] { display: none !important; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fadeIn { animation: fadeIn 0.4s ease-out forwards; }

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

    @stack('styles')
</head>
<body class="bg-[#F1F5F9] text-slate-800">

    <!-- Sidebar Inclusion -->
    @include('organizer.sidebar')

    <!-- Main Content Wrapper -->
    <div class="lg:ml-72 min-h-screen flex flex-col">

        <!-- Header / Topbar -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40 transition-all duration-300 shadow-sm">
            <div class="flex items-center gap-4">
                <!-- Mobile Toggle -->
                <button id="toggle-sidebar" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="hidden md:block">
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight">@yield('header_title', 'Organizer Overview')</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ now()->format('M d, Y • l') }}</p>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-4">

                <div class="flex items-center gap-3 ml-2" x-data="{ open: false }">
                    <div class="relative">
                        <button @click="open = !open" class="flex items-center gap-3 group focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-black text-dark group-hover:text-primary transition-colors">{{ auth()->user()->name }}</p>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-0.5">Organizer Account</p>
                            </div>
                            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary to-primary-dark p-0.5 shadow-premium group-hover:scale-105 transition-transform duration-300">
                                <div class="w-full h-full rounded-[14px] bg-white flex items-center justify-center overflow-hidden border border-white">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-user-tie text-primary text-xs"></i>
                                    @endif
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-[8px] text-slate-300 transition-transform group-hover:text-primary" :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <!-- Action Dropdown -->
                        <div x-show="open"
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-3"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-3"
                            class="absolute right-0 mt-4 w-60 bg-white rounded-[2rem] shadow-2xl border border-slate-100 py-4 z-50 overflow-hidden"
                            style="display: none;">

                            <div class="px-6 pb-4 border-b border-slate-50 mb-3 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-primary/5 flex items-center justify-center text-primary text-xs shrink-0">
                                    <i class="fas fa-id-badge"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-0.5">Organizer ID</p>
                                    <p class="text-[10px] font-bold text-dark truncate">ID-{{ str_pad(auth()->id(), 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>

                            <a href="{{ route('profile') }}" class="flex items-center gap-4 px-6 py-3.5 text-slate-600 hover:text-primary hover:bg-primary/5 transition-all group/item">
                                <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center group-hover/item:bg-white shadow-sm transition-all text-xs">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-widest">Manage Profile</span>
                            </a>

                            <a href="/" target="_blank" class="flex items-center gap-4 px-6 py-3.5 text-slate-600 hover:text-emerald-500 hover:bg-emerald-50 transition-all group/item">
                                <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center group-hover/item:bg-white shadow-sm transition-all text-xs">
                                    <i class="fas fa-external-link-alt"></i>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-widest">Live Preview</span>
                            </a>

                            <div class="mt-3 pt-3 border-t border-slate-50 px-4">
                                <form action="{{ route('organizer.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-4 px-4 py-3.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-2xl transition-all group/logout shadow-sm hover:shadow-red-500/20">
                                        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center group-hover/logout:bg-white/20 shadow-sm transition-all text-xs">
                                            <i class="fas fa-power-off"></i>
                                        </div>
                                        <span class="text-[10px] font-black uppercase tracking-widest">Sign Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    <!-- Toggle Sidebar Script -->
    <script>
        const sidebar = document.getElementById('organizer-sidebar');
        const toggleBtn = document.getElementById('toggle-sidebar');
        let isSidebarOpen = false;

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', () => {
                isSidebarOpen = !isSidebarOpen;
                if(isSidebarOpen) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
