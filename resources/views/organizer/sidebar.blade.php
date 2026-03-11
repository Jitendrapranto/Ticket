<aside id="organizer-sidebar" class="fixed top-0 left-0 h-full w-72 bg-[#1B2B46] text-white transition-transform duration-300 transform -translate-x-full lg:translate-x-0 z-50 overflow-y-auto no-scrollbar shadow-2xl">
    <!-- Sidebar Header -->
    <div class="p-8 border-b border-white/5">
        <a href="/" class="flex flex-col items-center gap-4">
            <img src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Logo" class="h-16 w-auto object-contain brightness-0 invert">
            <div class="text-center">
                <span class="text-[10px] font-black tracking-[0.4em] text-accent uppercase">Organizer</span>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-6 space-y-2">
        <!-- Overview -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block">Core</span>
        <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('organizer.dashboard') ? 'bg-white/10 text-white' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all border border-white/10">
            <i class="fa-solid fa-th-large text-sky-400"></i> Dashboard
        </a>

        <!-- Event Management -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Event Management</span>
        <a href="{{ route('organizer.events.index') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('organizer.events.index') ? 'bg-white/10 text-white' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all border border-white/10">
            <i class="fa-solid fa-calendar-alt text-amber-400"></i> My Events
        </a>
        <a href="{{ route('organizer.events.create') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('organizer.events.create') ? 'bg-white/10 text-white' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all border border-white/10">
            <i class="fa-solid fa-plus text-emerald-400"></i> Create Event
        </a>
        <a href="{{ route('organizer.scanners.index') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('organizer.scanners.*') ? 'bg-white/10 text-white' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all border border-white/10 mt-1">
            <i class="fa-solid fa-qrcode text-violet-400"></i> Scanners
        </a>

        <!-- Customer CRM -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Audience</span>
        <div x-data="{ open: {{ request()->routeIs('organizer.customers.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('organizer.customers.*') ? 'bg-white/10 text-white' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all">
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-users-cog text-sky-400"></i> Customers
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 space-y-1 pl-12">
                <a href="{{ route('organizer.customers.index') }}" class="block py-2 text-xs font-bold {{ request()->routeIs('organizer.customers.index') ? 'text-accent' : 'text-white/40' }} hover:text-white transition-colors">All Customers</a>
                <a href="{{ route('organizer.customers.segmentation') }}" class="block py-2 text-xs font-bold {{ request()->routeIs('organizer.customers.segmentation') ? 'text-accent' : 'text-white/40' }} hover:text-white transition-colors">Segmentation</a>
            </div>
        </div>

        <!-- Revenue -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Financials</span>
        <a href="{{ route('organizer.reports.sales') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('organizer.reports.sales') ? 'bg-white/10 text-white' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all">
            <i class="fa-solid fa-chart-line text-green-400"></i> Sales Reports
        </a>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all">
            <i class="fa-solid fa-wallet text-violet-400"></i> Payouts
        </a>

        <!-- Settings -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">System</span>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-sign-out-alt text-red-500"></i> Log Out
        </a>
        <form id="logout-form" action="{{ route('organizer.logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </nav>

</aside>
