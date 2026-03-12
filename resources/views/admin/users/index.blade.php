<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Database | Ticket Kinun</title>
    <!-- Prevent FOUC: Hide body until styles are ready -->
    <style>
        html { visibility: hidden; opacity: 0; }
        html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }
    </style>
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',
                        secondary: '#1B2B46',
                        accent: '#FF7D52',
                        dark: '#0F172A',
                        'brand-green': '#10B981',
                        'brand-red': '#EF4444',
                        'brand-amber': '#F59E0B',
                    },
                    fontFamily: {
                        outfit: ['Arial', 'Helvetica', 'sans-serif'],
                        plus: ['Arial', 'Helvetica', 'sans-serif'],
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
        body { font-family: Arial, Helvetica, sans-serif; }
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

    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <button id="toggle-sidebar" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="relative group">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 transition-colors group-focus-within:text-primary"></i>
                    <input type="text" placeholder="Search platform resources.." class="bg-slate-50 border-none rounded-2xl pl-12 pr-6 py-3 text-sm focus:ring-2 focus:ring-primary/10 transition-all w-80">
                </div>
            </div>

            <div class="flex items-center gap-6">
                <button class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400">
                    <i class="far fa-bell"></i>
                    <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                <div class="flex items-center gap-3 pl-6 border-l border-slate-100">
                    <div class="text-right">
                        <p class="text-xs font-black text-dark">Super Admin</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Administrator</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-200 border-2 border-white shadow-sm overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </header>

        <main class="p-10 flex-1 max-w-[1600px] mx-auto w-full">
            <!-- Header Section -->
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h1 class="font-outfit text-4xl font-black text-dark tracking-tight mb-2">Customer Database</h1>
                    <p class="text-slate-400 font-medium">Manage and analyze your platform's customer base.</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.customers.export') }}" class="bg-white border border-slate-200 text-slate-600 px-6 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-2">
                        <i class="fas fa-download text-[10px]"></i> Export
                    </a>
                    <a href="{{ route('admin.customers.create') }}" class="bg-secondary text-white px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-black transition-all flex items-center gap-3 shadow-xl">
                        <i class="fas fa-plus text-[10px]"></i> Add Customer
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Total Customers -->
                <div class="bg-gradient-to-br from-primary to-[#7B1FA2] p-8 rounded-[2rem] shadow-premium border border-white/10 flex items-center justify-between group hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <i class="fas fa-users text-8xl -mr-8 -mt-8"></i>
                    </div>
                    <div class="relative z-10 text-white">
                        <p class="text-[10px] font-black text-white/60 uppercase tracking-widest mb-4">Total Customers</p>
                        <h3 class="text-4xl font-outfit font-black text-white tracking-tighter mb-1">{{ number_format($totalCustomers) }}</h3>
                        <p class="text-[11px] font-bold text-white/80 flex items-center gap-1.5">
                            <i class="fas fa-arrow-up text-[10px]"></i> +12% <span class="text-white/50 font-medium ml-1">from last month</span>
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-white/20 text-white rounded-2xl flex items-center justify-center text-xl backdrop-blur-md transition-all relative z-10">
                        <i class="far fa-user"></i>
                    </div>
                </div>

                <!-- Active Sessions -->
                <div class="bg-gradient-to-br from-brand-green to-[#065F46] p-8 rounded-[2rem] shadow-premium border border-white/10 flex items-center justify-between group hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <i class="fas fa-signal text-8xl -mr-8 -mt-8"></i>
                    </div>
                    <div class="relative z-10 text-white">
                        <p class="text-[10px] font-black text-white/60 uppercase tracking-widest mb-4">Active Sessions</p>
                        <h3 class="text-4xl font-outfit font-black text-white tracking-tighter mb-1">{{ number_format($activeSessions) }}</h3>
                        <p class="text-[11px] font-bold text-white/80">Currently online</p>
                    </div>
                    <div class="w-14 h-14 bg-white/20 text-white rounded-2xl flex items-center justify-center text-xl backdrop-blur-md transition-all relative z-10">
                        <i class="far fa-check-circle"></i>
                    </div>
                </div>

                <!-- Average LTV -->
                <div class="bg-gradient-to-br from-brand-amber to-[#B45309] p-8 rounded-[2rem] shadow-premium border border-white/10 flex items-center justify-between group hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <i class="fas fa-coins text-8xl -mr-8 -mt-8"></i>
                    </div>
                    <div class="relative z-10 text-white">
                        <p class="text-[10px] font-black text-white/60 uppercase tracking-widest mb-4">Average LTV</p>
                        <h3 class="text-4xl font-outfit font-black text-white tracking-tighter mb-1">৳{{ number_format($averageLTV, 2) }}</h3>
                        <p class="text-[11px] font-bold text-white/80">Lifetime Value</p>
                    </div>
                    <div class="w-14 h-14 bg-white/20 text-white rounded-2xl flex items-center justify-center text-xl backdrop-blur-md transition-all relative z-10">
                        <i class="fas fa-coins text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-[2.5rem] shadow-premium border border-white overflow-hidden">
                <div class="p-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-1">All Customers</h3>
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">View and manage all registered users.</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <form x-data="{ timer: null }" action="{{ route('admin.customers.index') }}" method="GET" x-ref="searchForm" class="relative group">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 transition-colors group-focus-within:text-primary"></i>
                            <input type="text" name="search" id="customerSearch" value="{{ request('search') }}"
                                @input.debounce.500ms="$refs.searchForm.submit()"
                                placeholder="Search name, email..."
                                class="bg-slate-50 border-none rounded-xl pl-12 pr-6 py-3.5 text-xs font-semibold focus:ring-2 focus:ring-primary/10 transition-all w-72">
                        </form>

                        <script>
                            // Move cursor to end of text on page load
                            window.onload = function() {
                                const input = document.getElementById('customerSearch');
                                if (input && input.value) {
                                    input.focus();
                                    const len = input.value.length;
                                    input.setSelectionRange(len, len);
                                } else if (input) {
                                    // if empty, just focus
                                    @if(request('search')) input.focus(); @endif
                                }
                            }
                        </script>
                        <div x-data="{ filterOpen: false, customDateOpen: false }" class="relative z-50">
                            <button @click="filterOpen = !filterOpen" class="bg-slate-50 text-slate-600 px-6 py-3.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-100 transition-all flex items-center gap-3">
                                <i class="fas fa-sliders-h text-[10px]"></i> {{ request('date_filter') ? ucwords(str_replace('_', ' ', request('date_filter'))) : 'Filter' }}
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="filterOpen" @click.away="filterOpen = false" x-transition class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-premium border border-slate-100 overflow-hidden" style="display: none;">
                                <div class="p-2 border-b border-slate-50">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-3 py-2">Filter by Date</p>
                                    <a href="{{ request()->fullUrlWithQuery(['date_filter' => 'today', 'date_from' => null, 'date_to' => null]) }}" class="block px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl transition-all {{ request('date_filter') == 'today' ? 'bg-primary/5 text-primary' : '' }}">Today</a>
                                    <a href="{{ request()->fullUrlWithQuery(['date_filter' => 'this_week', 'date_from' => null, 'date_to' => null]) }}" class="block px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl transition-all {{ request('date_filter') == 'this_week' ? 'bg-primary/5 text-primary' : '' }}">This Week</a>
                                    <a href="{{ request()->fullUrlWithQuery(['date_filter' => 'this_month', 'date_from' => null, 'date_to' => null]) }}" class="block px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl transition-all {{ request('date_filter') == 'this_month' ? 'bg-primary/5 text-primary' : '' }}">This Month</a>
                                    <a href="{{ request()->fullUrlWithQuery(['date_filter' => 'this_year', 'date_from' => null, 'date_to' => null]) }}" class="block px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl transition-all {{ request('date_filter') == 'this_year' ? 'bg-primary/5 text-primary' : '' }}">This Year</a>
                                    
                                    <button @click="customDateOpen = !customDateOpen" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl transition-all flex items-center justify-between {{ request('date_filter') == 'custom' ? 'bg-primary/5 text-primary' : '' }}">
                                        Custom Range <i class="fas fa-chevron-down text-[10px] transition-transform" :class="customDateOpen ? 'rotate-180' : ''"></i>
                                    </button>
                                </div>
                                
                                <!-- Custom Date Form -->
                                <div x-show="customDateOpen" x-transition class="p-4 bg-slate-50/50" style="display: none;">
                                    <form action="{{ route('admin.customers.index') }}" method="GET" class="space-y-3">
                                        <!-- Keep search parameter if it exists -->
                                        @if(request('search'))
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                        @endif
                                        <input type="hidden" name="date_filter" value="custom">
                                        
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">From</label>
                                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" required>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">To</label>
                                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" required>
                                        </div>
                                        <button type="submit" class="w-full bg-primary text-white mt-1 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-opacity-90 transition-all shadow-md">Apply Range</button>
                                    </form>
                                </div>

                                @if(request('date_filter'))
                                <div class="p-3 bg-slate-50/50 flex justify-center border-t border-slate-100">
                                    <a href="{{ request()->fullUrlWithQuery(['date_filter' => null, 'date_from' => null, 'date_to' => null]) }}" class="text-[10px] font-black text-brand-red uppercase tracking-widest hover:underline flex items-center gap-1.5"><i class="fas fa-times bg-brand-red/10 p-1 rounded-full"></i> Clear Filter</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/30 text-[10px] font-black tracking-widest text-slate-400 uppercase border-y border-slate-50">
                                <th class="px-10 py-5 w-[25%] font-black">Customer</th>
                                <th class="px-8 py-5 w-[25%] font-black">Contact</th>
                                <th class="px-8 py-5 w-[15%] font-black">Activity</th>
                                <th class="px-8 py-5 w-[15%] font-black text-center">Joined Date</th>
                                <th class="px-8 py-5 w-[10%] font-black text-center">Account Type</th>
                                <th class="px-8 py-5 w-[10%] font-black text-center">Status</th>
                                <th class="px-10 py-5 w-[10%] font-black text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($customers as $customer)
                            <tr class="hover:bg-slate-50/40 transition-all group">
                                <td class="px-10 py-7">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 border-2 border-white shadow-soft flex items-center justify-center overflow-hidden">
                                            @if($customer->avatar)
                                                <img src="{{ asset('storage/' . $customer->avatar) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-primary/5 flex items-center justify-center">
                                                    <span class="text-sm font-black text-primary uppercase">{{ substr($customer->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-dark group-hover:text-primary transition-colors leading-tight">{{ $customer->name }}</p>
                                            @if($customer->institution_name)
                                                <p class="text-[9px] font-bold text-primary uppercase tracking-wider mt-0.5">{{ $customer->institution_name }}</p>
                                            @endif
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">ID: #C-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-7">
                                    <div class="space-y-1.5">
                                        <div class="flex items-center gap-2.5 text-slate-500 hover:text-primary transition-colors cursor-pointer">
                                            <i class="far fa-envelope text-[11px] mt-0.5"></i>
                                            <span class="text-xs font-bold underline underline-offset-4 decoration-slate-200 group-hover:decoration-primary/30">{{ $customer->email }}</span>
                                            @if($customer->email_verified_at)
                                                <i class="fas fa-check-circle text-[9px] text-brand-green" title="Verified"></i>
                                            @endif
                                        </div>
                                        @if($customer->phone)
                                        <div class="flex items-center gap-2.5 text-slate-400">
                                            <i class="fas fa-phone-alt text-[10px]"></i>
                                            <span class="text-[11px] font-black">{{ $customer->phone }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-7">
                                    <div class="space-y-1">
                                        <p class="text-sm font-black text-dark tracking-tight">৳{{ number_format($customer->bookings->where('status', 'confirmed')->sum('total_amount'), 2) }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $customer->tickets_count }} tickets purchased</p>
                                    </div>
                                </td>
                                <td class="px-8 py-7 text-center">
                                    <div class="inline-flex items-center gap-2 text-slate-500 font-bold text-xs bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                        <i class="far fa-calendar-alt text-[10px] text-slate-300"></i>
                                        {{ $customer->created_at->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-8 py-7 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-[0.1em] border
                                        @if($customer->role === 'user') bg-blue-50 text-blue-600 border-blue-100
                                        @elseif($customer->role === 'organizer' || $customer->role === 'pending_organizer') bg-purple-50 text-purple-600 border-purple-100
                                        @elseif($customer->role === 'scanner') bg-orange-50 text-orange-600 border-orange-100
                                        @else bg-slate-50 text-slate-600 border-slate-100 @endif">
                                        {{ str_replace('_', ' ', $customer->role) }}
                                    </span>
                                </td>
                                <td class="px-8 py-7 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-[0.1em] border
                                        @if($customer->role === 'user') bg-brand-green/10 text-brand-green border-brand-green/20
                                        @elseif($customer->role === 'pending_organizer' || $customer->organizer_status === 'pending') bg-brand-amber/10 text-brand-amber border-brand-amber/20
                                        @elseif($customer->organizer_status === 'approved') bg-brand-green/10 text-brand-green border-brand-green/20
                                        @elseif($customer->organizer_status === 'rejected') bg-brand-red/10 text-brand-red border-brand-red/20
                                        @else bg-brand-green/10 text-brand-green border-brand-green/20 @endif">
                                        <span class="w-1 h-1 rounded-full currentColor bg-current"></span>
                                        @if($customer->role === 'user')
                                            Active
                                        @else
                                            {{ ucfirst($customer->organizer_status ?? 'Active') }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-10 py-7 text-right">
                                    <div class="flex items-center justify-end gap-2 text-slate-400">
                                        <!-- Show Action -->
                                        <a href="{{ route('admin.customers.show', $customer->id) }}" class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all shadow-sm group/btn">
                                            <i class="fas fa-eye text-[11px]"></i>
                                        </a>
                                        <!-- Delete Action -->
                                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" id="delete-form-{{ $customer->id }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button" onclick="confirmDelete({{ $customer->id }})" class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center hover:bg-brand-red hover:text-white hover:border-brand-red transition-all shadow-sm group/btn">
                                            <i class="fas fa-trash text-[11px]"></i>
                                        </button>

                                        <!-- Reset Password Form -->
                                        <form action="{{ route('admin.customers.reset-password', $customer->id) }}" method="POST" id="reset-form-{{ $customer->id }}" class="hidden">
                                            @csrf
                                            <input type="hidden" name="password" id="reset-password-input-{{ $customer->id }}">
                                        </form>
                                        <!-- More Actions Dropdown -->
                                        <div x-data="{ open: false }" class="relative">
                                            <button @click="open = !open" @click.away="open = false" class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center hover:bg-slate-200 transition-all">
                                                <i class="fas fa-ellipsis-h text-[11px]"></i>
                                            </button>
                                            
                                            <div x-show="open" 
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="transform opacity-0 scale-95"
                                                 x-transition:enter-end="transform opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="transform opacity-100 scale-100"
                                                 x-transition:leave-end="transform opacity-0 scale-95"
                                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-premium border border-slate-100 z-50 overflow-hidden"
                                                 style="display: none;">
                                                <div class="p-2">
                                                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="flex items-center gap-3 px-4 py-2.5 text-[11px] font-bold text-slate-600 hover:bg-slate-50 hover:text-primary rounded-lg transition-all">
                                                        <i class="far fa-id-badge w-4"></i> View Profile
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="confirmReset({{ $customer->id }}, '{{ $customer->name }}')" class="flex items-center gap-3 px-4 py-2.5 text-[11px] font-bold text-slate-600 hover:bg-slate-50 hover:text-primary rounded-lg transition-all">
                                                        <i class="fas fa-key w-4 text-[10px]"></i> Change Password
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer / Pagination -->
                <div class="p-10 bg-slate-50/50 border-t border-slate-50 flex items-center justify-between">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">
                        Showing <span class="text-dark">{{ $customers->firstItem() }}</span> to <span class="text-dark">{{ $customers->lastItem() }}</span> of <span class="text-dark">{{ $customers->total() }}</span> records
                    </p>
                    <div>
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </main>

        <footer class="px-10 py-8 text-center text-[10px] font-black text-slate-400 tracking-widest uppercase border-t border-slate-100 bg-white/50 backdrop-blur-md">
            Ticket Kinun • Administrative Management System • © 2026
        </footer>
    </div>

    <!-- SweetAlert2 Delete Confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Confirm Removal',
                text: "This customer's profile and data will be permanently archived.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1B2B46',
                cancelButtonColor: '#F1F5F9',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel',
                padding: '2.5rem',
                borderRadius: '2.5rem',
                customClass: {
                    popup: 'rounded-[2.5rem] border-white/10 shadow-2xl',
                    confirmButton: 'bg-secondary px-8 py-4 rounded-xl font-black text-xs uppercase tracking-widest',
                    cancelButton: 'bg-slate-100 text-slate-500 px-8 py-4 rounded-xl font-black text-xs uppercase tracking-widest'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        function confirmReset(id, name) {
            Swal.fire({
                title: 'Change Password',
                text: `Update password for ${name}`,
                html: `
                    <div class="relative mt-4">
                        <input type="password" id="swal-input-password" class="swal2-input !m-0 !w-full rounded-xl border-slate-200 text-sm font-bold p-4 pr-12" placeholder="Enter custom password">
                        <button type="button" onclick="toggleSwalPassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary transition-colors">
                            <i id="password-toggle-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonColor: '#520C6B',
                cancelButtonColor: '#F1F5F9',
                confirmButtonText: 'Change Now',
                cancelButtonText: 'Cancel',
                padding: '2.5rem',
                borderRadius: '2.5rem',
                preConfirm: () => {
                    const password = Swal.getPopup().querySelector('#swal-input-password').value;
                    if (!password) {
                        Swal.showValidationMessage('You need to enter a password!');
                    } else if (password.length < 8) {
                        Swal.showValidationMessage('Password must be at least 8 characters long!');
                    }
                    return password;
                },
                customClass: {
                    popup: 'rounded-[2.5rem] border-white/10 shadow-2xl',
                    confirmButton: 'bg-primary px-8 py-4 rounded-xl font-black text-xs uppercase tracking-widest',
                    cancelButton: 'bg-slate-100 text-slate-500 px-8 py-4 rounded-xl font-black text-xs uppercase tracking-widest'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reset-password-input-' + id).value = result.value;
                    document.getElementById('reset-form-' + id).submit();
                }
            })
        }

        function toggleSwalPassword() {
            const input = document.getElementById('swal-input-password');
            const icon = document.getElementById('password-toggle-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

    @if(session('success'))
    <script>
        Swal.fire({
            title: 'Action Successful',
            text: "{{ session('success') }}",
            icon: 'success',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#ffffff',
            color: '#0F172A',
            iconColor: '#520C6B',
        });
    </script>
    @endif

    <!-- Mobile Sidebar Interaction Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('toggle-sidebar');

            function toggleMenu() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', toggleMenu);
            if (overlay) overlay.addEventListener('click', toggleMenu);
        });
    </script>
</body>
</html>
