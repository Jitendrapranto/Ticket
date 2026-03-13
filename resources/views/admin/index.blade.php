@extends('admin.dashboard')

@section('admin_content')
<!-- Welcome Message & Platform Clock -->
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6 animate-fadeIn">
    <div>
        <h1 class="text-4xl md:text-5xl font-black text-dark tracking-tighter mb-2">Welcome Back, <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Administrator.</span></h1>
        <p class="text-slate-400 font-bold uppercase text-xs tracking-[0.4em]">Operations Hub • {{ now()->format('l, M d') }}</p>
    </div>
    <div class="bg-white px-8 py-4 rounded-[1.5rem] border border-slate-100 shadow-soft flex items-center gap-6">
        <div class="text-right">
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1">Global Signal</p>
            <p class="text-sm font-black text-dark uppercase">{{ now()->format('h:i:s A') }}</p>
        </div>
        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 shadow-inner">
            <i class="fas fa-satellite-dish animate-pulse"></i>
        </div>
    </div>
</div>

<!-- Dynamic Statistics Command Center -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5 mb-8">
    <!-- Total Sales -->
    <div class="group relative bg-gradient-to-br from-primary to-[#3a084c] p-6 rounded-[2rem] shadow-premium transition-all duration-300 overflow-hidden">
        <div class="relative z-10 text-white">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-4">
                <i class="fa-solid fa-sack-dollar text-xl"></i>
            </div>
            <p class="text-xs font-black tracking-widest text-white/60 uppercase mb-1">Total Sales</p>
            <h3 class="text-2xl font-black tracking-tighter">৳{{ number_format($totalSales, 0) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-10 text-white group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-sack-dollar text-8xl"></i>
        </div>
    </div>

    <!-- Today's Sale -->
    <div class="group relative bg-gradient-to-br from-[#10B981] to-emerald-700 p-6 rounded-[2rem] shadow-premium transition-all duration-300 overflow-hidden">
        <div class="relative z-10 text-white">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-4">
                <i class="fa-solid fa-chart-line text-xl"></i>
            </div>
            <p class="text-xs font-black tracking-widest text-white/60 uppercase mb-1">Today's Sale</p>
            <h3 class="text-2xl font-black tracking-tighter">৳{{ number_format($todaySales, 0) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-10 text-white group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-chart-line text-8xl"></i>
        </div>
    </div>

    <!-- Total Events -->
    <div class="group relative bg-gradient-to-br from-accent to-blue-700 p-6 rounded-[2rem] shadow-premium transition-all duration-300 overflow-hidden">
        <div class="relative z-10 text-white">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-4">
                <i class="fa-solid fa-calendar-days text-xl"></i>
            </div>
            <p class="text-xs font-black tracking-widest text-white/60 uppercase mb-1">Total Events</p>
            <h3 class="text-2xl font-black tracking-tighter">{{ number_format($totalEvents) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-10 text-white group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-calendar-days text-8xl"></i>
        </div>
    </div>

    <!-- Today's Events -->
    <div class="group relative bg-gradient-to-br from-[#8B5CF6] to-violet-800 p-6 rounded-[2rem] shadow-premium transition-all duration-300 overflow-hidden">
        <div class="relative z-10 text-white">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-4">
                <i class="fa-solid fa-calendar-check text-xl"></i>
            </div>
            <p class="text-xs font-black tracking-widest text-white/60 uppercase mb-1">Today's Events</p>
            <h3 class="text-2xl font-black tracking-tighter">{{ number_format($todayEvents) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-10 text-white group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-calendar-check text-8xl"></i>
        </div>
    </div>

    <!-- Total Organizer -->
    <div class="group relative bg-gradient-to-br from-secondary to-dark p-6 rounded-[2rem] shadow-premium transition-all duration-300 overflow-hidden">
        <div class="relative z-10 text-white">
            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mb-4">
                <i class="fa-solid fa-user-tie text-xl"></i>
            </div>
            <p class="text-xs font-black tracking-widest text-white/60 uppercase mb-1">Total Organizer</p>
            <h3 class="text-2xl font-black tracking-tighter">{{ number_format($totalOrganizers) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-10 text-white group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-user-tie text-8xl"></i>
        </div>
    </div>

    <!-- Organizer Request (CLICKABLE) -->
    <a href="{{ route('admin.organizer-requests.index') }}" class="group relative bg-gradient-to-br from-vibrant to-rose-600 p-6 rounded-[2rem] shadow-vibrant hover:-translate-y-1 transition-all duration-300 overflow-hidden border-2 border-white/10">
        <div class="relative z-10 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-user-plus text-xl text-white"></i>
                </div>
                <div class="px-3 py-1 bg-white/20 rounded-full border border-white/20">
                    <span class="text-[9px] font-black uppercase tracking-tighter text-white">Action Needed</span>
                </div>
            </div>
            <p class="text-xs font-black tracking-widest text-white/80 uppercase mb-1">Organizer Request</p>
            <h3 class="text-2xl font-black tracking-tighter">{{ number_format($organizerRequests) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-20 text-white group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-id-card text-8xl"></i>
        </div>
    </a>

    <!-- Event Approval Request (CLICKABLE) -->
    <a href="{{ route('admin.events.index') }}" class="group relative bg-white p-6 rounded-[2rem] shadow-premium hover:-translate-y-1 transition-all duration-300 overflow-hidden border border-slate-100">
        <div class="relative z-10 text-dark">
            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform border border-primary/10">
                <i class="fa-solid fa-shield-check text-xl text-primary"></i>
            </div>
            <p class="text-xs font-black tracking-widest text-slate-400 uppercase mb-1">Event Approval</p>
            <h3 class="text-2xl font-black tracking-tighter text-primary">{{ number_format($eventApprovalRequests) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-5 text-primary group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-clipboard-check text-8xl"></i>
        </div>
    </a>

    <!-- Payment Approval (CLICKABLE) -->
    <a href="{{ route('admin.finance.bookings.index', ['status' => 'pending']) }}" class="group relative bg-white p-6 rounded-[2rem] shadow-premium hover:-translate-y-1 transition-all duration-300 overflow-hidden border border-slate-100">
        <div class="relative z-10 text-dark">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform border border-amber-500/10">
                <i class="fa-solid fa-receipt text-xl text-amber-500"></i>
            </div>
            <p class="text-xs font-black tracking-widest text-slate-400 uppercase mb-1">Payment Approval</p>
            <h3 class="text-2xl font-black tracking-tighter text-amber-500">{{ number_format($paymentApprovalRequests) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-5 text-amber-500 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-money-check-dollar text-8xl"></i>
        </div>
    </a>

    <!-- Total Customer -->
    <div class="group relative bg-white p-6 rounded-[2rem] shadow-premium transition-all duration-300 overflow-hidden border border-slate-100">
        <div class="relative z-10 text-dark">
            <div class="w-10 h-10 rounded-xl bg-sky-500/10 flex items-center justify-center mb-4 border border-sky-500/10">
                <i class="fa-solid fa-users text-xl text-sky-500"></i>
            </div>
            <p class="text-xs font-black tracking-widest text-slate-400 uppercase mb-1">Total Customer</p>
            <h3 class="text-2xl font-black tracking-tighter text-sky-500">{{ number_format($totalCustomers) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-[0.03] text-sky-500 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-users text-8xl"></i>
        </div>
    </div>

    <!-- Total Booking -->
    <div class="group relative bg-white p-6 rounded-[2rem] shadow-premium transition-all duration-300 overflow-hidden border border-slate-100">
        <div class="relative z-10 text-dark">
            <div class="w-10 h-10 rounded-xl bg-secondary/10 flex items-center justify-center mb-4 border border-secondary/10">
                <i class="fa-solid fa-ticket text-xl text-secondary"></i>
            </div>
            <p class="text-xs font-black tracking-widest text-slate-400 uppercase mb-1">Total Booking</p>
            <h3 class="text-2xl font-black tracking-tighter text-secondary">{{ number_format($totalBookings) }}</h3>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-[0.03] text-secondary group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-ticket text-8xl"></i>
        </div>
    </div>
</div>

<!-- Grid Layout for Tables & Details -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Sales Table -->
    <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-premium border border-white overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex flex-col sm:flex-row items-center justify-between gap-4 bg-slate-50/20">
            <div>
                <h3 class="text-2xl font-black text-dark tracking-tight">Recent Transactions</h3>
            </div>
            <a href="{{ route('admin.finance.bookings.index') }}" class="px-8 py-3 bg-white border border-slate-100 rounded-xl text-xs font-black text-primary tracking-widest uppercase hover:bg-primary hover:text-white transition-all shadow-sm">View Audits</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/40 text-xs font-black tracking-widest text-slate-400 uppercase">
                        <th class="px-8 py-5 border-b border-slate-50">Event</th>
                        <th class="px-8 py-5 border-b border-slate-50">Identity</th>
                        <th class="px-8 py-5 border-b border-slate-50">Volume</th>
                        <th class="px-8 py-5 border-b border-slate-50">State</th>
                        <th class="px-8 py-5 border-b border-slate-50 text-right">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-base">
                    @forelse($recentTransactions->take(4) as $transaction)
                    <tr class="hover:bg-slate-50/80 transition-all duration-300 group cursor-pointer">
                        <td class="px-8 py-5">
                            <span class="text-base font-black text-dark block truncate max-w-[200px]">{{ $transaction->event->title ?? 'N/A' }}</span>
                        </td>
                        <td class="px-8 py-5 text-sm text-slate-500 font-bold truncate max-w-[150px]">{{ $transaction->user->email ?? 'N/A' }}</td>
                        <td class="px-8 py-5">
                            <span class="font-black text-base text-primary">৳{{ number_format($transaction->total_amount, 0) }}</span>
                        </td>
                        <td class="px-8 py-5">
                            @php $st = $transaction->status; $cls = $st == 'confirmed' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : ($st == 'pending' ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-rose-50 text-rose-600 border-rose-100'); @endphp
                            <span class="px-3 py-1.5 {{ $cls }} text-[10px] font-black rounded-lg border uppercase tracking-widest">{{ $st }}</span>
                        </td>
                        <td class="px-8 py-5 text-right text-xs font-black text-dark uppercase tracking-tighter">{{ $transaction->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-14 text-center text-xs font-black text-slate-300 uppercase">System Idle - Waiting for Signal</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Live Monitoring Sidebar -->
    <div class="bg-secondary rounded-[2.5rem] p-10 text-white relative overflow-hidden flex flex-col justify-between shadow-2xl">
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-2 h-2 rounded-full bg-vibrant animate-ping"></div>
                <span class="text-white/40 font-black tracking-[0.4em] text-xs uppercase">Live Feed</span>
            </div>
            
            <h3 class="text-4xl font-black tracking-tighter mb-10 leading-[0.9]">Global <br><span class="text-accent underline underline-offset-8 decoration-white/10">Traffic</span> <br>Pulse.</h3>

            <div class="space-y-6">
                @foreach($topEvents->take(2) as $index => $event)
                <div class="flex items-center gap-6 bg-white/5 p-6 rounded-[1.5rem] border border-white/5 hover:bg-white/10 transition-all group/monitor">
                    <div class="w-12 h-12 rounded-2xl {{ $index == 0 ? 'bg-emerald-500/10' : 'bg-blue-500/10' }} flex items-center justify-center">
                        <div class="w-3 h-3 {{ $index == 0 ? 'bg-emerald-500' : 'bg-blue-500' }} rounded-full animate-pulse shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-base font-black text-white group-hover/monitor:text-accent transition-colors truncate">{{ $event->title }}</p>
                        <p class="text-xs text-white/40 font-bold uppercase tracking-widest mt-1">{{ number_format($event->bookings_count) }} Sales Recorded</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .animate-fadeIn { animation: fadeIn 0.6s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
