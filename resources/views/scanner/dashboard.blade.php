<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Dashboard | Ticket Kinun</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Critical Loader Styles (Inline for speed) -->
    <style>
        :root { color-scheme: light; }
        html, body { background-color: #F8FAFC !important; margin: 0; padding: 0; }
        #top-loader {
            position: fixed; top: 0; left: 0; width: 0%; height: 3px;
            background: linear-gradient(90deg, #520C6B, #FFE700);
            z-index: 10000; pointer-events: none; transition: width 0.1s ease-out;
        }
    </style>

    <!-- Optimized Asset Bundle -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Auto Refresh for Live Stats -->
    <meta http-equiv="refresh" content="60">

    @stack('styles')
</head>
<body class="bg-[#F8FAFC] text-slate-800" x-data="{ sidebarOpen: false }">

    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden" 
         style="display: none;">
    </div>

    @include('scanner.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <!-- Header -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40 shadow-sm">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden text-dark w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="font-outfit text-xl font-black text-dark tracking-tight">Scanner Terminal</h1>
            </div>
            
            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" class="flex items-center gap-4 hover:opacity-80 transition-opacity focus:outline-none">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-black text-dark leading-none pb-1">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-bold text-primary uppercase tracking-widest leading-none">Authorized Scanner</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-primary/10 border-2 border-white shadow-lg flex items-center justify-center overflow-hidden">
                        @if(Auth::user()->avatar)
                            <img loading="lazy" src="{{ asset('storage/'.Auth::user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-primary text-sm font-black">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <i class="fas fa-chevron-down text-[10px] text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                     class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-premium border border-slate-100 overflow-hidden z-50"
                     style="display: none;">
                    
                    <div class="p-4 border-b border-slate-50 bg-slate-50/50">
                        <p class="text-xs font-black text-dark leading-none mb-1">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-bold text-slate-400 truncate">{{ Auth::user()->email }}</p>
                    </div>

                    <div class="p-2">
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-slate-600 hover:text-primary hover:bg-primary/5 rounded-xl transition-all group">
                            <i class="fas fa-user-circle text-slate-400 group-hover:text-primary transition-colors"></i> My Profile
                        </a>
                        
                        <hr class="my-2 border-slate-50">
                        
                        <button onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();" 
                                class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                            <i class="fas fa-sign-out-alt"></i> Sign Out
                        </button>
                        
                        <form id="logout-form-header" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-10 max-w-[1600px] mx-auto w-full flex-grow">
            <!-- Hero Stats -->
            <div class="mb-12">
                <h2 class="font-outfit text-4xl font-black text-dark tracking-tighter mb-2">Shift Overview</h2>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">{{ now()->format('l, F d, Y') }} — Processing events for {{ Auth::user()->organizer->name ?? 'Organizer' }}</p>
            </div>

            <!-- Dashboard Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-12">
                <!-- Total Events Today -->
                <div class="bg-white p-6 rounded-[2rem] shadow-premium border border-white group hover:scale-[1.02] transition-transform flex flex-col justify-center min-h-[160px]">
                    <div class="flex items-center gap-3 mb-4 relative z-10 overflow-hidden">
                        <div class="shrink-0 w-10 h-10 rounded-xl bg-sky-50 text-sky-500 flex items-center justify-center text-sm">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <h3 class="font-outfit text-2xl font-black text-dark tracking-tighter truncate" title="{{ $totalEventsToday }}">{{ $totalEventsToday }}</h3>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Live Events</p>
                            <span class="text-[8px] font-black text-slate-300 uppercase tracking-widest">Today</span>
                        </div>
                    </div>
                </div>

                <!-- Total Purchased Tickets -->
                <div class="bg-white p-6 rounded-[2rem] shadow-premium border border-white group hover:scale-[1.02] transition-transform flex flex-col justify-center min-h-[160px]">
                    <div class="flex items-center gap-3 mb-4 relative z-10 overflow-hidden">
                        <div class="shrink-0 w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center text-sm">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h3 class="font-outfit text-2xl font-black text-dark tracking-tighter truncate" title="{{ $totalPurchasedToday }}">{{ $totalPurchasedToday }}</h3>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Capacity</p>
                            <span class="text-[8px] font-black text-slate-300 uppercase tracking-widest">Check-in List</span>
                        </div>
                    </div>
                </div>

                <!-- Scanned Tickets -->
                <div class="bg-white p-6 rounded-[2rem] shadow-premium border border-white group hover:scale-[1.02] transition-transform border-b-4 border-b-emerald-400 flex flex-col justify-center min-h-[160px]">
                    <div class="flex items-center gap-3 mb-4 relative z-10 overflow-hidden">
                        <div class="shrink-0 w-10 h-10 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-sm">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <h3 class="font-outfit text-2xl font-black text-emerald-600 tracking-tighter truncate" title="{{ $scannedToday }}">{{ $scannedToday }}</h3>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Checked In</p>
                            <span class="text-[8px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50 px-1.5 py-0.5 rounded-md">Real-time</span>
                        </div>
                    </div>
                </div>

                <!-- Pending Tickets -->
                <div class="bg-white p-6 rounded-[2rem] shadow-premium border border-white group hover:scale-[1.02] transition-transform border-b-4 border-b-amber-400 flex flex-col justify-center min-h-[160px]">
                    <div class="flex items-center gap-3 mb-4 relative z-10 overflow-hidden">
                        <div class="shrink-0 w-10 h-10 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-sm">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="font-outfit text-2xl font-black text-amber-600 tracking-tighter truncate" title="{{ $pendingToday }}">{{ $pendingToday }}</h3>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Pending Entry</p>
                            <span class="text-[8px] font-black text-slate-300 uppercase tracking-widest">Waiting</span>
                        </div>
                    </div>
                </div>

                <!-- Total Sales Today -->
                <div class="bg-white p-6 rounded-[2rem] shadow-premium border border-white group hover:scale-[1.02] transition-transform border-b-4 border-b-primary flex flex-col justify-center min-h-[160px]">
                    <div class="flex items-center gap-3 mb-4 relative z-10 overflow-hidden">
                        <div class="shrink-0 w-10 h-10 rounded-xl bg-violet-50 text-violet-500 flex items-center justify-center text-sm">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <h3 class="font-outfit text-xl font-black text-dark tracking-tighter truncate" title="৳{{ number_format($totalSalesToday, 0) }}">৳{{ number_format($totalSalesToday, 0) }}</h3>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Shift Value</p>
                            <span class="text-[8px] font-black text-slate-300 uppercase tracking-widest">Revenue</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-fadeInUp">
                <a href="{{ route('scanner.scan') }}" class="relative overflow-hidden group bg-primary rounded-[3rem] p-12 text-white shadow-2xl transition-all hover:-translate-y-2">
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center mb-6 text-2xl group-hover:scale-110 transition-transform">
                            <i class="fas fa-camera"></i>
                        </div>
                        <h3 class="font-outfit text-4xl font-black mb-2 tracking-tighter">QR Scanner</h3>
                        <p class="text-white/60 font-bold text-xs uppercase tracking-[0.2em]">Open Camera Interface</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 opacity-10 group-hover:opacity-20 transition-all">
                        <i class="fas fa-qrcode text-[240px]"></i>
                    </div>
                </a>

                <a href="{{ route('scanner.manual-checkin') }}" class="relative overflow-hidden group bg-dark rounded-[3rem] p-12 text-white shadow-2xl transition-all hover:-translate-y-2">
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center mb-6 text-2xl group-hover:scale-110 transition-transform">
                            <i class="fas fa-keyboard"></i>
                        </div>
                        <h3 class="font-outfit text-4xl font-black mb-2 tracking-tighter">Manual Check-in</h3>
                        <p class="text-white/60 font-bold text-xs uppercase tracking-[0.2em]">Enter Ticket Serial Meta</p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 opacity-10 group-hover:opacity-20 transition-all">
                        <i class="fas fa-fingerprint text-[240px]"></i>
                    </div>
                </a>
            </div>
        </main>
    </div>

</body>
</html>
