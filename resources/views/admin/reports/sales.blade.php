<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Sales Reports | Admin Control Center</title>
    <!-- Prevent FOUC: Hide body until styles are ready -->
    <style>
        html { visibility: hidden; opacity: 0; }
        html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        'brand-green': '#10B981',
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
<body class="bg-[#F8FAFC] text-slate-800 font-plus" x-data="{ searchQuery: '' }">
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
                    <input type="text" x-model="searchQuery" placeholder="Search platform analytics..." class="bg-slate-50 border border-slate-100 rounded-2xl pl-10 pr-6 py-2.5 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all w-64 uppercase tracking-tighter">
                </div>
            </div>

            <div class="flex items-center gap-6">
                <button class="relative text-slate-400 hover:text-primary transition-colors">
                    <i class="far fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-accent rounded-full border-2 border-white"></span>
                </button>
                <div class="flex items-center gap-3 pl-6 border-l border-slate-100 mr-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-black text-dark">Super Admin</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Administrator Account</p>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-8 flex-1">
            <!-- Header Section -->
            <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-6 mb-10">
                <div>
                    <h1 class="font-outfit text-4xl font-black text-dark tracking-tighter mb-2">Platform Sales Reports</h1>
                    <p class="text-slate-400 font-medium text-sm">Comprehensive analysis of ticket volume and sales performance across all organizers.</p>
                </div>

                <form action="{{ route('admin.finance.reports.sales') }}" method="GET" class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2 bg-white border border-slate-100 rounded-2xl px-4 py-2.5 shadow-sm text-[10px] font-black uppercase tracking-widest transition-all focus-within:ring-2 focus-within:ring-primary/20">
                        <i class="far fa-calendar text-slate-400"></i>
                        <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="outline-none bg-transparent cursor-pointer">
                        <span class="text-slate-200">/</span>
                        <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="outline-none bg-transparent cursor-pointer">
                    </div>
                    <button type="submit" class="bg-secondary text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all flex items-center gap-2">
                        <i class="fas fa-filter"></i> Apply
                    </button>
                    <a href="{{ route('admin.finance.reports.sales.export', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" class="bg-white text-dark border border-slate-100 px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-2">
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
                    <h3 class="font-outfit text-4xl font-black text-dark mb-1">{{ number_format($totalTickets) }}</h3>
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
                    <h3 class="font-outfit text-4xl font-black text-dark mb-1">৳{{ number_format($grossRevenue, 2) }}</h3>
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
                    <h3 class="font-outfit text-4xl font-black text-dark mb-1">৳{{ number_format($organizerPayout, 2) }}</h3>
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
                    <h3 class="font-outfit text-4xl font-black text-dark mb-1">৳{{ number_format($netProfit, 2) }}</h3>
                    <p class="text-[10px] font-bold text-brand-green flex items-center gap-1.5 uppercase tracking-widest">
                        Total commission
                    </p>
                </div>
            </div>

            <!-- Charts & Intelligence -->
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 mb-12">
                <!-- Sales Trends Graph -->
                <div class="xl:col-span-8">
                    <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
                        <div class="flex flex-col sm:flex-row items-center justify-between mb-10 gap-4">
                            <div>
                                <h3 class="font-outfit text-xl font-black text-dark tracking-tight mb-2">Platform Sales Trends</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Visualizing platform volume over time.</p>
                            </div>
                            <div class="bg-slate-50 p-1.5 rounded-2xl flex gap-1">
                                <button class="px-5 py-2 rounded-xl text-[9px] font-black uppercase text-slate-400">Daily</button>
                                <button class="px-5 py-2 rounded-xl text-[9px] font-black uppercase text-slate-400">Weekly</button>
                                <button class="px-5 py-2 rounded-xl text-[9px] font-black uppercase bg-white shadow-sm text-dark">Monthly</button>
                            </div>
                        </div>
                        <div class="h-[350px]">
                            <canvas id="salesTrendsChart"></canvas>
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
                        <p class="text-xs font-medium leading-relaxed opacity-50 mb-10 max-w-[240px]">Deep analysis of transaction volume to identify peak trends and optimization points.</p>
                        <button class="w-full bg-white text-dark py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-100 transition-all shadow-xl shadow-dark/20">Run Full Audit</button>
                    </div>
                </div>
            </div>

            <!-- Event-Wise Breakdown Table -->
            <div class="bg-white rounded-[3rem] shadow-premium border border-slate-50 overflow-hidden">
                <div class="p-10 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-6 bg-slate-50/10">
                    <div>
                        <h3 class="font-outfit text-2xl font-black text-dark tracking-tighter mb-1">Performance by Event</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Cross-platform event sales analysis.</p>
                    </div>
                    <button class="bg-white text-dark px-6 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest border border-slate-100 flex items-center gap-2">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-white">
                                <th class="px-10 py-6">Event Identity</th>
                                <th class="px-8 py-6 text-center">Tickets Sold</th>
                                <th class="px-8 py-6 text-center">Gross Revenue</th>
                                <th class="px-10 py-6 text-right">Commission Profit</th>
                                <th class="px-10 py-6 text-right">Growth</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($eventStats as $event)
                            <tr class="group hover:bg-slate-50/50 transition-all"
                                x-show="searchQuery === '' || '{{ strtolower($event->title) }}'.includes(searchQuery.toLowerCase())">
                                <td class="px-10 py-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-10 rounded-xl bg-slate-100 overflow-hidden shadow-inner border border-slate-100">
                                            @if($event->image)
                                                <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-[10px] text-slate-200 font-black">EV</div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-dark mb-0.5 group-hover:text-primary transition-colors">{{ $event->title }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $event->category->name }} Exp.</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-8 text-center">
                                    <span class="text-sm font-black text-dark">{{ number_format($event->tickets_sold) }}</span>
                                </td>
                                <td class="px-8 py-8 text-center text-sm font-black text-secondary">
                                    ৳{{ number_format($event->gross_revenue, 2) }}
                                </td>
                                <td class="px-10 py-8 text-right text-sm font-black text-brand-green">
                                    ৳{{ number_format($event->commission, 2) }}
                                </td>
                                <td class="px-10 py-8 text-right">
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

    <script>
        const ctx = document.getElementById('salesTrendsChart').getContext('2d');
        const labels = @json($monthlyTrends->pluck('label'));
        const values = @json($monthlyTrends->pluck('value'));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Platform Revenue',
                    data: values,
                    backgroundColor: '#1B2B46',
                    borderRadius: 14,
                    barThickness: 45,
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

        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-sidebar');
            const sidebar = document.getElementById('admin-sidebar');
            if(toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', () => { sidebar.classList.toggle('-translate-x-full'); });
            }
        });
    </script>
</body>
</html>
    </script>
</body>
</html>
