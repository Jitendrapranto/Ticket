@extends('layouts.organizer')

@section('title', 'Organizer Dashboard')

@section('content')
<div class="p-8 animate-fadeInUp">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
        <!-- Total Events -->
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 p-8 rounded-[2.5rem] shadow-xl shadow-orange-500/20 group hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="flex items-start justify-between mb-8 relative z-10">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-[10px] font-black rounded-full uppercase tracking-widest">Global</span>
            </div>
            <p class="text-[10px] font-black tracking-[0.2em] text-white/50 uppercase mb-2 relative z-10">Events Hosted</p>
            <h3 class="font-outfit text-4xl font-black text-white tracking-tighter relative z-10">{{ number_format($totalEvents) }}</h3>
        </div>

        <!-- Total Tickets -->
        <div class="bg-gradient-to-br from-indigo-500 to-primary p-8 rounded-[2.5rem] shadow-xl shadow-primary/20 group hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="flex items-start justify-between mb-8 relative z-10">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white">
                    <i class="fas fa-ticket-alt text-xl"></i>
                </div>
                <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-[10px] font-black rounded-full uppercase tracking-widest">Sold</span>
            </div>
            <p class="text-[10px] font-black tracking-[0.2em] text-white/50 uppercase mb-2 relative z-10">Tickets Distributed</p>
            <h3 class="font-outfit text-4xl font-black text-white tracking-tighter relative z-10">{{ number_format($totalTickets) }}</h3>
        </div>

        <!-- Gross Revenue -->
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/20 group hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="flex items-start justify-between mb-8 relative z-10">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-[10px] font-black rounded-full uppercase tracking-widest">Gross</span>
            </div>
            <p class="text-[10px] font-black tracking-[0.2em] text-white/50 uppercase mb-2 relative z-10">Gross Revenue</p>
            <h3 class="font-outfit text-3xl font-black text-white tracking-tighter relative z-10 whitespace-nowrap">৳{{ number_format($grossRevenue, 2) }}</h3>
        </div>

        <!-- Net Earnings -->
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-8 rounded-[2.5rem] shadow-xl shadow-emerald-500/20 group hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="flex items-start justify-between mb-8 relative z-10">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white">
                    <i class="fas fa-wallet text-xl"></i>
                </div>
                <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-[10px] font-black rounded-full uppercase tracking-widest">Profit</span>
            </div>
            <p class="text-[10px] font-black tracking-[0.2em] text-white/50 uppercase mb-2 relative z-10">Net Earnings</p>
            <h3 class="font-outfit text-3xl font-black text-white tracking-tighter relative z-10 whitespace-nowrap">৳{{ number_format($netEarnings, 2) }}</h3>
        </div>
    </div>

    <!-- Grid Layout for Tables & Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Sales Table -->
        <div class="lg:col-span-2 bg-white rounded-[3rem] shadow-premium border border-white overflow-hidden relative">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
            <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/30 relative z-10">
                <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Recent Bookings</h3>
                <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
            </div>
            <div class="overflow-x-auto relative z-10">
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
                        <tr class="hover:bg-primary/5 transition-colors">
                            <td class="px-8 py-6 font-bold text-dark">{{ $booking->event->title ?? 'N/A' }}</td>
                            <td class="px-8 py-6 text-slate-500">{{ $booking->user->email ?? 'Guest' }}</td>
                            <td class="px-8 py-6">
                                <span class="font-black text-primary">৳{{ number_format($booking->total_amount, 2) }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black border border-emerald-100">{{ strtoupper($booking->status) }}</span>
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

        <!-- Summary Side / Quick Actions -->
        <div class="bg-[#1B2B46] rounded-[3rem] p-10 text-white relative overflow-hidden flex flex-col justify-between shadow-2xl shadow-blue-900/40">
            <!-- Dynamic Blobs for "Colorfull" look -->
            <div class="absolute -right-20 -top-20 opacity-40 blur-3xl w-64 h-64 bg-primary rounded-full pointer-events-none"></div>
            <div class="absolute -left-20 bottom-20 opacity-20 blur-3xl w-64 h-64 bg-accent rounded-full pointer-events-none"></div>
            
            <div class="relative z-10">
                <span class="text-white/40 font-black tracking-[0.3em] text-[10px] uppercase mb-12 block">Quick Actions</span>
                <h3 class="font-outfit text-4xl font-black tracking-tighter mb-10 leading-none">Manage<br><span class="text-accent tracking-normal">Your</span> Events.</h3>
                
                <div class="space-y-4">
                    <a href="{{ route('organizer.events.create') }}" class="flex items-center gap-4 bg-white/5 p-5 rounded-2xl hover:bg-white/10 transition-all border border-white/5 group">
                        <div class="w-12 h-12 rounded-xl bg-accent shadow-lg shadow-accent/20 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black">Create Event</p>
                            <p class="text-[9px] text-white/40 font-bold uppercase tracking-widest mt-1">Add New Entry</p>
                        </div>
                    </a>
                    <a href="{{ route('organizer.events.index') }}" class="flex items-center gap-4 bg-white/5 p-5 rounded-2xl hover:bg-white/10 transition-all border border-white/5 group">
                        <div class="w-12 h-12 rounded-xl bg-primary shadow-lg shadow-primary/20 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black">View All Events</p>
                            <p class="text-[9px] text-white/40 font-bold uppercase tracking-widest mt-1">Manage Ledger</p>
                        </div>
                    </a>
                    <a href="{{ route('organizer.reports.sales') }}" class="flex items-center gap-4 bg-white/5 p-5 rounded-2xl hover:bg-white/10 transition-all border border-white/5 group">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500 shadow-lg shadow-emerald-500/20 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black">Sales Report</p>
                            <p class="text-[9px] text-white/40 font-bold uppercase tracking-widest mt-1">Financial Insights</p>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="relative z-10 mt-12 p-6 bg-white/5 rounded-[2rem] border border-white/5 backdrop-blur-sm">
                <p class="text-[10px] font-black text-white/60 uppercase tracking-widest mb-1">System Status</p>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-widest">All Nodes Active</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

