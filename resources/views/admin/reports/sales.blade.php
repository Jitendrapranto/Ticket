@extends('admin.dashboard')

@section('admin_content')
<div x-data="{ searchQuery: '' }">

    <div class="animate-fadeIn">
        <!-- Top Header -->
        
        <main class="p-8 flex-1">
            <!-- Header Section -->
            <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-6 mb-10">
                <div>
                    <h1 class="font-outfit text-4xl font-black text-dark tracking-tighter mb-2">Platform Sales Reports</h1>
                    <p class="text-slate-400 font-medium text-sm">Comprehensive analysis of ticket volume and sales performance across all organizers.</p>
                </div>

                <form action="{{ route('admin.finance.reports.sales') }}" method="GET" class="flex flex-wrap items-center gap-3" x-data="{ filterType: '{{ request('date_filter', 'custom') }}' }">
                    <div class="flex items-center bg-white border border-slate-100 rounded-2xl px-4 py-3 shadow-sm text-[10px] font-black uppercase tracking-widest transition-all focus-within:ring-2 focus-within:ring-primary/20">
                        <i class="fas fa-calendar-alt text-slate-400 mr-2"></i>
                        <select name="date_filter" x-model="filterType" class="bg-transparent outline-none cursor-pointer pr-4 uppercase text-dark font-bold font-outfit">
                            <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                            <option value="this_year" {{ request('date_filter') == 'this_year' ? 'selected' : '' }}>This Year</option>
                            <option value="custom" {{ request('date_filter', 'custom') == 'custom' ? 'selected' : '' }}>Custom Range Date</option>
                        </select>
                    </div>

                    <div x-show="filterType === 'custom'" class="flex items-center gap-2 bg-white border border-slate-100 rounded-2xl px-4 py-2.5 shadow-sm text-[10px] font-black uppercase tracking-widest transition-all focus-within:ring-2 focus-within:ring-primary/20" x-transition>
                        <i class="far fa-calendar text-slate-400"></i>
                        <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="outline-none bg-transparent cursor-pointer">
                        <span class="text-slate-200">/</span>
                        <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="outline-none bg-transparent cursor-pointer">
                    </div>
                    
                    <button type="submit" class="bg-secondary text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all flex items-center gap-2">
                        <i class="fas fa-filter"></i> Apply
                    </button>
                    <a href="{{ route('admin.finance.reports.sales.export', ['date_filter' => request('date_filter', 'custom'), 'start_date' => request('start_date', $startDate->format('Y-m-d')), 'end_date' => request('end_date', $endDate->format('Y-m-d'))]) }}" target="_blank" class="bg-white text-dark border border-slate-100 px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-2">
                         <i class="fas fa-download"></i> Export CSV
                    </a>
                    <button type="button" class="bg-primary/5 text-primary px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-primary/10 transition-all flex items-center gap-2">
                        <i class="fas fa-magic"></i> AI Insight
                    </button>
                </form>
            </div>

            <!-- Stats Overview Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Total Tickets -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden group">
                    <div class="flex items-start justify-between mb-6">
                        <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase">Tickets Sold</p>
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-primary flex items-center justify-center text-sm group-hover:scale-110 transition-transform">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                    </div>
                    <h3 class="font-outfit text-2xl md:text-3xl xl:text-4xl font-black text-dark mb-1 truncate">{{ number_format($totalTickets) }}</h3>
                    <p class="text-[10px] font-bold text-brand-green flex items-center gap-1.5 uppercase tracking-widest">
                        <i class="fas fa-arrow-up"></i> +8.2% vs prev.
                    </p>
                </div>

                <!-- Gross Revenue -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden group">
                    <div class="flex items-start justify-between mb-6">
                        <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase">Gross Revenue</p>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-brand-green flex items-center justify-center text-sm group-hover:scale-110 transition-transform">
                            <i class="fas fa-coins"></i>
                        </div>
                    </div>
                    <h3 class="font-outfit text-2xl md:text-3xl xl:text-4xl font-black text-dark mb-1 truncate">৳{{ number_format($grossRevenue, 2) }}</h3>
                    <p class="text-[10px] font-bold text-brand-green flex items-center gap-1.5 uppercase tracking-widest">
                        Total payments
                    </p>
                </div>

                <!-- Organizer Payout -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden group">
                    <div class="flex items-start justify-between mb-6">
                        <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase">Organizer Payout</p>
                        <div class="w-10 h-10 rounded-xl bg-orange-50 text-accent flex items-center justify-center text-sm group-hover:scale-110 transition-transform">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                    <h3 class="font-outfit text-2xl md:text-3xl xl:text-4xl font-black text-dark mb-1 truncate">৳{{ number_format($organizerPayout, 2) }}</h3>
                    <p class="text-[10px] font-bold text-slate-400 flex items-center gap-1.5 uppercase tracking-widest">
                        Est. total
                    </p>
                </div>

                <!-- Net Platform Profit -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden group">
                    <div class="flex items-start justify-between mb-6">
                        <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase">Platform Profit</p>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm group-hover:scale-110 transition-transform">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <h3 class="font-outfit text-2xl md:text-3xl xl:text-4xl font-black text-dark mb-1 truncate">৳{{ number_format($netProfit, 2) }}</h3>
                    <p class="text-[10px] font-bold text-brand-green flex items-center gap-1.5 uppercase tracking-widest">
                        Total commission
                    </p>
                </div>
            </div>

            <!-- Charts & Intelligence -->
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 mb-12" x-data="salesTrendComponent()">
                <!-- Sales Trends Graph -->
                <div class="xl:col-span-8">
                    <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100 relative group">
                        <!-- Loading Overlay -->
                        <div x-show="loading" x-transition class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-10 flex items-center justify-center rounded-[3rem]">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-10 h-10 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-primary">Syncing Data...</p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center justify-between mb-10 gap-4">
                            <div>
                                <h3 class="font-outfit text-xl font-black text-dark tracking-tight mb-2">Platform Sales Trends</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Visualizing platform volume over time.</p>
                            </div>
                            <div class="bg-slate-50 p-1.5 rounded-2xl flex gap-1">
                                <button @click="changeTrend('daily')" 
                                   :class="trend === 'daily' ? 'bg-white shadow-sm text-dark' : 'text-slate-400 hover:text-slate-600'"
                                   class="px-5 py-2 rounded-xl text-[9px] font-black uppercase transition-all">Daily</button>
                                <button @click="changeTrend('weekly')" 
                                   :class="trend === 'weekly' ? 'bg-white shadow-sm text-dark' : 'text-slate-400 hover:text-slate-600'"
                                   class="px-5 py-2 rounded-xl text-[9px] font-black uppercase transition-all">Weekly</button>
                                <button @click="changeTrend('monthly')" 
                                   :class="trend === 'monthly' ? 'bg-white shadow-sm text-dark' : 'text-slate-400 hover:text-slate-600'"
                                   class="px-5 py-2 rounded-xl text-[9px] font-black uppercase transition-all">Monthly</button>
                            </div>
                        </div>
                        <div class="h-[350px] relative">
                            <canvas id="salesTrendsChart" 
                                data-labels='@json($trends->pluck("label"))' 
                                data-values='@json($trends->pluck("value"))'></canvas>
                        </div>
                    </div>
                </div>

                <!-- Platform Intelligence -->
                <div class="xl:col-span-4">
                    <div class="bg-secondary rounded-[3rem] p-12 text-white relative overflow-hidden shadow-2xl h-full flex flex-col justify-center items-center text-center group">
                        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
                        <div class="w-20 h-20 rounded-3xl bg-white/10 flex items-center justify-center text-3xl mb-8 shadow-inner">
                            <i class="fas fa-brain text-accent"></i>
                        </div>
                        <h4 class="font-outfit text-2xl font-black mb-4 tracking-tight">System Intelligence</h4>
                        <p class="text-xs font-medium leading-relaxed opacity-50 max-w-[240px]">Deep analysis of transaction volume to identify peak trends and optimization points.</p>
                    </div>
                </div>
            </div>

            <!-- Event-Wise Breakdown Table -->
            <div class="bg-white rounded-[3rem] shadow-premium border border-slate-50 overflow-hidden" id="eventBreakdownTable">
                <div class="p-10 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-6 bg-slate-50/10">
                    <div>
                        <h3 class="font-outfit text-2xl font-black text-dark tracking-tighter mb-1">Performance by Event</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Cross-platform event sales analysis.</p>
                    </div>
                </div>
                <div class="">
                    <table class="w-full text-left table-fixed border-collapse">
                        <thead>
                            <tr class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] bg-white border-b border-slate-50">
                                <th class="px-8 py-6 w-[35%]">Event Identity</th>
                                <th class="px-6 py-6 text-center w-[15%]">Tickets Sold</th>
                                <th class="px-6 py-6 text-center w-[18%]">Gross Revenue</th>
                                <th class="px-8 py-6 text-right w-[18%]">Commission Profit</th>
                                <th class="px-8 py-6 text-right w-[14%]">Growth</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($eventStats as $event)
                            <tr class="group hover:bg-slate-50/50 transition-all">
                                <td class="px-8 py-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-10 rounded-xl bg-slate-100 overflow-hidden shadow-inner border border-slate-100">
                                            @if($event->image)
                                                <img loading="lazy" src="{{ $event->image_url }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-[10px] text-slate-200 font-black">EV</div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-black text-dark mb-0.5 group-hover:text-primary transition-colors truncate" title="{{ $event->title }}">{{ $event->title }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter truncate">{{ $event->category->name }} Exp.</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-8 text-center text-sm font-black text-dark">
                                    {{ number_format($event->tickets_sold) }}
                                </td>
                                <td class="px-6 py-8 text-center text-sm font-black text-secondary">
                                    ৳{{ number_format($event->gross_revenue, 2) }}
                                </td>
                                <td class="px-8 py-8 text-right text-sm font-black text-brand-green">
                                    ৳{{ number_format($event->commission, 2) }}
                                </td>
                                <td class="px-8 py-8 text-right">
                                    <span class="px-3 py-1.5 rounded-full bg-emerald-50 text-brand-green text-[9px] font-black uppercase tracking-widest">+5.2%</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-10 py-24 text-center text-slate-400 font-black tracking-widest uppercase text-xs">No transaction data available yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <footer class="p-8 text-center text-[10px] font-black text-slate-400 tracking-widest uppercase border-t border-slate-50 bg-white">
            Ticket Kinun • Administrative Analytics • © 2026
        </footer>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function salesTrendComponent() {
            return {
                trend: '{{ $trendType }}',
                loading: false,
                chart: null,

                init() {
                    this.initChart();
                    document.addEventListener('swup:contentReplaced', () => this.initChart());
                },

                initChart() {
                    const canvas = document.getElementById('salesTrendsChart');
                    if (!canvas) return;

                    const ctx = canvas.getContext('2d');
                    const initialLabels = JSON.parse(canvas.getAttribute('data-labels'));
                    const initialValues = JSON.parse(canvas.getAttribute('data-values'));

                    if (window.salesChart) {
                        window.salesChart.destroy();
                    }

                    window.salesChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: initialLabels,
                            datasets: [{
                                label: 'Platform Revenue',
                                data: initialValues,
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
                            animation: {
                                duration: 1000,
                                easing: 'easeOutQuart'
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#0F172A',
                                    titleFont: { family: 'Arial', size: 12, weight: '900' },
                                    bodyFont: { family: 'Arial', size: 11, weight: '700' },
                                    padding: 15,
                                    displayColors: false,
                                    callbacks: {
                                        label: function(context) { return '৳' + context.parsed.y.toLocaleString(); }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: '#F1F5F9', drawBorder: false },
                                    ticks: {
                                        font: { family: 'Arial', size: 10, weight: '700' },
                                        color: '#94a3b8',
                                        callback: function(value) { return '৳' + value.toLocaleString(); }
                                    }
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: { font: { family: 'Arial', size: 10, weight: '700' }, color: '#94a3b8' }
                                }
                            }
                        }
                    });
                },

                async changeTrend(type) {
                    if (this.trend === type) return;
                    this.loading = true;
                    this.trend = type;

                    try {
                        const url = new URL(window.location.href);
                        url.searchParams.set('trend_type', type);
                        
                        const response = await fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (window.salesChart) {
                            window.salesChart.data.labels = data.labels;
                            window.salesChart.data.datasets[0].data = data.values;
                            window.salesChart.update();
                        }
                    } catch (error) {
                        console.error('Failed to fetch trend statistics:', error);
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-sidebar');
            const sidebar = document.getElementById('admin-sidebar');
            if(toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', () => { sidebar.classList.toggle('-translate-x-full'); });
            }
        });
        document.addEventListener('swup:contentReplaced', function() {
            const toggleBtn = document.getElementById('toggle-sidebar');
            const sidebar = document.getElementById('admin-sidebar');
            if(toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', () => { sidebar.classList.toggle('-translate-x-full'); });
            }
        });
    </script>
    @endpush

</div>
@endsection
