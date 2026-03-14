<aside id="organizer-sidebar" class="fixed top-0 left-0 h-full w-72 bg-[#1B2B46] text-white transition-transform duration-300 transform -translate-x-full lg:translate-x-0 z-50 overflow-y-auto no-scrollbar shadow-2xl">
    <!-- Close Button (Mobile) -->
    <button onclick="document.getElementById('toggle-sidebar').click()" class="lg:hidden absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-white/70 hover:bg-white/10 hover:text-white transition-all z-[60]">
        <i class="fas fa-xmark"></i>
    </button>
    <!-- Sidebar Header -->
    <div class="p-8 border-b border-white/5 space-y-10">
        <a href="{{ route('organizer.dashboard') }}" class="flex justify-center">
            <img loading="lazy" src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Logo" class="h-12 w-auto object-contain brightness-0 invert">
        </a>

        <div x-data="{ userOpen: false }" class="relative w-full">
            <button type="button" @click.stop="userOpen = !userOpen" class="w-full flex flex-col items-center gap-6 group focus:outline-none cursor-pointer">
                <div class="relative">
                    <div class="w-20 h-20 rounded-[2rem] bg-gradient-to-br from-primary to-accent p-0.5 shadow-2xl group-hover:scale-105 transition-transform duration-500">
                        <div class="w-full h-full rounded-[1.8rem] bg-[#1B2B46] flex items-center justify-center overflow-hidden border-2 border-[#1B2B46]">
                            @if(auth()->user()->avatar)
                                <img loading="lazy" src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user-tie text-slate-400 text-2xl"></i>
                            @endif
                        </div>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-lg bg-accent text-white flex items-center justify-center shadow-lg border-2 border-[#1B2B46] group-hover:bg-primary transition-colors">
                        <i class="fas fa-chevron-down text-[8px] transition-transform" :class="userOpen ? 'rotate-180' : ''"></i>
                    </div>
                </div>
                <div class="text-center">
                    <h4 class="text-white font-black text-sm tracking-tight group-hover:text-amber-400 transition-colors leading-none mb-1.5">{{ auth()->user()->name }}</h4>
                    <p class="text-[8px] font-black tracking-[0.4em] text-accent uppercase">Organizer Account</p>
                </div>
            </button>

            <!-- Profile Dropdown Content -->
            <div x-show="userOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 @click.away="userOpen = false"
                 class="absolute left-0 right-0 mt-6 bg-[#25375A] rounded-[2rem] border border-white/5 shadow-2xl overflow-hidden py-3 z-50">

                <a href="{{ route('profile') }}" class="flex items-center gap-4 px-6 py-4 text-xs font-bold text-white/70 hover:text-white hover:bg-white/5 transition-all">
                    <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center text-[10px] text-accent">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    Manage Profile
                </a>

                <a href="/" target="_blank" class="flex items-center gap-4 px-6 py-4 text-xs font-bold text-white/70 hover:text-white hover:bg-white/5 transition-all">
                    <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center text-[10px] text-sky-400">
                        <i class="fas fa-external-link-alt"></i>
                    </div>
                    Live Preview
                </a>

                <div class="mt-2 pt-2 border-t border-white/5 px-2">
                    <button @click="document.getElementById('logout-form-sidebar').submit()" class="w-full flex items-center gap-4 px-4 py-4 rounded-2xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all group/logout">
                        <div class="w-8 h-8 rounded-xl bg-red-500/20 flex items-center justify-center text-[10px] group-hover/logout:bg-white/20">
                            <i class="fas fa-power-off"></i>
                        </div>
                        <span class="font-black uppercase tracking-widest text-[9px]">Sign Out</span>
                    </button>
                    <form id="logout-form-sidebar" action="{{ route('organizer.logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-6 space-y-2">
        <!-- Overview -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block">Core</span>
        <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('organizer.dashboard') ? 'bg-primary border-primary/20 shadow-premium' : 'bg-white/5 border-white/5' }} rounded-2xl text-white text-sm font-bold transition-all border group">
            <div class="w-8 h-8 rounded-xl {{ request()->routeIs('organizer.dashboard') ? 'bg-white/20' : 'bg-blue-500/10' }} flex items-center justify-center transition-colors group-hover:bg-blue-500/20">
                <i class="fa-solid fa-th-large {{ request()->routeIs('organizer.dashboard') ? 'text-white' : 'text-blue-400' }}"></i>
            </div>
            Dashboard
        </a>

        <!-- Event Management -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Event Management</span>
        <div x-data="{ open: {{ request()->routeIs('organizer.events.*') || request()->routeIs('organizer.scanners.*') ? 'true' : 'false' }} }">
            <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('organizer.events.*') || request()->routeIs('organizer.scanners.*') ? 'bg-white/10' : 'bg-white/5' }} hover:bg-white/10 rounded-2xl text-sm font-bold transition-all focus:outline-none group border border-white/5 cursor-pointer">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-amber-500/10 flex items-center justify-center group-hover:bg-amber-500/20">
                        <i class="fa-solid fa-calendar-alt text-amber-400"></i>
                    </div>
                    Events
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-all text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-cloak class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-transition>
                <a href="{{ route('organizer.events.index') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('organizer.events.index') ? 'text-white font-black' : 'text-white/40 hover:text-white' }} text-sm font-medium transition-all">
                    My Events
                </a>
                <a href="{{ route('organizer.events.create') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('organizer.events.create') ? 'text-white font-black' : 'text-white/40 hover:text-white' }} text-sm font-medium transition-all">
                    Create Event
                </a>
                <a href="{{ route('organizer.scanners.index') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('organizer.scanners.*') ? 'text-white font-black' : 'text-white/40 hover:text-white' }} text-sm font-medium transition-all">
                    Scanners
                </a>
            </div>
        </div>

        <!-- Audience -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Audience</span>
        <div x-data="{ open: {{ request()->routeIs('organizer.customers.*') ? 'true' : 'false' }} }">
            <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('organizer.customers.*') ? 'bg-white/10' : 'bg-white/5' }} hover:bg-white/10 rounded-2xl text-sm font-bold transition-all border border-white/5 cursor-pointer">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-sky-500/10 flex items-center justify-center group-hover:bg-sky-500/20">
                        <i class="fa-solid fa-users text-sky-400"></i>
                    </div>
                    Customers
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-all text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-cloak class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-transition>
                <a href="{{ route('organizer.customers.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('organizer.customers.index') ? 'text-white font-black' : 'text-white/40 hover:text-white' }} transition-colors">All Customers</a>
                <a href="{{ route('organizer.customers.segmentation') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('organizer.customers.segmentation') ? 'text-white font-black' : 'text-white/40 hover:text-white' }} transition-colors">Segmentation</a>
            </div>
        </div>

        <!-- Revenue -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Financials</span>
        <div x-data="{ open: {{ request()->routeIs('organizer.payout.*') || request()->routeIs('organizer.reports.*') ? 'true' : 'false' }} }">
            <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('organizer.payout.*') || request()->routeIs('organizer.reports.*') ? 'bg-white/10' : 'bg-white/5' }} hover:bg-white/10 rounded-2xl text-sm font-bold transition-all border border-white/5 cursor-pointer">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500/20">
                        <i class="fa-solid fa-hand-holding-usd text-emerald-400"></i>
                    </div>
                    Payout
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-all text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-cloak class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-transition>
                <a href="{{ route('organizer.reports.sales') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('organizer.reports.sales') ? 'text-white font-black' : 'text-white/40 hover:text-white' }} transition-colors">Sales Reports</a>
                <a href="{{ route('organizer.payout.requests') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('organizer.payout.requests') ? 'text-white font-black' : 'text-white/40 hover:text-white' }} transition-colors">Withdraw Request</a>
                <a href="{{ route('organizer.payout.history') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('organizer.payout.history') ? 'text-white font-black' : 'text-white/40 hover:text-white' }} transition-colors">Withdraw HistorY</a>
            </div>
        </div>

    </nav>

    <!-- Sidebar Footer -->
    <div class="p-6 mt-10 border-t border-white/5">
        <form action="{{ route('organizer.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-4 px-4 py-4 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-2xl font-bold transition-all group">
                <div class="w-8 h-8 rounded-xl bg-red-500/20 flex items-center justify-center group-hover:bg-white/20 transition-all">
                    <i class="fa-solid fa-sign-out-alt text-red-400 group-hover:text-white transition-colors"></i>
                </div>
                Logout Portal
            </button>
        </form>
    </div>

</aside>
