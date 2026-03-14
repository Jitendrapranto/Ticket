@extends('layouts.organizer')

@section('title', 'Sales Reports')
@section('header_title', 'Sales Reports')

@section('content')
<div class="p-8 animate-fadeInUp" x-data="{ searchQuery: '' }">
    <!-- Header Section -->
    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-6 mb-10">
        <div>
            <h1 class="font-outfit text-4xl font-black text-dark tracking-tighter mb-2">Sales Reports</h1>
            <p class="text-slate-400 font-medium text-sm">Comprehensive analysis of ticket volume and sales performance.</p>
        </div>

        <form action="{{ route('organizer.reports.sales') }}" method="GET" class="flex flex-wrap items-center gap-3" id="filterForm">
            <div class="flex items-center gap-2 bg-white border border-slate-100 rounded-2xl px-4 py-2.5 shadow-sm text-[10px] font-black uppercase tracking-widest transition-all focus-within:ring-2 focus-within:ring-primary/20">
                <i class="far fa-calendar text-slate-400"></i>
                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="outline-none bg-transparent cursor-pointer">
                <span class="text-slate-200">/</span>
                <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="outline-none bg-transparent cursor-pointer">
            </div>
            <button type="submit" class="bg-dark text-white px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all flex items-center gap-2 shadow-lg shadow-dark/10">
                <i class="fas fa-filter"></i> Apply
            </button>
            <a href="{{ route('organizer.reports.sales.export', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" class="bg-white text-dark border border-slate-100 px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                 <i class="fas fa-download"></i> Export
            </a>
        </form>
    </div>

    <!-- Stats Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Tickets Sold -->
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-8 rounded-[2.5rem] shadow-xl shadow-blue-500/20 relative overflow-hidden group hover:-translate-y-1 transition-all">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <p class="text-[10px] font-black tracking-[0.2em] text-white/50 uppercase mb-4 relative z-10">Tickets Sold</p>
            <h3 class="font-outfit text-4xl font-black text-white mb-1 relative z-10">{{ number_format($totalTickets) }}</h3>
            <p class="text-[10px] font-bold text-blue-200 uppercase tracking-widest relative z-10">Total Volume</p>
        </div>

        <!-- Gross Revenue -->
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-8 rounded-[2.5rem] shadow-xl shadow-emerald-500/20 relative overflow-hidden group hover:-translate-y-1 transition-all">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <p class="text-[10px] font-black tracking-[0.2em] text-white/50 uppercase mb-4 relative z-10">Gross Revenue</p>
            <h3 class="font-outfit text-4xl font-black text-white mb-1 relative z-10">৳{{ number_format($grossRevenue, 2) }}</h3>
            <p class="text-[10px] font-bold text-emerald-100 uppercase tracking-widest relative z-10">Confirmed Sales</p>
        </div>

        <!-- Charge / Fees -->
        <div class="bg-gradient-to-br from-slate-600 to-slate-800 p-8 rounded-[2.5rem] shadow-xl shadow-slate-700/20 relative overflow-hidden group hover:-translate-y-1 transition-all">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/5 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <p class="text-[10px] font-black tracking-[0.2em] text-white/40 uppercase mb-4 relative z-10">Charge / Fees</p>
            <h3 class="font-outfit text-4xl font-black text-white mb-1 relative z-10">৳{{ number_format($totalCommission, 2) }}</h3>
            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest relative z-10">Platform Service</p>
        </div>

        <!-- Net Profit -->
        <div class="bg-gradient-to-br from-indigo-500 to-primary p-8 rounded-[2.5rem] shadow-xl shadow-primary/20 relative overflow-hidden group hover:-translate-y-1 transition-all">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <p class="text-[10px] font-black tracking-[0.2em] text-white/60 uppercase mb-4 relative z-10">Net Profit</p>
            <h3 class="font-outfit text-4xl font-black text-white mb-1 relative z-10">৳{{ number_format($netEarnings, 2) }}</h3>
            <p class="text-[10px] font-bold text-indigo-100 uppercase tracking-widest relative z-10">Total Earnings</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 mb-12">
        <div class="xl:col-span-8">
            <div class="bg-white p-10 rounded-[3rem] shadow-premium border border-slate-50 overflow-hidden">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Sales Trends</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Daily Revenue Analysis</p>
                    </div>
                </div>
                <div class="h-[350px]">
                    <canvas id="salesTrendsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="xl:col-span-4">
            <div class="bg-secondary rounded-[3rem] p-12 text-white relative overflow-hidden shadow-2xl h-full flex flex-col justify-center items-center text-center group">
                <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
                <div class="w-20 h-20 rounded-3xl bg-white/10 flex items-center justify-center text-3xl mb-8 shadow-inner">
                    <i class="fas fa-robot text-accent"></i>
                </div>
                <h4 class="font-outfit text-2xl font-black mb-4 tracking-tight">AI Analysis</h4>
                <p class="text-xs font-medium leading-relaxed opacity-50 mb-10">Generate growth insights based on current sales trajectory.</p>
                <button class="w-full bg-white text-dark py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-100 transition-all shadow-xl">Run Insights</button>
            </div>
        </div>
    </div>

    <!-- Event Breakdown -->
    <div class="bg-white rounded-[3rem] shadow-premium border border-slate-50 overflow-hidden">
        <div class="p-10 border-b border-slate-50 bg-slate-50/10">
            <h3 class="font-outfit text-2xl font-black text-dark tracking-tighter mb-1">Event-Wise Breakdown</h3>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Individual project performance metrics.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-white border-b border-slate-50">
                        <th class="px-10 py-6">Event Identity</th>
                        <th class="px-8 py-6 text-center">Tickets Sold</th>
                        <th class="px-8 py-6 text-center">Gross</th>
                        <th class="px-10 py-6 text-right">Net Profit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium">
                    @forelse($eventStats as $event)
                    <tr class="group hover:bg-slate-50/50 transition-all">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-10 rounded-xl bg-slate-100 overflow-hidden border border-slate-100">
                                    @if($event->image)
                                        <img loading="lazy" src="{{ $event->image_url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[10px] text-slate-200 uppercase font-black">EV</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-black text-dark group-hover:text-primary transition-colors">{{ $event->title }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $event->category->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-8 text-center">
                            <span class="text-sm font-black text-dark">{{ number_format($event->tickets_sold) }}</span>
                        </td>
                        <td class="px-8 py-8 text-center text-sm font-black text-dark/60">
                            ৳{{ number_format($event->gross_revenue, 2) }}
                        </td>
                        <td class="px-10 py-8 text-right text-sm font-black text-emerald-500">
                            ৳{{ number_format($event->organizer_profit, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-10 py-20 text-center text-slate-300 font-black uppercase text-[10px] tracking-widest">No detailed performance data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesTrendsChart').getContext('2d');
        const labels = @json($monthlyTrends ? $monthlyTrends->pluck('label') : []);
        const values = @json($monthlyTrends ? $monthlyTrends->pluck('value') : []);

        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Gross Revenue',
                        data: values,
                        backgroundColor: '#1B2B46',
                        borderRadius: 14,
                        barThickness: 'flex',
                        maxBarThickness: 45,
                        hoverBackgroundColor: '#520C6B'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0F172A',
                            padding: 15,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return '৳' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#F1F5F9', drawBorder: false },
                            ticks: {
                                font: { size: 10, weight: '700' },
                                color: '#94a3b8',
                                callback: function(value) { return '৳' + value.toLocaleString(); }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: '700' }, color: '#94a3b8' }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
