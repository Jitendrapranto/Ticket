<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Organizer Dashboard') | Ticket Kinun</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Critical Loader Styles (Inline for speed) -->
    <style>
        :root { color-scheme: light; }
        html, body { background-color: #F1F5F9 !important; margin: 0; padding: 0; }
        #top-loader {
            position: fixed; top: 0; left: 0; width: 0%; height: 3px;
            background: linear-gradient(90deg, #520C6B, #FFE700);
            z-index: 10000; pointer-events: none; transition: width 0.1s ease-out;
        }
    </style>

    <!-- Optimized Asset Bundle -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased overflow-x-hidden">

    <!-- Top Loading Progress Bar -->
    <div id="top-loader"></div>

    @include('organizer.sidebar')

    <div id="swup-container" class="lg:ml-72 min-h-screen flex flex-col swup-transition-fade">
        <!-- Header / Topbar -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-8 z-40 transition-all duration-300 shadow-sm sticky top-0">
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
                            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary to-secondary p-0.5 shadow-premium group-hover:scale-105 transition-transform duration-300">
                                <div class="w-full h-full rounded-[14px] bg-white flex items-center justify-center overflow-hidden border border-white">
                                    @if(auth()->user()->avatar)
                                        <img loading="lazy" src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
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

        <main class="flex-1 p-6 lg:p-10" id="main-content">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>

