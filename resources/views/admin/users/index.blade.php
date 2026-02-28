<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Database | Ticket Kinun</title>
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
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
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
                <div class="bg-white p-8 rounded-[2rem] shadow-premium border border-white flex items-center justify-between group hover:-translate-y-1 transition-all duration-300">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Total Customers</p>
                        <h3 class="text-4xl font-outfit font-black text-dark tracking-tighter mb-1">{{ number_format($totalCustomers) }}</h3>
                        <p class="text-[11px] font-bold text-brand-green flex items-center gap-1.5">
                            <i class="fas fa-arrow-up text-[10px]"></i> +12% <span class="text-slate-400 font-medium ml-1">from last month</span>
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-primary/5 text-primary rounded-2xl flex items-center justify-center text-xl group-hover:bg-primary group-hover:text-white transition-all">
                        <i class="far fa-user"></i>
                    </div>
                </div>

                <!-- Active Sessions -->
                <div class="bg-white p-8 rounded-[2rem] shadow-premium border border-white flex items-center justify-between group hover:-translate-y-1 transition-all duration-300">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Active Sessions</p>
                        <h3 class="text-4xl font-outfit font-black text-dark tracking-tighter mb-1">{{ number_format($activeSessions) }}</h3>
                        <p class="text-[11px] font-bold text-slate-400">Currently online</p>
                    </div>
                    <div class="w-14 h-14 bg-brand-green/5 text-brand-green rounded-2xl flex items-center justify-center text-xl group-hover:bg-brand-green group-hover:text-white transition-all">
                        <i class="far fa-check-circle"></i>
                    </div>
                </div>

                <!-- Average LTV -->
                <div class="bg-white p-8 rounded-[2rem] shadow-premium border border-white flex items-center justify-between group hover:-translate-y-1 transition-all duration-300">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Average LTV</p>
                        <h3 class="text-4xl font-outfit font-black text-dark tracking-tighter mb-1">৳{{ number_format($averageLTV, 2) }}</h3>
                        <p class="text-[11px] font-bold text-slate-400">Lifetime Value</p>
                    </div>
                    <div class="w-14 h-14 bg-brand-amber/5 text-brand-amber rounded-2xl flex items-center justify-center text-xl group-hover:bg-brand-amber group-hover:text-white transition-all">
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
                        <button class="bg-slate-50 text-slate-600 px-6 py-3.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-100 transition-all flex items-center gap-3">
                            <i class="fas fa-sliders-h text-[10px]"></i> Filter
                        </button>
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
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">ID: #C-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-7">
                                    <div class="space-y-1.5">
                                        <div class="flex items-center gap-2.5 text-slate-500 hover:text-primary transition-colors cursor-pointer">
                                            <i class="far fa-envelope text-[11px] mt-0.5"></i>
                                            <span class="text-xs font-bold underline underline-offset-4 decoration-slate-200 group-hover:decoration-primary/30">{{ $customer->email }}</span>
                                        </div>
                                        <div class="flex items-center gap-2.5 text-slate-400">
                                            <i class="fas fa-phone-alt text-[10px]"></i>
                                            <span class="text-[11px] font-black">+1 234 567 890</span>
                                        </div>
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
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-[0.1em] border
                                        @if($customer->id % 3 == 0) bg-brand-amber/10 text-brand-amber border-brand-amber/20 
                                        @elseif($customer->id % 4 == 0) bg-brand-red/10 text-brand-red border-brand-red/20 
                                        @else bg-brand-green/10 text-brand-green border-brand-green/20 @endif">
                                        <span class="w-1 h-1 rounded-full currentColor bg-current"></span>
                                        @if($customer->id % 3 == 0) Pending @elseif($customer->id % 4 == 0) Suspended @else Active @endif
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
                                            <button type="button" onclick="confirmDelete({{ $customer->id }})" class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center hover:bg-brand-red hover:text-white hover:border-brand-red transition-all shadow-sm group/btn">
                                                <i class="fas fa-trash text-[11px]"></i>
                                            </button>
                                        </form>
                                        <button class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center hover:bg-slate-200 transition-all">
                                            <i class="fas fa-ellipsis-h text-[11px]"></i>
                                        </button>
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
                confirmButtonColor: '#21032B',
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
