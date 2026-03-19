@extends('admin.dashboard')

@section('admin_content')
<div x-data="{
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
    <div class="animate-fadeIn">


        <!-- Page Title Area - Compact & Professional -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6 shrink-0">
            <div>
                <h1 class="font-outfit text-4xl font-black text-dark tracking-tighter mb-1">Event <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Control Center.</span></h1>
                <p class="text-slate-400 font-bold uppercase text-[9px] tracking-[0.4em]">Operations Hub • Control & Monitoring</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.events.export') }}" target="_blank" class="bg-white text-dark px-6 py-2.5 rounded-xl text-[9px] font-black tracking-widest uppercase border border-slate-100 flex items-center gap-2 hover:bg-slate-50 transition-all shadow-sm">
                    <i class="fas fa-download text-[10px] text-primary"></i> Export System Logs
                </a>
                <a href="{{ route('admin.events.create') }}" class="bg-dark text-white px-6 py-2.5 rounded-xl text-[9px] font-black tracking-widest uppercase flex items-center gap-2 hover:bg-primary transition-all shadow-xl shadow-dark/10">
                    <i class="fas fa-plus text-[10px] text-accent"></i> Create New Event
                </a>
            </div>
        </div>

        <!-- Event-Specific Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 shrink-0">
            <div class="group relative bg-[#4F46E5] px-8 py-10 rounded-xl shadow-lg overflow-hidden transition-all hover:-translate-y-2 h-40 flex flex-col justify-center">
                <div class="relative z-10 text-white flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-white/50 uppercase mb-3">Total Records</p>
                        <h3 class="font-outfit text-4xl font-black tracking-tighter">{{ $stats['total'] }}</h3>
                    </div>
                    <i class="fa-solid fa-layer-group text-6xl opacity-20 group-hover:scale-110 transition-transform"></i>
                </div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            </div>

            <div class="group relative bg-[#F59E0B] px-8 py-10 rounded-xl shadow-lg overflow-hidden transition-all hover:-translate-y-2 h-40 flex flex-col justify-center">
                <div class="relative z-10 text-white flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-white/50 uppercase mb-3 text-shadow-sm">In Review Control</p>
                        <h3 class="font-outfit text-4xl font-black tracking-tighter text-shadow-md">{{ $stats['pending'] }}</h3>
                    </div>
                    <i class="fa-solid fa-hourglass-half text-6xl opacity-20 group-hover:scale-110 transition-transform"></i>
                </div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            </div>

            <div class="group relative bg-[#10B981] px-8 py-10 rounded-xl shadow-lg overflow-hidden transition-all hover:-translate-y-2 h-40 flex flex-col justify-center">
                <div class="relative z-10 text-white flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-white/50 uppercase mb-3">Verified Base</p>
                        <h3 class="font-outfit text-4xl font-black tracking-tighter">{{ $stats['active_today'] }}</h3>
                    </div>
                    <i class="fa-solid fa-check-double text-6xl opacity-20 group-hover:scale-110 transition-transform"></i>
                </div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            </div>

            <div class="group relative bg-[#EF4444] px-8 py-10 rounded-xl shadow-lg overflow-hidden transition-all hover:-translate-y-2 h-40 flex flex-col justify-center">
                <div class="relative z-10 text-white flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-white/50 uppercase mb-3">Anomalies</p>
                        <h3 class="font-outfit text-4xl font-black tracking-tighter">{{ $stats['reported'] }}</h3>
                    </div>
                    <i class="fa-solid fa-triangle-exclamation text-6xl opacity-20 group-hover:scale-110 transition-transform"></i>
                </div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            </div>
        </div>

        <!-- Main Listing Table -->
        <div class="bg-white rounded-[2rem] shadow-premium border border-slate-50 flex-1 flex flex-col mb-4">
            <!-- Search & Filters -->
            <div class="p-6 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-slate-50/5 shrink-0">
                <div>
                    <h2 class="font-outfit text-2xl font-black text-dark tracking-tighter mb-0.5">Authenticated Events</h2>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Platform Operational Master List</p>
                </div>
                <div class="flex items-center gap-3">
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
                        <input type="text" x-model="searchQuery" placeholder="Search events..."
                            class="bg-white border border-slate-100 rounded-2xl pl-10 pr-6 py-3.5 text-xs font-bold focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary/20 transition-all w-full lg:w-72">
                    </div>
                    <button @click="searchQuery = ''; dateRange = 'all'" class="bg-white text-dark px-6 py-3.5 rounded-2xl text-[10px] font-black tracking-widest uppercase border border-slate-100 hover:bg-slate-50 transition-all shadow-sm">
                        Reset
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left table-fixed min-w-[1000px]">
                    <thead>
                        <tr class="bg-slate-50/50 text-[10px] font-black tracking-widest text-slate-400 uppercase border-b border-slate-100">
                            <th class="w-[8%] px-4 py-4 text-center">ID</th>
                            <th class="w-[28%] px-4 py-4">Event Details</th>
                            <th class="w-[12%] px-4 py-4 text-center">Category</th>
                            <th class="w-[18%] px-4 py-4">Date & Venue</th>
                            <th class="w-[12%] px-4 py-4 text-center">Status</th>
                            <th class="w-[12%] px-4 py-4">Sales</th>
                            <th class="w-[10%] px-4 py-4 text-right pr-6">Actions</th>
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
                            
                            $searchContent = addslashes(strtolower($event->title . ' ' . $event->organizer . ' ' . ($event->category->name ?? '')));
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors group h-24"
                            x-show="(searchQuery === '' || '{{ $searchContent }}'.includes(searchQuery.toLowerCase())) && (dateRange === 'all' || (dateRange === 'today' && {{ $isToday }}) || (dateRange === 'week' && {{ $isWeek }}) || (dateRange === 'month' && {{ $isMonth }}) || (dateRange === 'year' && {{ $isYear }}))">
                            <td class="px-4 py-4 text-center">
                                <span class="text-[10px] font-black text-slate-400 tracking-wider uppercase">#{{ strtoupper(substr($event->id . '0000', 0, 6)) }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex-shrink-0 overflow-hidden shadow-inner hidden md:block border border-slate-100">
                                        @if($event->image)
                                            <img loading="lazy" src="{{ $event->image_url }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-200">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-black text-dark text-sm tracking-tight mb-0.5 group-hover:text-primary transition-colors truncate">{{ $event->title }}</p>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tight truncate">by {{ $event->organizer }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="px-2 py-1 rounded-md border border-slate-200 bg-white text-[9px] font-black text-slate-600 uppercase tracking-widest whitespace-nowrap shadow-sm block w-full truncate">{{ $event->category->name }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2 text-slate-500">
                                        <i class="far fa-calendar-alt text-[9px] flex-shrink-0"></i>
                                        <span class="text-[10px] font-bold truncate">{{ $event->date->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-slate-400">
                                        <i class="fas fa-map-marker-alt text-[9px] flex-shrink-0"></i>
                                        <span class="text-[9px] font-medium truncate">{{ $event->venue_name ?? $event->location }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                @if($event->is_approved)
                                    <div class="inline-flex items-center justify-center gap-1.5 bg-emerald-50 text-emerald-600 px-2.5 py-1.5 rounded-lg border border-emerald-100 w-full">
                                        <div class="w-1.5 h-1.5 flex-shrink-0 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                        <span class="text-[9px] font-black uppercase tracking-wider truncate">Active</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center justify-center gap-1.5 bg-orange-50 text-orange-600 px-2.5 py-1.5 rounded-lg border border-orange-100 w-full">
                                        <div class="w-1.5 h-1.5 flex-shrink-0 rounded-full bg-orange-500 animate-pulse"></div>
                                        <span class="text-[9px] font-black uppercase tracking-wider truncate">Review</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <div class="w-full">
                                    <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden shadow-inner flex">
                                        <div class="h-full bg-primary rounded-full shadow-sm shadow-primary/30 transition-all duration-1000" style="width: {{ $salesPercent }}%"></div>
                                    </div>
                                    <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest mt-1.5 block whitespace-nowrap">{{ $salesPercent }}% Sold</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-right pr-6">
                                <div class="flex justify-end items-center gap-1.5">
                                    @if(!$event->is_approved)
                                    <form action="{{ route('admin.events.approve', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-emerald-600 hover:text-white hover:scale-110 transition-all shadow-sm group/btn" title="Approve">
                                            <i class="fas fa-check text-[9px]"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="w-7 h-7 flex items-center justify-center rounded-lg bg-slate-50 text-slate-600 hover:bg-primary hover:text-white hover:scale-110 transition-all shadow-sm" title="Preview">
                                        <i class="far fa-eye text-[10px]"></i>
                                    </a>
                                    <a href="{{ route('admin.events.edit', $event) }}" class="w-7 h-7 flex items-center justify-center rounded-lg bg-slate-50 text-slate-600 hover:bg-blue-600 hover:text-white hover:scale-110 transition-all shadow-sm" title="Edit">
                                        <i class="fas fa-pen text-[9px]"></i>
                                    </a>
                                    <button @click="confirmDelete('{{ route('admin.events.destroy', $event) }}', '{{ addslashes($event->title) }}')"
                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-slate-50 text-red-400 hover:bg-red-500 hover:text-white hover:scale-110 transition-all shadow-sm" title="Delete">
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
                                <p class="text-slate-400 text-sm font-medium">Try adjusting your search filters.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Modal Overlay -->
    <div x-show="deleteModal" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="deleteModal = false"></div>
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl relative z-10 p-10 text-center animate-fadeInUp">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-8 animate-bounce">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="font-outfit text-2xl font-black text-dark mb-4">Confirm Deletion</h3>
            <p class="text-slate-400 text-sm mb-8">Are you sure you want to remove <span class="font-bold text-dark" x-text="eventName"></span>?</p>
            <div class="flex gap-4">
                <button @click="deleteModal = false" class="flex-1 py-4 rounded-2xl bg-slate-50 text-slate-500 font-black uppercase tracking-widest text-[10px]">Cancel</button>
                <form :action="deleteUrl" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-4 rounded-2xl bg-red-500 text-white font-black uppercase tracking-widest text-[10px]">Yes, Remove</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
