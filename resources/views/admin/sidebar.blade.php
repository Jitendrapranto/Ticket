<aside id="admin-sidebar" class="fixed top-0 left-0 h-full w-72 bg-[#1B2B46] text-white transition-transform duration-300 transform -translate-x-full lg:translate-x-0 z-50 overflow-y-auto no-scrollbar shadow-2xl">
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
        <a href="#" class="flex items-center gap-4 px-4 py-3 bg-white/10 rounded-2xl text-white text-sm font-bold transition-all border border-white/10">
            <i class="fas fa-th-large text-sky-400"></i> Dashboard
        </a>

        <!-- Marketplace -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Event Management</span>
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none">
                <div class="flex items-center gap-4">
                    <i class="fas fa-calendar-alt text-amber-400"></i> Events
                </div>
                <i class="fas fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.events.hero') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Hero Section
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Published Events
                </a>
                <a href="{{ route('admin.events.drafts') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Draft Events
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Categories
                </a>
            </div>
        </div>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all">
            <i class="fas fa-ticket-alt text-emerald-400"></i> Ticket Types
        </a>

        <!-- Gallery Management -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Gallery Space</span>
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none">
                <div class="flex items-center gap-4">
                    <i class="fas fa-images text-pink-400"></i> Gallery
                </div>
                <i class="fas fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.gallery.hero') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Hero Section
                </a>
                <a href="{{ route('admin.gallery.images.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Manage Images
                </a>
            </div>
        </div>

        <!-- About Page -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Pages</span>
        <div x-data="{ open: {{ request()->routeIs('admin.about.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all">
                <div class="flex items-center gap-4">
                    <i class="fas fa-info-circle text-pink-400"></i> About
                </div>
                <i class="fas fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.about.story.edit') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Our Story Section
                </a>
                <a href="{{ route('admin.about.statistics.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Statistics Section
                </a>
                <a href="{{ route('admin.about.advantages.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Advantages Section
                </a>
                <a href="{{ route('admin.about.cta.edit') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Call To Action
                </a>
            </div>
        </div>

        <!-- Contact Page -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Contact</span>
        <div x-data="{ open: {{ request()->routeIs('admin.contact.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none">
                <div class="flex items-center gap-4">
                    <i class="fas fa-envelope text-sky-400"></i> Contact
                </div>
                <i class="fas fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.contact.hero.edit') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Hero Section
                </a>
                <a href="{{ route('admin.contact.cards.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Manage Cards
                </a>
                <a href="{{ route('admin.contact.form.edit') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Form Section
                </a>
                <a href="{{ route('admin.contact.support.edit') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Support Section
                </a>
                <a href="{{ route('admin.contact.map.edit') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Map Section
                </a>
            </div>
        </div>

        <!-- Users -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Users & Staff</span>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all">
            <i class="fas fa-user-shield text-cyan-400"></i> Moderators
        </a>
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none">
                <div class="flex items-center gap-4">
                    <i class="fas fa-users text-indigo-400"></i> Customers
                </div>
                <i class="fas fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    All Customers
                </a>
                <a href="{{ route('admin.customers.segmentation') }}" class="flex items-center gap-4 px-4 py-2 text-white/60 hover:text-white text-sm font-bold transition-all">
                    Segmentation
                </a>
            </div>
        </div>

        <!-- Revenue -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Financials</span>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all">
            <i class="fas fa-chart-line text-green-400"></i> Sales Reports
        </a>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all">
            <i class="fas fa-wallet text-violet-400"></i> Payouts
        </a>

        <!-- Settings -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">System</span>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all">
            <i class="fas fa-cog text-slate-400 group-hover:rotate-90 transition-transform duration-500"></i> Site Settings
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-6 mt-10 border-t border-white/5">
        <a href="#" class="flex items-center gap-4 px-4 py-4 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-2xl font-bold transition-all group">
            <i class="fas fa-sign-out-alt text-rose-500 group-hover:translate-x-1 transition-transform"></i> Logout
        </a>
    </div>
</aside>

<!-- Sidebar Backdrop (Mobile Only) -->
<div id="sidebar-overlay" class="fixed inset-0 bg-dark/60 backdrop-blur-sm z-[45] hidden opacity-0 transition-opacity duration-300"></div>
