<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Dashboard | Ticket Kinun</title>
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Auto Refresh for Live Stats -->
    <meta http-equiv="refresh" content="60">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',     // Brand Purple
                        secondary: '#21032B',   // Deep Plum
                        accent: '#FF7D52',      // Brand Orange
                        dark: '#0F172A',
                        'brand-purple': '#520C6B',
                    },
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        plus: ['"Plus Jakarta Sans"', 'sans-serif'],
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
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800">

    @include('scanner.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <!-- Header -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40 shadow-sm">
            <div class="flex items-center gap-4">
                <button class="lg:hidden text-dark"><i class="fas fa-bars"></i></button>
                <h1 class="font-outfit text-xl font-black text-dark tracking-tight">Scanner Terminal</h1>
            </div>
            <div class="flex items-center gap-6">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-black text-dark leading-none pb-1">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-bold text-primary uppercase tracking-widest italic">Authorized Scanner</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center font-black">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-10 max-w-[1600px] mx-auto w-full flex-grow">
            <!-- Hero Stats -->
            <div class="mb-12">
                <h2 class="font-outfit text-4xl font-black text-dark tracking-tighter mb-2 italic">Shift Overview</h2>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">{{ now()->format('l, F d, Y') }} — Processing events for {{ Auth::user()->organizer->name ?? 'Organizer' }}</p>
            </div>

            <!-- Dashboard Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
                <!-- Total Events Today -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-white group hover:scale-[1.02] transition-transform">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-500 flex items-center justify-center">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Today</span>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Live Events</p>
                    <p class="text-4xl font-outfit font-black text-dark tracking-tighter">{{ $totalEventsToday }}</p>
                </div>

                <!-- Total Purchased Tickets -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-white group hover:scale-[1.02] transition-transform">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-primary/5 text-primary flex items-center justify-center">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Check-in List</span>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Capacity</p>
                    <p class="text-4xl font-outfit font-black text-dark tracking-tighter">{{ $totalPurchasedToday }}</p>
                </div>

                <!-- Scanned Tickets -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-white group hover:scale-[1.02] transition-transform border-b-4 border-b-emerald-400">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50 px-2 py-1 rounded-lg">Real-time</span>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Checked In</p>
                    <p class="text-4xl font-outfit font-black text-dark tracking-tighter text-emerald-600">{{ $scannedToday }}</p>
                </div>

                <!-- Pending Tickets -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-white group hover:scale-[1.02] transition-transform border-b-4 border-b-amber-400">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Waiting</span>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Pending Entry</p>
                    <p class="text-4xl font-outfit font-black text-dark tracking-tighter text-amber-600">{{ $pendingToday }}</p>
                </div>

                <!-- Total Sales Today -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-white group hover:scale-[1.02] transition-transform border-b-4 border-b-primary">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-500 flex items-center justify-center">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest italic">Revenue</span>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Shift Value</p>
                    <p class="text-4xl font-outfit font-black text-dark tracking-tighter">৳{{ number_format($totalSalesToday, 0) }}</p>
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
