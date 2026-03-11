@extends('layouts.organizer')

@section('title', 'Organizer Dashboard')

@section('content')
<div class="p-8 animate-fadeInUp">
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
        <div class="bg-[#1B2B46] rounded-[3rem] p-10 text-white relative overflow-hidden flex flex-col justify-between">
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
</div>
@endsection

