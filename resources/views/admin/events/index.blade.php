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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',
                        'primary-dark': '#21032B',
                        secondary: '#21032B',
                        accent: '#FF7D52',
                        dark: '#0F172A',
                        'slate-custom': '#F8FAFC'
                    },
                    fontFamily: { outfit: ['Outfit', 'sans-serif'], plus: ['"Plus Jakarta Sans"', 'sans-serif'] },
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
<body class="bg-[#F8FAFC] text-slate-800 font-plus" x-data="{
    searchQuery: '',
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

    <div class="lg:ml-72 min-h-screen flex flex-col">
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

        <main class="p-8 flex-1">
            <!-- Page Title Area -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div>
                    <h1 class="font-outfit text-4xl font-black text-dark tracking-tighter mb-2">Event Control Center</h1>
                    <p class="text-slate-400 font-medium text-sm">Monitor, approve, and manage all events across the platform.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="bg-white text-dark px-6 py-3 rounded-2xl text-xs font-black tracking-widest uppercase border border-slate-100 flex items-center gap-2 hover:bg-slate-50 transition-all">
                        <i class="fas fa-download text-[10px]"></i> Export CSV
                    </button>
                    <a href="{{ route('admin.events.create') }}" class="bg-dark text-white px-6 py-3 rounded-2xl text-xs font-black tracking-widest uppercase flex items-center gap-2 hover:bg-primary transition-all shadow-xl shadow-dark/10">
                        <i class="fas fa-plus text-[10px]"></i> Create New Event
                    </a>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-3 text-center sm:text-left">Total Events</p>
                    <h3 class="font-outfit text-4xl font-black text-dark text-center sm:text-left">{{ $stats['total'] }}</h3>
                </div>
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-3 text-center sm:text-left">Pending Approval</p>
                    <h3 class="font-outfit text-4xl font-black text-accent text-center sm:text-left">{{ $stats['pending'] }}</h3>
                </div>
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-3 text-center sm:text-left">Active Today</p>
                    <h3 class="font-outfit text-4xl font-black text-emerald-500 text-center sm:text-left">{{ $stats['active_today'] }}</h3>
                </div>
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-3 text-center sm:text-left">Reported</p>
                    <h3 class="font-outfit text-4xl font-black text-red-500 text-center sm:text-left">{{ $stats['reported'] }}</h3>
                </div>
            </div>

            <!-- Main Listing Card -->
            <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-50 overflow-hidden min-h-[600px] flex flex-col">
                <!-- Search & Filters -->
                <div class="p-8 border-b border-slate-50 flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-slate-50/10">
                    <div>
                        <h2 class="font-outfit text-2xl font-black text-dark tracking-tighter mb-1">All Events</h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Comprehensive list of platform events and status.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="relative group">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs transition-colors group-focus-within:text-primary"></i>
                            <input type="text" x-model="searchQuery" placeholder="Search event or organizer..."
                                class="bg-white border border-slate-100 rounded-2xl pl-10 pr-6 py-3.5 text-xs font-bold focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary/20 transition-all w-full lg:w-72">
                        </div>
                        <button class="bg-white text-dark px-6 py-3.5 rounded-2xl text-[10px] font-black tracking-widest uppercase border border-slate-100 flex items-center gap-2 hover:bg-slate-50 transition-all">
                            <i class="fas fa-sliders-h"></i> Filter
                        </button>
                    </div>
                </div>

                <!-- Table Area -->
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50/50 text-[10px] font-black tracking-widest text-slate-400 uppercase">
                                <th class="px-8 py-6">Event ID</th>
                                <th class="px-8 py-6">Event Details</th>
                                <th class="px-8 py-6">Category</th>
                                <th class="px-8 py-6">Date & Venue</th>
                                <th class="px-8 py-6">Status</th>
                                <th class="px-8 py-6">Sales</th>
                                <th class="px-8 py-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($events as $event)
                            @php
                                $totalTickets = $event->ticketTypes->sum('quantity');
                                // Calculate sold tickets from attendees across all bookings
                                $soldTickets = \App\Models\BookingAttendee::whereIn('ticket_type_id', $event->ticketTypes->pluck('id'))->count();
                                $salesPercent = $totalTickets > 0 ? round(($soldTickets / $totalTickets) * 100) : 0;
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors group"
                                x-show="searchQuery === '' || '{{ strtolower($event->title) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($event->organizer) }}'.includes(searchQuery.toLowerCase())">
                                <td class="px-8 py-6">
                                    <span class="text-xs font-black text-slate-400 tracking-tighter uppercase">#{{ strtoupper(substr($event->id . '000000', 0, 6)) }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4 min-w-[300px]">
                                        <div class="w-16 h-12 rounded-xl bg-slate-100 flex-shrink-0 overflow-hidden shadow-inner">
                                            @if($event->image)
                                                <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-200">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-black text-dark text-sm tracking-tight mb-0.5 group-hover:text-primary transition-colors">{{ $event->title }}</p>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">by <span class="text-slate-500">{{ $event->organizer }}</span></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-4 py-1.5 rounded-full border border-slate-100 bg-white text-[9px] font-black text-slate-500 uppercase tracking-widest">{{ $event->category->name }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col gap-1.5 min-w-[180px]">
                                        <div class="flex items-center gap-2 text-slate-500">
                                            <i class="far fa-calendar-alt text-[10px]"></i>
                                            <span class="text-[11px] font-bold">{{ $event->date->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-slate-400">
                                            <i class="fas fa-map-marker-alt text-[10px]"></i>
                                            <span class="text-[10px] font-medium truncate max-w-[150px]">{{ $event->venue_name ?? $event->location }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @if($event->is_approved)
                                        <div class="flex items-center gap-2 bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-xl border border-emerald-100 max-w-fit">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                            <span class="text-[10px] font-black uppercase tracking-wider">Approved</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 bg-orange-50 text-orange-600 px-3 py-1.5 rounded-xl border border-orange-100 max-w-fit">
                                            <div class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></div>
                                            <span class="text-[10px] font-black uppercase tracking-wider">Pending</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <div class="w-24">
                                        <div class="flex justify-between items-end mb-2">
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $salesPercent }}% sold</span>
                                        </div>
                                        <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden shadow-inner">
                                            <div class="h-full bg-dark rounded-full shadow-sm shadow-dark/20 transition-all duration-1000" style="width: {{ $salesPercent }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        @if(!$event->is_approved)
                                        <form action="{{ route('admin.events.approve', $event) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-emerald-600 hover:text-white hover:scale-110 transition-all shadow-sm group/btn" title="Approve">
                                                <i class="fas fa-check text-[10px]"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-primary hover:text-white hover:scale-110 transition-all shadow-sm" title="Preview">
                                            <i class="far fa-eye text-[10px]"></i>
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-blue-600 hover:text-white hover:scale-110 transition-all shadow-sm" title="Edit">
                                            <i class="fas fa-pen text-[10px]"></i>
                                        </a>
                                        <button @click="confirmDelete('{{ route('admin.events.destroy', $event) }}', '{{ $event->title }}')"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-red-500 hover:text-white hover:scale-110 transition-all shadow-sm" title="Delete">
                                            <i class="fas fa-trash-alt text-[10px]"></i>
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

        <footer class="p-8 text-center text-[10px] font-black text-slate-400 tracking-widest uppercase border-t border-slate-50 bg-white">
            Ticket Kinun • Control Center Beta • © 2026
        </footer>
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
