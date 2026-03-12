@extends('layouts.organizer')

@section('title', 'Audience Manager')
@section('header_title', 'Audience Manager')

@section('content')
<div class="p-8 animate-fadeInUp">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div>
            <h1 class="font-outfit text-4xl font-black text-dark tracking-tighter mb-2">Audience Manager</h1>
            <p class="text-slate-400 font-medium text-sm">Analyze and interact with customers engaged with your events.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('organizer.customers.export', request()->all()) }}" class="bg-white border border-slate-200 text-slate-600 px-6 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                <i class="fas fa-download text-[10px]"></i> Export Database
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <!-- Total Audience -->
        <div class="bg-gradient-to-br from-sky-500 to-indigo-600 p-8 rounded-[2rem] shadow-xl shadow-sky-500/20 flex items-center justify-between group hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-white/60 uppercase tracking-widest mb-4">Unique Customers</p>
                <h3 class="text-4xl font-outfit font-black text-white tracking-tighter mb-1">{{ number_format($totalCustomers) }}</h3>
                <p class="text-[11px] font-bold text-sky-200">Direct Reach</p>
            </div>
            <div class="w-14 h-14 bg-white/20 text-white rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-all relative z-10 backdrop-blur-md">
                <i class="fas fa-user-friends"></i>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-8 rounded-[2rem] shadow-xl shadow-emerald-500/20 flex items-center justify-between group hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-white/60 uppercase tracking-widest mb-4">Event Bookings</p>
                <h3 class="text-4xl font-outfit font-black text-white tracking-tighter mb-1">{{ number_format($totalBookings) }}</h3>
                <p class="text-[11px] font-bold text-emerald-200 uppercase tracking-widest">Confirmed Seats</p>
            </div>
            <div class="w-14 h-14 bg-white/20 text-white rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-all relative z-10 backdrop-blur-md">
                <i class="fas fa-ticket-alt"></i>
            </div>
        </div>

        <!-- Avg. Lifetime Value -->
        <div class="bg-gradient-to-br from-orange-400 to-amber-600 p-8 rounded-[2rem] shadow-xl shadow-orange-500/20 flex items-center justify-between group hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-white/60 uppercase tracking-widest mb-4">Audience Value (LTV)</p>
                <h3 class="text-4xl font-outfit font-black text-white tracking-tighter mb-1">৳{{ number_format($averageLTV, 2) }}</h3>
                <p class="text-[11px] font-bold text-orange-200 uppercase tracking-tight">Avg per customer</p>
            </div>
            <div class="w-14 h-14 bg-white/20 text-white rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-all relative z-10 backdrop-blur-md">
                <i class="fas fa-chart-pie"></i>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-[2.5rem] shadow-premium border border-white overflow-hidden min-h-[500px]">
        <div class="p-10 flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-slate-50">
            <div>
                <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-1">Customer Database</h3>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Profiles engaged with your ticketing projects.</p>
            </div>
            <div class="flex items-center gap-4">
                <form action="{{ route('organizer.customers.index') }}" method="GET" x-data="{ searchQuery: '{{ request('search') }}' }" class="relative group">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 transition-colors group-focus-within:text-primary"></i>
                    <input type="text" name="search" x-model="searchQuery" @input.debounce.500ms="$el.form.submit()" placeholder="Filter entries..." class="bg-slate-50 border-none rounded-xl pl-12 pr-6 py-3.5 text-xs font-semibold focus:ring-2 focus:ring-primary/10 transition-all w-72">
                </form>

                <div x-data="{ filterOpen: false, customDateOpen: false }" class="relative z-50">
                    <button @click="filterOpen = !filterOpen" class="bg-slate-50 text-slate-600 px-6 py-3.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-100 transition-all flex items-center gap-3">
                        <i class="fas fa-calendar-alt text-[10px]"></i> {{ request('date_filter') ? ucwords(str_replace('_', ' ', request('date_filter'))) : 'Time Frame' }}
                    </button>
                    
                    <div x-show="filterOpen" x-cloak @click.away="filterOpen = false" x-transition class="absolute right-0 mt-3 w-64 bg-white rounded-[2rem] shadow-2xl border border-slate-100 overflow-hidden py-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-6 py-3">Selection</p>
                        <div class="px-2 space-y-1">
                            <a href="{{ request()->fullUrlWithQuery(['date_filter' => 'today']) }}" class="block px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl transition-all {{ request('date_filter') == 'today' ? 'bg-primary/5 text-primary' : '' }}">Today</a>
                            <a href="{{ request()->fullUrlWithQuery(['date_filter' => 'this_week']) }}" class="block px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl transition-all {{ request('date_filter') == 'this_week' ? 'bg-primary/5 text-primary' : '' }}">This Week</a>
                            <a href="{{ request()->fullUrlWithQuery(['date_filter' => 'this_month']) }}" class="block px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl transition-all {{ request('date_filter') == 'this_month' ? 'bg-primary/5 text-primary' : '' }}">This Month</a>
                            <a href="{{ request()->fullUrlWithQuery(['date_filter' => 'this_year']) }}" class="block px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl transition-all {{ request('date_filter') == 'this_year' ? 'bg-primary/5 text-primary' : '' }}">This Year</a>
                        </div>
                        
                        @if(request('date_filter'))
                            <div class="mt-4 pt-4 border-t border-slate-50 px-6">
                                <a href="{{ request()->fullUrlWithQuery(['date_filter' => null, 'date_from' => null, 'date_to' => null]) }}" class="text-[10px] font-black text-red-500 uppercase tracking-widest hover:underline flex items-center gap-2"><i class="fas fa-times"></i> Clear Filters</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/30 text-[10px] font-black tracking-widest text-slate-400 uppercase border-b border-slate-50">
                        <th class="px-10 py-5">Customer Profile</th>
                        <th class="px-8 py-5">Engagement</th>
                        <th class="px-8 py-5 text-center">First Order</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-10 py-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-slate-50/40 transition-all group">
                        <td class="px-10 py-7">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-white border border-slate-100 shadow-sm flex items-center justify-center overflow-hidden">
                                    <div class="w-full h-full bg-primary/5 flex items-center justify-center">
                                        <span class="text-sm font-black text-primary uppercase">{{ substr($customer->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-dark group-hover:text-primary transition-colors leading-tight">{{ $customer->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 mt-1">{{ $customer->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-7">
                            <div class="flex items-center gap-2">
                                 <span class="text-sm font-black text-dark tracking-tight">{{ $customer->bookings_count }}</span>
                                 <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Tickets</span>
                            </div>
                        </td>
                        <td class="px-8 py-7 text-center">
                            <div class="inline-flex items-center gap-2 text-slate-500 font-bold text-[10px] bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100 uppercase tracking-widest">
                                {{ $customer->created_at->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="px-8 py-7 text-center">
                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-[0.1em] bg-emerald-50 text-emerald-500 border border-emerald-100">
                                ACTIVE
                            </span>
                        </td>
                        <td class="px-10 py-7 text-right">
                            <a href="{{ route('organizer.customers.show', $customer->id) }}" class="inline-flex items-center gap-2 bg-slate-50 text-slate-400 p-3 rounded-xl hover:bg-primary hover:text-white transition-all shadow-sm">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">No customer data available for this range.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-10 bg-slate-50/50 border-t border-slate-50 flex items-center justify-between">
            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest leading-none">
                Mapped Base: <span class="text-dark">{{ $customers->total() }}</span> unique identities.
            </p>
            <div>
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
