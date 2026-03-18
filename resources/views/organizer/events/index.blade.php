@extends('layouts.organizer')

@section('title', 'My Control Center')
@section('header_title', 'My Control Center')

@section('content')
<div class="p-8 animate-fadeInUp" x-data="{
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
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Total Events -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-900 p-8 rounded-[2rem] shadow-xl shadow-slate-900/10 group hover:-translate-y-1 transition-all relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/5 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <p class="text-[10px] font-black tracking-[0.2em] text-white/40 uppercase mb-3 relative z-10">Total Events</p>
            <h3 class="font-outfit text-4xl font-black text-white relative z-10">{{ $stats['total'] }}</h3>
        </div>

        <!-- Pending Approval -->
        <div class="bg-gradient-to-br from-orange-400 to-orange-600 p-8 rounded-[2rem] shadow-xl shadow-orange-500/20 group hover:-translate-y-1 transition-all relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <p class="text-[10px] font-black tracking-[0.2em] text-white/60 uppercase mb-3 relative z-10">Pending Approval</p>
            <h3 class="font-outfit text-4xl font-black text-white relative z-10">{{ $stats['pending'] }}</h3>
        </div>

        <!-- Active Today -->
        <div class="bg-gradient-to-br from-emerald-400 to-emerald-600 p-8 rounded-[2rem] shadow-xl shadow-emerald-500/20 group hover:-translate-y-1 transition-all relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <p class="text-[10px] font-black tracking-[0.2em] text-white/60 uppercase mb-3 relative z-10">Active Today</p>
            <h3 class="font-outfit text-4xl font-black text-white relative z-10">{{ $stats['active_today'] }}</h3>
        </div>

        <!-- Total Sales -->
        <div class="bg-gradient-to-br from-indigo-500 to-primary p-8 rounded-[2rem] shadow-xl shadow-primary/20 group hover:-translate-y-1 transition-all relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <p class="text-[10px] font-black tracking-[0.2em] text-white/60 uppercase mb-3 relative z-10">Total Sales</p>
            @php
                $totalSoldOverall = 0;
                foreach($events as $e) {
                    $totalSoldOverall += \App\Models\BookingAttendee::whereIn('ticket_type_id', $e->ticketTypes->pluck('id'))->count();
                }
            @endphp
            <h3 class="font-outfit text-4xl font-black text-white relative z-10">{{ $totalSoldOverall }}</h3>
        </div>
    </div>

    <!-- Main Listing Card -->
    <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-50 overflow-hidden min-h-[600px] flex flex-col">
        <!-- Search & Filters -->
        <div class="p-8 border-b border-slate-50 flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-slate-50/10">
            <div>
                <h2 class="font-outfit text-2xl font-black text-dark tracking-tighter mb-1">Recent Listings</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Track your individual event performance.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative group">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs transition-colors group-focus-within:text-primary"></i>
                    <input type="text" x-model="searchQuery" placeholder="Search event..."
                        class="bg-white border border-slate-100 rounded-2xl pl-10 pr-6 py-3.5 text-xs font-bold focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary/20 transition-all w-full lg:w-72">
                </div>
                <a href="{{ route('organizer.events.create') }}" class="bg-dark text-white px-6 py-3.5 rounded-2xl text-[10px] font-black tracking-widest uppercase flex items-center gap-2 hover:bg-primary transition-all shadow-xl shadow-dark/10">
                    <i class="fas fa-plus"></i> New Event
                </a>
            </div>
        </div>

        <!-- Table Area -->
        <div class="flex-1">
            <table class="w-full text-left table-fixed">
                <thead>
                    <tr class="bg-slate-50/50 text-[10px] font-black tracking-widest text-slate-400 uppercase">
                        <th class="px-4 py-6 font-black w-[10%] min-w-[70px]">Event ID</th>
                        <th class="px-4 py-6 font-black w-[28%] min-w-[150px]">Event Details</th>
                        <th class="px-4 py-6 font-black w-[12%] min-w-[90px]">Category</th>
                        <th class="px-4 py-6 font-black w-[22%] min-w-[150px]">Date & Venue</th>
                        <th class="px-4 py-6 font-black w-[16%] min-w-[120px]">Status</th>
                        <th class="px-4 py-6 font-black w-[12%] min-w-[110px] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($events as $event)
                    @php
                        $totalTickets = $event->ticketTypes->sum('quantity');
                        $soldTickets = \App\Models\BookingAttendee::whereIn('ticket_type_id', $event->ticketTypes->pluck('id'))->count();
                        $salesPercent = $totalTickets > 0 ? round(($soldTickets / $totalTickets) * 100) : 0;
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors group"
                        x-show="searchQuery === '' || '{{ strtolower($event->title) }}'.includes(searchQuery.toLowerCase())">
                        <td class="px-4 py-6">
                            <span class="text-[10px] font-black text-slate-400 tracking-tighter uppercase break-words">{{ $event->event_code ?? '#ORD-'.strtoupper(substr($event->id . '000000', 0, 4)) }}</span>
                        </td>
                        <td class="px-4 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-10 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden shadow-inner border border-slate-100">
                                    @if($event->image)
                                        <img loading="lazy" src="{{ $event->image_url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-200 uppercase text-[8px] font-black">N/A</div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-black text-dark text-xs tracking-tight mb-0.5 group-hover:text-primary transition-colors truncate" title="{{ $event->title }}">{{ $event->title }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tight truncate">{{ $event->category->name ?? 'Events' }} Exp.</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-6">
                            <span class="px-3 py-1 rounded-full border border-slate-100 bg-white text-[8px] font-black text-slate-400 uppercase tracking-widest break-words text-center block">{{ $event->category->name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-4 py-6">
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-2 text-slate-500">
                                    <i class="far fa-calendar-alt text-[9px] shrink-0"></i>
                                    <span class="text-[10px] font-bold">{{ $event->date->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-400">
                                    <i class="fas fa-map-marker-alt text-[9px] shrink-0"></i>
                                    <span class="text-[9px] font-medium truncate" title="{{ $event->venue_name ?? $event->location }}">{{ $event->venue_name ?? $event->location }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-6">
                            @if($event->is_approved)
                                <div class="flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-lg border border-emerald-100 w-fit">
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></div>
                                    <span class="text-[8px] font-black uppercase tracking-wider">Approved</span>
                                </div>
                            @else
                                <div class="flex items-center gap-1.5 bg-orange-50 text-orange-600 px-2.5 py-1 rounded-lg border border-orange-100 w-fit">
                                    <div class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse shrink-0"></div>
                                    <span class="text-[8px] font-black uppercase tracking-wider">Pending</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 xl:px-6 py-6 text-right">
                            <div class="flex justify-end items-center gap-1.5">
                                <a href="{{ route('organizer.events.bookings', $event) }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-violet-600 hover:text-white hover:scale-110 transition-all shadow-sm group/btn" title="Attendees">
                                    <i class="fas fa-users text-[10px]"></i>
                                </a>
                                <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-primary hover:text-white hover:scale-110 transition-all shadow-sm" title="Preview">
                                    <i class="far fa-eye text-[10px]"></i>
                                </a>
                                <a href="{{ route('organizer.events.edit', $event) }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-blue-600 hover:text-white hover:scale-110 transition-all shadow-sm" title="Edit">
                                    <i class="fas fa-pen text-[10px]"></i>
                                </a>
                                <button @click="confirmDelete('{{ route('organizer.events.destroy', $event) }}', '{{ $event->title }}')"
                                        class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-red-500 hover:text-white hover:scale-110 transition-all shadow-sm" title="Delete">
                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-200">
                                <i class="fas fa-calendar-times text-3xl"></i>
                            </div>
                            <h3 class="font-outfit text-xl font-black text-dark mb-1">No Listings Yet</h3>
                            <p class="text-slate-400 text-sm font-medium">Start by creating your first event experience.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="deleteModal" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="deleteModal = false"></div>
        <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl relative z-10 p-10 text-center animate-fadeInUp">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-8 animate-bounce">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="font-outfit text-2xl font-black text-dark mb-4">Are you sure?</h3>
            <p class="text-slate-400 text-sm mb-8">This will permanently delete <span class="font-bold text-dark" x-text="eventName"></span> and all its data.</p>
            <div class="flex gap-4">
                <button @click="deleteModal = false" class="flex-1 py-4 rounded-2xl bg-slate-50 text-slate-500 font-black uppercase tracking-widest text-[10px]">Cancel</button>
                <form :action="deleteUrl" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-4 rounded-2xl bg-red-500 text-white font-black uppercase tracking-widest text-[10px] shadow-lg shadow-red-500/20">Confirm Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
