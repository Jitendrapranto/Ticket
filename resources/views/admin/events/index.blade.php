<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Control Center | Ticket Kinun Admin</title>
    <!-- Prevent FOUC: Hide body until styles are ready -->
    <style>
        html { visibility: hidden; opacity: 0; }
        html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',
                        'primary-dark': '#1B2B46',
                        secondary: '#1B2B46',
                        accent: '#FF7D52',
                        dark: '#0F172A',
                        'slate-custom': '#F8FAFC'
                    },
                    fontFamily: { outfit: ['Arial', 'Helvetica', 'sans-serif'], plus: ['Arial', 'Helvetica', 'sans-serif'] },
                    boxShadow: { 'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.15)' }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <!-- Reveal page once Tailwind is ready -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.documentElement.classList.add('ready');
        });
        setTimeout(function() { document.documentElement.classList.add('ready'); }, 100);
    </script>
</head>
<body class="bg-[#F8FAFC] text-slate-800 font-plus h-screen overflow-hidden" x-data="{
    searchQuery: '',
    dateRange: 'all',
    deleteModal: false,
    deleteUrl: '',
    eventName: '',
    confirmDelete(url, name) {
        this.deleteUrl = url;
        this.eventName = name;
        this.deleteModal = true;
    }
}">
    @include('admin.sidebar')

    <div class="lg:ml-72 h-screen flex flex-col overflow-hidden">
        <!-- Top Header -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <button id="toggle-sidebar" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="relative group hidden md:block">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" placeholder="Search platform resources..." class="bg-slate-50 border border-slate-100 rounded-2xl pl-10 pr-6 py-2.5 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all w-64 uppercase tracking-tighter">
                </div>
            </div>

            <div class="flex items-center gap-6">
                <button class="relative text-slate-400 hover:text-primary transition-colors">
                    <i class="far fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-accent rounded-full border-2 border-white"></span>
                </button>
                <div class="flex items-center gap-3 pl-6 border-l border-slate-100">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-black text-dark">Super Admin</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-8 flex-1 overflow-hidden flex flex-col">
            <!-- Page Title Area - Compact & Professional -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6 shrink-0">
                <div>
                    <h1 class="font-outfit text-4xl font-black text-dark tracking-tighter mb-1">Event <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Control Center.</span></h1>
                    <p class="text-slate-400 font-bold uppercase text-[9px] tracking-[0.4em]">Operations Hub • Control & Monitoring</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.events.export') }}" class="bg-white text-dark px-6 py-2.5 rounded-xl text-[9px] font-black tracking-widest uppercase border border-slate-100 flex items-center gap-2 hover:bg-slate-50 transition-all shadow-sm">
                        <i class="fas fa-download text-[10px] text-primary"></i> Export System Logs
                    </a>
                    <a href="{{ route('admin.events.create') }}" class="bg-dark text-white px-6 py-2.5 rounded-xl text-[9px] font-black tracking-widest uppercase flex items-center gap-2 hover:bg-primary transition-all shadow-xl shadow-dark/10">
                        <i class="fas fa-plus text-[10px] text-accent"></i> Create New Event
                    </a>
                </div>
            </div>

            <!-- Stats Overview - Low Profile, High Impact -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 shrink-0">
                <div class="group relative bg-[#4F46E5] px-8 py-7 rounded-[1.8rem] shadow-lg overflow-hidden transition-all hover:-translate-y-1">
                    <div class="relative z-10 text-white flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-black tracking-[0.3em] text-white/50 uppercase mb-2">Total Records</p>
                            <h3 class="font-outfit text-3xl font-black tracking-tight">{{ $stats['total'] }}</h3>
                        </div>
                        <i class="fa-solid fa-calendar-days text-4xl opacity-20"></i>
                    </div>
                </div>

                <div class="group relative bg-[#F59E0B] px-8 py-7 rounded-[1.8rem] shadow-lg overflow-hidden transition-all hover:-translate-y-1">
                    <div class="relative z-10 text-white flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-black tracking-[0.3em] text-white/50 uppercase mb-2">In Review</p>
                            <h3 class="font-outfit text-3xl font-black tracking-tight">{{ $stats['pending'] }}</h3>
                        </div>
                        <i class="fa-solid fa-clock-rotate-left text-4xl opacity-20"></i>
                    </div>
                </div>

                <div class="group relative bg-[#10B981] px-8 py-7 rounded-[1.8rem] shadow-lg overflow-hidden transition-all hover:-translate-y-1">
                    <div class="relative z-10 text-white flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-black tracking-[0.3em] text-white/50 uppercase mb-2">Verified Base</p>
                            <h3 class="font-outfit text-3xl font-black tracking-tight">{{ $stats['active_today'] }}</h3>
                        </div>
                        <i class="fa-solid fa-circle-check text-4xl opacity-20"></i>
                    </div>
                </div>

                <div class="group relative bg-[#EF4444] px-8 py-7 rounded-[1.8rem] shadow-lg overflow-hidden transition-all hover:-translate-y-1">
                    <div class="relative z-10 text-white flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-black tracking-[0.3em] text-white/50 uppercase mb-2">Anomalies</p>
                            <h3 class="font-outfit text-3xl font-black tracking-tight">{{ $stats['reported'] }}</h3>
                        </div>
                        <i class="fa-solid fa-flag text-4xl opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Main Listing Card - Maximized Vertical Area -->
            <div class="bg-white rounded-[2rem] shadow-premium border border-slate-50 flex-1 overflow-hidden flex flex-col mb-4">
                <!-- Search & Filters -->
                <div class="p-6 border-b border-slate-50 flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-slate-50/5 shrink-0">
                    <div>
                        <h2 class="font-outfit text-2xl font-black text-dark tracking-tighter mb-0.5">Authenticated Events</h2>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Platform Operational Master List</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Date Range Dropdown -->
                        <div class="relative group">
                            <i class="fas fa-filter absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs transition-colors group-focus-within:text-primary z-10"></i>
                            <select x-model="dateRange"
                                class="bg-white border border-slate-100 rounded-2xl pl-10 pr-6 py-3.5 text-xs font-black focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary/20 transition-all w-48 appearance-none cursor-pointer uppercase tracking-widest">
                                <option value="all">All Time</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                                <option value="year">This Year</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 text-[10px] pointer-events-none"></i>
                        </div>
                        <div class="relative group">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs transition-colors group-focus-within:text-primary"></i>
                            <input type="text" x-model="searchQuery" placeholder="Search events, organizers, categories..."
                                class="bg-white border border-slate-100 rounded-2xl pl-10 pr-6 py-3.5 text-xs font-bold focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary/20 transition-all w-full lg:w-72">
                        </div>
                        <button @click="searchQuery = ''; dateRange = 'all'" class="bg-white text-dark px-6 py-3.5 rounded-2xl text-[10px] font-black tracking-widest uppercase border border-slate-100 hover:bg-slate-50 transition-all shadow-sm">
                            Reset
                        </button>
                    </div>
                </div>

                <!-- Table Area - Strictly No X-Scroll, 4 Rows Height -->
                <div class="overflow-y-auto flex-1 no-scrollbar overflow-x-hidden">
                    <table class="w-full text-left table-fixed">
                        <thead>
                            <tr class="bg-slate-50/50 text-[10px] font-black tracking-widest text-slate-400 uppercase">
                                <th class="px-8 py-5 w-24">ID</th>
                                <th class="px-8 py-5">Event Details</th>
                                <th class="px-8 py-5 w-32 text-center">Category</th>
                                <th class="px-8 py-5 w-44">Date & Venue</th>
                                <th class="px-8 py-5 w-36 text-center">Status</th>
                                <th class="px-8 py-5 w-32">Sales</th>
                                <th class="px-8 py-5 w-48 text-right pr-12">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($events as $event)
                            @php
                                $totalTickets = $event->ticketTypes->sum('quantity');
                                $soldTickets = \App\Models\BookingAttendee::whereIn('ticket_type_id', $event->ticketTypes->pluck('id'))->count();
                                $salesPercent = $totalTickets > 0 ? round(($soldTickets / $totalTickets) * 100) : 0;
                                
                                $evDate = $event->date;
                                $isToday = $evDate->isToday() ? 'true' : 'false';
                                $isWeek = $evDate->between(now()->startOfWeek(), now()->endOfWeek()) ? 'true' : 'false';
                                $isMonth = $evDate->between(now()->startOfMonth(), now()->endOfMonth()) ? 'true' : 'false';
                                $isYear = $evDate->between(now()->startOfYear(), now()->endOfYear()) ? 'true' : 'false';
                                
                                $searchContent = strtolower($event->title . ' ' . $event->organizer . ' ' . $event->category->name);
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors group h-24"
                                x-show="(searchQuery === '' || '{{ $searchContent }}'.includes(searchQuery.toLowerCase())) && (dateRange === 'all' || (dateRange === 'today' && {{ $isToday }}) || (dateRange === 'week' && {{ $isWeek }}) || (dateRange === 'month' && {{ $isMonth }}) || (dateRange === 'year' && {{ $isYear }}))">
                                <td class="px-8 py-6">
                                    <span class="text-xs font-black text-slate-400 tracking-tighter uppercase">#{{ strtoupper(substr($event->id . '000000', 0, 6)) }}</span>
                                </td>
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-10 rounded-xl bg-slate-100 flex-shrink-0 overflow-hidden shadow-inner hidden sm:block">
                                            @if($event->image)
                                                <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-200">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="font-black text-dark text-sm tracking-tight mb-0.5 group-hover:text-primary transition-colors line-clamp-1">{{ $event->title }}</p>
                                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tight truncate">by {{ $event->organizer }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <span class="px-3 py-1.5 rounded-full border border-slate-100 bg-white text-[8px] font-black text-slate-500 uppercase tracking-widest">{{ $event->category->name }}</span>
                                </td>
                                <td class="px-8 py-4">
                                    <div class="flex flex-col gap-1 min-w-0">
                                        <div class="flex items-center gap-2 text-slate-500">
                                            <i class="far fa-calendar-alt text-[9px]"></i>
                                            <span class="text-[10px] font-bold">{{ $event->date->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-slate-400">
                                            <i class="fas fa-map-marker-alt text-[9px]"></i>
                                            <span class="text-[9px] font-medium truncate">{{ $event->venue_name ?? $event->location }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    @if($event->is_approved)
                                        <div class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-xl border border-emerald-100">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                            <span class="text-[9px] font-black uppercase tracking-wider">Active</span>
                                        </div>
                                    @else
                                        <div class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 px-3 py-1.5 rounded-xl border border-orange-100">
                                            <div class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></div>
                                            <span class="text-[9px] font-black uppercase tracking-wider">Review</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-4">
                                    <div class="w-full">
                                        <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden shadow-inner">
                                            <div class="h-full bg-dark rounded-full shadow-sm shadow-dark/20 transition-all duration-1000" style="width: {{ $salesPercent }}%"></div>
                                        </div>
                                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest mt-1.5 block">{{ $salesPercent }}% Sold</span>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-right pr-6">
                                    <div class="flex justify-end items-center gap-1.5">
                                        @if(!$event->is_approved)
                                        <form action="{{ route('admin.events.approve', $event) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-emerald-600 hover:text-white hover:scale-110 transition-all shadow-sm group/btn" title="Approve">
                                                <i class="fas fa-check text-[9px]"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-primary hover:text-white hover:scale-110 transition-all shadow-sm" title="Preview">
                                            <i class="far fa-eye text-[9px]"></i>
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event) }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-blue-600 hover:text-white hover:scale-110 transition-all shadow-sm" title="Edit">
                                            <i class="fas fa-pen text-[9px]"></i>
                                        </a>
                                        <button @click="confirmDelete('{{ route('admin.events.destroy', $event) }}', '{{ $event->title }}')"
                                                class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-red-500 hover:text-white hover:scale-110 transition-all shadow-sm" title="Delete">
                                            <i class="fas fa-trash-alt text-[9px]"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-8 py-24 text-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-200 shadow-inner">
                                        <i class="fas fa-calendar-times text-3xl"></i>
                                    </div>
                                    <h3 class="font-outfit text-xl font-black text-dark mb-1">No Events Found</h3>
                                    <p class="text-slate-400 text-sm font-medium">Try adjusting your search filters or create a new event.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Delete Modal -->
    <div x-show="deleteModal" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="deleteModal = false"></div>
        <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl relative z-10 p-10 text-center">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-8 animate-bounce">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="font-outfit text-2xl font-black text-dark mb-4">Confirm Deletion</h3>
            <p class="text-slate-400 text-sm mb-8">Are you sure you want to remove <span class="font-bold text-dark" x-text="eventName"></span>?</p>
            <div class="flex gap-4">
                <button @click="deleteModal = false" class="flex-1 py-4 rounded-2xl bg-slate-50 text-slate-500 font-bold uppercase tracking-widest text-xs">Cancel</button>
                <form :action="deleteUrl" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-4 rounded-2xl bg-red-500 text-white font-bold uppercase tracking-widest text-xs">Yes, Remove</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-sidebar');
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                    setTimeout(() => overlay.classList.toggle('opacity-0'), 10);
                });
            }
            if (overlay) {
                overlay.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden', 'opacity-0');
                });
            }
        });
    </script>
</body>
</html>
