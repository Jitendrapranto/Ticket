<aside id="admin-sidebar" class="fixed top-0 left-0 h-full w-72 bg-[#1B2B46] text-white transition-transform duration-300 transform -translate-x-full lg:translate-x-0 z-50 overflow-y-auto no-scrollbar shadow-2xl border-r border-white/5">
    <!-- Sidebar Header -->
    <div class="p-8 border-b border-white/5">
        <a href="/" class="flex flex-col items-center gap-4">
            <img src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Logo" class="h-16 w-auto object-contain brightness-0 invert">
            <div class="text-center">
                <span class="text-[10px] font-black tracking-[0.4em] text-accent uppercase">Super Admin</span>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-6 space-y-2">
        <!-- Overview -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block">Core</span>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-primary border-primary/20 shadow-premium' : 'bg-white/5 border-white/5' }} rounded-2xl text-white text-sm font-bold transition-all border group">
            <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-blue-500/10' }} flex items-center justify-center transition-colors group-hover:bg-blue-500/20">
                <i class="fa-solid fa-th-large {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-blue-400' }}"></i>
            </div>
            Dashboard
        </a>

        <!-- Marketplace -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Event Management</span>
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500/20">
                        <i class="fa-solid fa-calendar-alt text-emerald-400"></i>
                    </div>
                    Events
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.events.hero') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Hero Section
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Published Events
                </a>
                <a href="{{ route('admin.events.drafts') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Draft Events
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Categories
                </a>
            </div>
        </div>

        <!-- Home Page Management -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Home Page</span>
        <div x-data="{ open: {{ request()->routeIs('admin.home.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-indigo-500/10 flex items-center justify-center group-hover:bg-indigo-500/20">
                        <i class="fa-solid fa-home text-indigo-400"></i>
                    </div>
                    Home
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.home.features.index') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.home.features.*') ? 'text-white font-black' : 'text-white/60 hover:text-white' }} text-sm font-medium transition-all">
                    Platform Features
                </a>
                <a href="{{ route('admin.home.cta.edit') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.home.cta.*') ? 'text-white font-black' : 'text-white/60 hover:text-white' }} text-sm font-medium transition-all">
                    CTA Section
                </a>
            </div>
        </div>

        <!-- Gallery Management -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Gallery Space</span>
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-pink-500/10 flex items-center justify-center group-hover:bg-pink-500/20">
                        <i class="fa-solid fa-images text-pink-400"></i>
                    </div>
                    Gallery
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.gallery.hero') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Hero Section
                </a>
                <a href="{{ route('admin.gallery.images.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Manage Images
                </a>
            </div>
        </div>

        <!-- About Page -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Pages</span>
        <div x-data="{ open: {{ request()->routeIs('admin.about.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-orange-500/10 flex items-center justify-center group-hover:bg-orange-500/20">
                        <i class="fa-solid fa-info-circle text-orange-400"></i>
                    </div>
                    About
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.about.hero.edit') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.about.hero.*') ? 'text-white font-black' : 'text-white/60 hover:text-white' }} text-sm font-medium transition-all">
                    Hero Section
                </a>
                <a href="{{ route('admin.about.story.edit') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Our Story Section
                </a>
                <a href="{{ route('admin.about.statistics.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Statistics Section
                </a>
                <a href="{{ route('admin.about.advantages.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Advantages Section
                </a>
                <a href="{{ route('admin.about.cta.edit') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Call To Action
                </a>
            </div>
        </div>

        <!-- Contact Page -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Contact</span>
        <div x-data="{ open: {{ request()->routeIs('admin.contact.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-cyan-500/10 flex items-center justify-center group-hover:bg-cyan-500/20">
                        <i class="fa-solid fa-envelope text-cyan-400"></i>
                    </div>
                    Contact
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.contact.hero.edit') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Hero Section
                </a>
                <a href="{{ route('admin.contact.cards.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Manage Cards
                </a>
                <a href="{{ route('admin.contact.form.edit') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Form Section
                </a>
                <a href="{{ route('admin.contact.support.edit') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Support Section
                </a>
                <a href="{{ route('admin.contact.map.edit') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Map Section
                </a>
            </div>
        </div>

        <!-- Users & Staff -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Users & Staff</span>

        <!-- Organizer Requests -->
        @php $pendingOrganizerCount = \App\Models\User::where('role','pending_organizer')->where('organizer_status','pending')->count(); @endphp
        <a href="{{ route('admin.organizer-requests.index') }}" class="flex items-center justify-between gap-4 px-4 py-3 {{ request()->routeIs('admin.organizer-requests.*') ? 'bg-primary border-primary/20 shadow-premium' : 'border-transparent hover:bg-white/5 hover:border-white/5' }} rounded-2xl text-white/60 hover:text-white text-sm font-bold transition-all border group">
            <div class="flex items-center gap-4">
                <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.organizer-requests.*') ? 'bg-white/20' : 'bg-purple-500/10' }} flex items-center justify-center transition-colors group-hover:bg-purple-500/20">
                    <i class="fa-solid fa-user-tie {{ request()->routeIs('admin.organizer-requests.*') ? 'text-white' : 'text-purple-400' }}"></i>
                </div>
                Organizer Requests
            </div>
            @if($pendingOrganizerCount > 0)
            <span class="bg-[#FFE700] text-[#1B2B46] text-[9px] font-black px-2 py-0.5 rounded-full animate-pulse">{{ $pendingOrganizerCount }}</span>
            @endif
        </a>
       
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-violet-500/10 flex items-center justify-center group-hover:bg-violet-500/20">
                        <i class="fa-solid fa-users text-violet-400"></i>
                    </div>
                    Customers
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    All Customers
                </a>
                <a href="{{ route('admin.customers.segmentation') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-medium transition-all">
                    Segmentation
                </a>
            </div>
        </div>

        <!-- Finance & Commission -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Finance & Commission</span>
        <div x-data="{ open: {{ request()->routeIs('admin.finance.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-teal-500/10 flex items-center justify-center group-hover:bg-teal-500/20">
                        <i class="fa-solid fa-hand-holding-usd text-teal-400"></i>
                    </div>
                    Commission
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.finance.commission.index') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.finance.commission.index') ? 'text-white bg-white/5 rounded-lg border border-white/10 shadow-lg' : 'text-white/60' }} hover:text-white text-sm font-medium transition-all">
                    Commission Settings
                </a>
                <a href="{{ route('admin.finance.bookings.index') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.finance.bookings.*') ? 'text-white bg-white/5 rounded-lg border border-white/10 shadow-lg' : 'text-white/60' }} hover:text-white text-sm font-medium transition-all">
                    Payment Approval
                </a>
                <a href="{{ route('admin.finance.reports.sales') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.finance.reports.sales') ? 'text-white bg-white/5 rounded-lg border border-white/10 shadow-lg' : 'text-white/60' }} hover:text-white text-sm font-medium transition-all">
                    Sales Reports
                </a>
            </div>
        </div>

        <!-- Checkout Configuration -->
        <a href="{{ route('admin.finance.payment-methods.index') }}" class="flex items-center gap-4 px-4 py-3 {{ request()->routeIs('admin.finance.payment-methods.*') ? 'text-white bg-white/5 rounded-2xl border border-white/10 shadow-lg font-black' : 'text-white/60 hover:bg-white/5 hover:text-white rounded-2xl' }} text-sm font-bold transition-all mt-1 group">
             <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.finance.payment-methods.*') ? 'bg-white/20' : 'bg-rose-500/10' }} flex items-center justify-center transition-colors group-hover:bg-rose-500/20">
                <i class="fa-solid fa-shopping-cart {{ request()->routeIs('admin.finance.payment-methods.*') ? 'text-white' : 'text-rose-400' }}"></i>
            </div>
            Checkout
        </a>

        <!-- Payouts -->
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all group">
            <div class="w-8 h-8 rounded-xl bg-blue-500/10 flex items-center justify-center group-hover:bg-blue-500/20">
                <i class="fa-solid fa-wallet text-blue-400"></i>
            </div>
            Payouts
        </a>

        <!-- Settings -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">System</span>
        <div x-data="{ open: {{ request()->routeIs('admin.site.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-slate-500/10 flex items-center justify-center group-hover:bg-slate-500/20">
                        <i class="fa-solid fa-cog text-slate-400"></i>
                    </div>
                    Site Settings
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.site.header.edit') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.site.header.*') ? 'text-white font-black' : 'text-white/60 hover:text-white' }} text-sm font-medium transition-all">
                    Header
                </a>
                <a href="{{ route('admin.site.footer.edit') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.site.footer.*') ? 'text-white font-black' : 'text-white/60 hover:text-white' }} text-sm font-medium transition-all">
                    Footer
                </a>
            </div>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-6 mt-10 border-t border-white/5">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-4 px-4 py-4 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-2xl font-bold transition-all group">
                <div class="w-8 h-8 rounded-xl bg-red-500/20 flex items-center justify-center group-hover:bg-white/20">
                    <i class="fa-solid fa-sign-out-alt text-red-400 group-hover:text-white transition-colors"></i>
                </div>
                Logout
            </button>
        </form>
    </div>
</aside>

<!-- Sidebar Backdrop (Mobile Only) -->
<div id="sidebar-overlay" class="fixed inset-0 bg-dark/60 backdrop-blur-sm z-[45] hidden opacity-0 transition-opacity duration-300"></div>
