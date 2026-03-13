<aside id="scanner-sidebar" 
    class="fixed top-0 left-0 h-full w-72 bg-[#1B2B46] text-white transition-transform duration-300 transform z-50 overflow-y-auto no-scrollbar shadow-2xl lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    
    <!-- Mobile Close Button -->
    <button @click="sidebarOpen = false" class="lg:hidden absolute top-6 right-6 w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 hover:bg-white/10 transition-colors">
        <i class="fas fa-times text-white/50"></i>
    </button>

    <!-- Sidebar Header -->
    <div class="p-8 border-b border-white/5 text-center">
        <a href="/" class="flex flex-col items-center gap-4">
            <img loading="lazy" src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Logo" class="h-16 w-auto object-contain brightness-0 invert">
            <div>
                <span class="text-[10px] font-black tracking-[0.4em] text-accent uppercase">On-Site Scanner</span>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-6 space-y-2">
        <!-- Overview -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block">Monitoring</span>
        <a href="{{ route('scanner.dashboard') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('scanner.dashboard') ? 'bg-white/10 text-white' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all border border-white/10">
            <i class="fa-solid fa-chart-line text-sky-400"></i> Dashboard
        </a>

        <!-- Scan Section -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Actions</span>
        <div x-data="{ open: {{ request()->routeIs('scanner.scan') || request()->routeIs('scanner.manual-checkin') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('scanner.scan*') || request()->routeIs('scanner.manual-checkin*') ? 'bg-white/10 text-white' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all border border-white/10">
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-qrcode text-emerald-400"></i> Scan & Verify
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 space-y-1 pl-12 border-l border-white/5 ml-4">
                <a href="{{ route('scanner.scan') }}" class="block py-2 text-xs font-bold {{ request()->routeIs('scanner.scan') ? 'text-accent' : 'text-white/40' }} hover:text-white transition-colors">QR Code Scan</a>
                <a href="{{ route('scanner.manual-checkin') }}" class="block py-2 text-xs font-bold {{ request()->routeIs('scanner.manual-checkin') ? 'text-accent' : 'text-white/40' }} hover:text-white transition-colors">Manual Check-in</a>
            </div>
        </div>

        <!-- Authentication -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">System</span>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all border border-white/10" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-sign-out-alt text-red-500"></i> Log Out
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </nav>

    <!-- Support/Info -->
    <div class="absolute bottom-0 left-0 w-full p-8 border-t border-white/5 bg-white/5">
        <div class="flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <span class="text-[10px] font-bold text-white/40 uppercase tracking-widest">System Online</span>
        </div>
    </div>
</aside>
