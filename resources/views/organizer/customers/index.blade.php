<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer CRM | Organizer Control Center</title>
    <!-- Prevent FOUC: Hide body until styles are ready -->
    <style>
        html { visibility: hidden; opacity: 0; }
        html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }
    </style>
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',
                        secondary: '#21032B',
                        accent: '#FF7D52',
                        dark: '#0F172A',
                        'brand-green': '#10B981',
                        'brand-red': '#EF4444',
                        'brand-amber': '#F59E0B',
                    },
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        plus: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    boxShadow: {
                        'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.05)',
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
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
<body class="bg-[#F8FAFC] text-slate-800">

    @include('organizer.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <button id="toggle-sidebar" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="relative group">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 transition-colors group-focus-within:text-primary"></i>
                    <input type="text" placeholder="Search audience.." class="bg-slate-50 border-none rounded-2xl pl-12 pr-6 py-3 text-sm focus:ring-2 focus:ring-primary/10 transition-all w-80">
                </div>
            </div>

            <div class="flex items-center gap-6">
                <button class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400">
                    <i class="far fa-bell"></i>
                    <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                <div class="flex items-center gap-3 pl-6 border-l border-slate-100 mr-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-black text-dark">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Organizer Account</p>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-10 flex-1 max-w-[1600px] mx-auto w-full">
            <!-- Header Section -->
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h1 class="font-outfit text-4xl font-black text-dark tracking-tight mb-2">Audience Manager</h1>
                    <p class="text-slate-400 font-medium">Analyze and interact with customers engaged with your events.</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('organizer.customers.export', request()->all()) }}" class="bg-white border border-slate-200 text-slate-600 px-6 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-2">
                        <i class="fas fa-download text-[10px]"></i> Export Database
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Total Audience -->
                <div class="bg-white p-8 rounded-[2rem] shadow-premium border border-white flex items-center justify-between group hover:-translate-y-1 transition-all duration-300">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Unique Customers</p>
                        <h3 class="text-4xl font-outfit font-black text-dark tracking-tighter mb-1">{{ number_format($totalCustomers) }}</h3>
                        <p class="text-[11px] font-bold text-brand-green">Direct Reach</p>
                    </div>
                    <div class="w-14 h-14 bg-primary/5 text-primary rounded-2xl flex items-center justify-center text-xl group-hover:bg-primary group-hover:text-white transition-all">
                        <i class="fas fa-user-friends"></i>
                    </div>
                </div>

                <!-- Total Bookings -->
                <div class="bg-white p-8 rounded-[2rem] shadow-premium border border-white flex items-center justify-between group hover:-translate-y-1 transition-all duration-300">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Event Bookings</p>
                        <h3 class="text-4xl font-outfit font-black text-dark tracking-tighter mb-1">{{ number_format($totalBookings) }}</h3>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Confirmed Seats</p>
                    </div>
                    <div class="w-14 h-14 bg-emerald-50 text-brand-green rounded-2xl flex items-center justify-center text-xl group-hover:bg-brand-green group-hover:text-white transition-all">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                </div>

                <!-- Avg. Lifetime Value -->
                <div class="bg-white p-8 rounded-[2rem] shadow-premium border border-white flex items-center justify-between group hover:-translate-y-1 transition-all duration-300">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Audience Value (LTV)</p>
                        <h3 class="text-4xl font-outfit font-black text-dark tracking-tighter mb-1">৳{{ number_format($averageLTV, 2) }}</h3>
                        <p class="text-[11px] font-bold text-slate-400">Avg per customer</p>
                    </div>
                    <div class="w-14 h-14 bg-orange-50 text-accent rounded-2xl flex items-center justify-center text-xl group-hover:bg-accent group-hover:text-white transition-all">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-[2.5rem] shadow-premium border border-white overflow-hidden">
                <div class="p-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-1">All Customers</h3>
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Customers who purchased your tickets.</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <form action="{{ route('organizer.customers.index') }}" method="GET" x-data="{ searchQuery: '{{ request('search') }}' }" class="relative group">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 transition-colors group-focus-within:text-primary"></i>
                            <input type="text" name="search" x-model="searchQuery" @input.debounce.500ms="$el.form.submit()" placeholder="Filter by identity..." class="bg-slate-50 border-none rounded-xl pl-12 pr-6 py-3.5 text-xs font-semibold focus:ring-2 focus:ring-primary/10 transition-all w-72">
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/30 text-[10px] font-black tracking-widest text-slate-400 uppercase border-y border-slate-50">
                                <th class="px-10 py-5 font-black">Customer Profile</th>
                                <th class="px-8 py-5 font-black">Engagement</th>
                                <th class="px-8 py-5 font-black text-center">First Interaction</th>
                                <th class="px-8 py-5 font-black text-center">Status</th>
                                <th class="px-10 py-5 font-black text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($customers as $customer)
                            <tr class="hover:bg-slate-50/40 transition-all group">
                                <td class="px-10 py-7">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-100 shadow-soft flex items-center justify-center overflow-hidden">
                                            <div class="w-full h-full bg-primary/5 flex items-center justify-center">
                                                <span class="text-sm font-black text-primary uppercase">{{ substr($customer->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-dark group-hover:text-primary transition-colors leading-tight">{{ $customer->name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 mt-1 lowercase">{{ $customer->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-7">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                             <span class="text-sm font-black text-dark tracking-tight">{{ $customer->bookings_count }}</span>
                                             <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Orders</span>
                                        </div>
                                        <div class="w-24 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-accent" style="width: {{ min($customer->bookings_count * 20, 100) }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-7 text-center">
                                    <div class="inline-flex items-center gap-2 text-slate-500 font-bold text-xs bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                        <i class="far fa-calendar-alt text-[10px] text-slate-300"></i>
                                        {{ $customer->created_at->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-8 py-7 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-[0.1em] bg-brand-green/10 text-brand-green border border-brand-green/20">
                                        <span class="w-1 h-1 rounded-full currentColor bg-current"></span>
                                        ACTIVE
                                    </span>
                                </td>
                                <td class="px-10 py-7 text-right">
                                    <a href="{{ route('organizer.customers.show', $customer->id) }}" class="inline-flex items-center gap-2 bg-dark text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all shadow-lg shadow-dark/10">
                                        <i class="fas fa-id-card"></i> View File
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer / Pagination -->
                <div class="p-10 bg-slate-50/50 border-t border-slate-50 flex items-center justify-between">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">
                        Database Sync: <span class="text-dark">{{ $customers->total() }}</span> unique profiles mapped.
                    </p>
                    <div>
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </main>

        <footer class="px-10 py-8 text-center text-[10px] font-black text-slate-400 tracking-widest uppercase border-t border-slate-100 bg-white/50 backdrop-blur-md">
            Ticket Kinun • Audience CRM Module • © 2026
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-sidebar');
            const sidebar = document.getElementById('organizer-sidebar');
            if(toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('-translate-x-full');
                });
            }
        });
    </script>
</body>
</html>
