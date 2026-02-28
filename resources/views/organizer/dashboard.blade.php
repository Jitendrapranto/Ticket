<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Dashboard | Ticket Kinun</title>
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',     // Brand Purple
                        secondary: '#21032B',   // Deep Plum
                        accent: '#FF7D52',      // Brand Orange
                        dark: '#0F172A',
                        'slate-custom': '#F8FAFC'
                    },
                    brand: '#520C6B',
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        plus: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    boxShadow: {
                        'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.15)',
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
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Organizer Overview</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ now()->format('M d, Y • h:i A') }}</p>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center relative group">
                    <i class="fas fa-search absolute left-4 text-slate-400 text-xs"></i>
                    <input type="text" placeholder="Quick Search..." class="bg-slate-50 border border-slate-100 rounded-2xl pl-10 pr-6 py-2.5 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all w-64">
                </div>
                
                <button class="relative w-11 h-11 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-500 hover:bg-primary/5 transition-colors">
                    <i class="far fa-bell"></i>
                </button>
                
                <div class="flex items-center gap-3 pl-4 border-l border-slate-100 ml-2" x-data="{ open: false }">
                    <div class="relative">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 group focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-black text-dark group-hover:text-primary transition-colors">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] font-bold text-primary italic uppercase tracking-tighter">Organizer</p>
                            </div>
                            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary to-primary-dark p-0.5 shadow-premium group-hover:scale-105 transition-transform">
                                <div class="w-full h-full rounded-[14px] bg-white flex items-center justify-center overflow-hidden">
                                     <i class="fas fa-user-tie text-primary text-xs"></i>
                                </div>
                            </div>
                        </button>

                        <!-- Action Dropdown -->
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                            class="absolute right-0 mt-3 w-56 bg-white rounded-3xl shadow-2xl border border-slate-100 py-3 z-50 overflow-hidden"
                            style="display: none;">
                            
                            <div class="px-6 py-4 border-b border-slate-50 mb-2">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Authenticated As</p>
                                <p class="text-xs font-bold text-dark truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="/" target="_blank" class="flex items-center gap-4 px-6 py-3 text-slate-600 hover:text-primary hover:bg-primary/5 transition-all group">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center group-hover:bg-white shadow-sm transition-all text-xs"><i class="fas fa-external-link-alt"></i></div>
                                <span class="text-[11px] font-black uppercase tracking-wider">Live Site</span>
                            </a>

                            <div class="mt-2 pt-2 border-t border-slate-50">
                                <form action="{{ route('organizer.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-4 px-6 py-3 text-red-500 hover:bg-red-50 transition-all group">
                                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center group-hover:bg-white shadow-sm transition-all text-red-400 text-xs"><i class="fas fa-power-off"></i></div>
                                        <span class="text-[11px] font-black uppercase tracking-wider">Logout Portal</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Dashboard Content -->
        <main class="p-8 flex-1">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
                <!-- Total Events -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-slate-50 group hover:-translate-y-2 transition-all duration-500">
                    <div class="flex items-start justify-between mb-8">
                        <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 transition-all group-hover:bg-orange-600 group-hover:text-white">
                            <i class="fas fa-calendar-check text-xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-orange-50 text-orange-600 text-[10px] font-black rounded-full">ALL TIME</span>
                    </div>
                    <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-2">My Events</p>
                    <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter">{{ number_format($totalEvents) }}</h3>
                </div>

                <!-- Total Tickets -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-slate-50 group hover:-translate-y-2 transition-all duration-500">
                    <div class="flex items-start justify-between mb-8">
                        <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-primary transition-all group-hover:bg-primary group-hover:text-white">
                            <i class="fas fa-ticket-alt text-xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-full">TOTAL</span>
                    </div>
                    <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-2">Tickets Sold</p>
                    <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter">{{ number_format($totalTickets) }}</h3>
                </div>

                <!-- Gross Revenue -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-slate-50 group hover:-translate-y-2 transition-all duration-500">
                    <div class="flex items-start justify-between mb-8">
                        <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 transition-all group-hover:bg-blue-600 group-hover:text-white">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                    </div>
                    <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-2">Gross Revenue</p>
                    <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter">৳{{ number_format($grossRevenue, 2) }}</h3>
                </div>

                <!-- Net Earnings -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-slate-50 group hover:-translate-y-2 transition-all duration-500">
                    <div class="flex items-start justify-between mb-8">
                        <div class="w-14 h-14 bg-teal-50 rounded-2xl flex items-center justify-center text-teal-600 transition-all group-hover:bg-teal-600 group-hover:text-white">
                            <i class="fas fa-wallet text-xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black rounded-full">PROFIT</span>
                    </div>
                    <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-2">Net Earnings</p>
                    <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter">৳{{ number_format($netEarnings, 2) }}</h3>
                </div>
            </div>

            <!-- Grid Layout for Tables & Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Sales Table -->
                <div class="lg:col-span-2 bg-white rounded-[3rem] shadow-premium border border-slate-50 overflow-hidden">
                    <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
                        <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Recent Bookings</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50/20 text-[10px] font-black tracking-widest text-slate-400 uppercase border-b border-slate-50">
                                    <th class="px-8 py-5">Event</th>
                                    <th class="px-8 py-5">Customer</th>
                                    <th class="px-8 py-5">Amount</th>
                                    <th class="px-8 py-5">Status</th>
                                    <th class="px-8 py-5">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 font-medium text-sm">
                                @forelse($recentBookings as $booking)
                                <tr>
                                    <td class="px-8 py-6 font-bold text-dark">{{ $booking->event->title ?? 'N/A' }}</td>
                                    <td class="px-8 py-6 text-slate-500">{{ $booking->user->email ?? 'Guest' }}</td>
                                    <td class="px-8 py-6 font-black text-primary">৳{{ number_format($booking->total_amount, 2) }}</td>
                                    <td class="px-8 py-6">
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-lg">{{ strtoupper($booking->status) }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-[10px] font-bold text-slate-400">{{ $booking->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-10 text-center text-slate-400 font-black tracking-widest uppercase text-[10px]">No recent bookings.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Summary Side -->
                <div class="bg-[#21032B] rounded-[3rem] p-10 text-white relative overflow-hidden flex flex-col justify-between">
                    <div class="relative z-10">
                        <span class="text-white/40 font-black tracking-[0.3em] text-[10px] uppercase mb-12 block">Quick Actions</span>
                        <h3 class="font-outfit text-4xl font-black tracking-tighter mb-10 leading-none">Manage<br><span class="text-accent tracking-normal">Your</span> Events.</h3>
                        
                        <div class="space-y-4">
                            <a href="{{ route('organizer.events.create') }}" class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl hover:bg-white/10 transition-all border border-white/5">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-xs">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-black">Create Event</p>
                                </div>
                            </a>
                            <a href="{{ route('organizer.events.index') }}" class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl hover:bg-white/10 transition-all border border-white/5">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-xs">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-black">View All Events</p>
                                </div>
                            </a>
                            <a href="{{ route('organizer.reports.sales') }}" class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl hover:bg-white/10 transition-all border border-white/5">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-xs">
                                    <i class="fas fa-chart-line text-green-400"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-black">Sales Report</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="absolute -right-20 -bottom-20 opacity-10 blur-3xl w-96 h-96 bg-primary rounded-full pointer-events-none"></div>
                </div>
            </div>

        </main>
    </div>

    <!-- Toggle Sidebar Script -->
    <script>
        const sidebar = document.getElementById('organizer-sidebar');
        const toggleBtn = document.getElementById('toggle-sidebar');
        let isSidebarOpen = false;

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
    </script>
</body>
</html>
