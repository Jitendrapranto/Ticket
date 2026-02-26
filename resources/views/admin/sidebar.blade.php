<aside id="admin-sidebar" class="fixed top-0 left-0 h-full w-72 bg-gradient-to-b from-[#520C6B] to-[#21032B] text-white transition-transform duration-300 transform -translate-x-full lg:translate-x-0 z-50 overflow-y-auto no-scrollbar shadow-2xl">
    <!-- Sidebar Header -->
    <div class="p-8 border-b border-white/5">
        <a href="/" class="flex flex-col items-center gap-4">
            <img src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Logo" class="h-16 w-auto object-contain brightness-0 invert">
            <div class="text-center">
                <span class="text-[10px] font-black tracking-[0.4em] text-primary-light uppercase">Super Admin</span>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-6 space-y-2">
        <!-- Overview -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block">Core</span>
        <a href="#" class="flex items-center gap-4 px-4 py-3 bg-white/10 rounded-2xl text-white font-bold transition-all border border-white/10">
            <i class="fas fa-th-large text-primary-light"></i> Dashboard
        </a>

        <!-- Marketplace -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Event Management</span>
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl font-bold transition-all focus:outline-none">
                <div class="flex items-center gap-4">
                    <i class="fas fa-calendar-alt"></i> Events
                </div>
                <i class="fas fa-chevron-down text-[10px] transition-transform" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.events.hero') }}" class="flex items-center gap-4 px-4 py-2 text-white/40 hover:text-white text-xs font-bold transition-all">
                    Hero Section
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/40 hover:text-white text-xs font-bold transition-all">
                    Published Events
                </a>
                <a href="{{ route('admin.events.drafts') }}" class="flex items-center gap-4 px-4 py-2 text-white/40 hover:text-white text-xs font-bold transition-all">
                    Draft Events
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/40 hover:text-white text-xs font-bold transition-all">
                    Categories
                </a>
            </div>
        </div>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl font-bold transition-all">
            <i class="fas fa-ticket-alt"></i> Ticket Types
        </a>
        
        <!-- Gallery Management -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Gallery Space</span>
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl font-bold transition-all focus:outline-none">
                <div class="flex items-center gap-4">
                    <i class="fas fa-images"></i> Gallery
                </div>
                <i class="fas fa-chevron-down text-[10px] transition-transform" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.gallery.hero') }}" class="flex items-center gap-4 px-4 py-2 text-white/40 hover:text-white text-xs font-bold transition-all">
                    Hero Section
                </a>
                <a href="{{ route('admin.gallery.images.index') }}" class="flex items-center gap-4 px-4 py-2 text-white/40 hover:text-white text-xs font-bold transition-all">
                    Manage Images
                </a>
            </div>
        </div>

        <!-- Users -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Users & Staff</span>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl font-bold transition-all">
            <i class="fas fa-user-shield"></i> Moderators
        </a>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl font-bold transition-all">
            <i class="fas fa-users"></i> Customers
        </a>

        <!-- Revenue -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Financials</span>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl font-bold transition-all">
            <i class="fas fa-chart-line"></i> Sales Reports
        </a>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl font-bold transition-all">
            <i class="fas fa-wallet"></i> Payouts
        </a>

        <!-- Settings -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">System</span>
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl font-bold transition-all">
            <i class="fas fa-cog"></i> Site Settings
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-6 mt-10 border-t border-white/5">
        <a href="#" class="flex items-center gap-4 px-4 py-4 bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white rounded-2xl font-bold transition-all">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</aside>

<!-- Sidebar Backdrop (Mobile Only) -->
<div id="sidebar-overlay" class="fixed inset-0 bg-dark/60 backdrop-blur-sm z-[45] hidden opacity-0 transition-opacity duration-300"></div>
