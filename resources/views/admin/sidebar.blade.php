<aside id="admin-sidebar" 
    class="fixed top-0 left-0 h-full w-72 bg-[#1B2B46] text-white transition-transform duration-300 transform lg:translate-x-0 z-50 overflow-y-auto no-scrollbar shadow-2xl border-r border-white/5"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    @click="if($event.target.closest('a') && window.innerWidth < 1024) sidebarOpen = false">
    <!-- Close Button (Mobile) -->
    <button @click="sidebarOpen = false" class="lg:hidden absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-white/70 hover:bg-white/10 hover:text-white transition-all z-[60]">
        <i class="fas fa-xmark"></i>
    </button>
    <!-- Sidebar Header -->
    <div class="p-8 border-b border-white/5 space-y-10">
        <a href="{{ route('admin.dashboard') }}" class="flex justify-center" @click="if(window.innerWidth < 1024) sidebarOpen = false">
            <img loading="lazy" src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Ticket Kinun Logo" class="h-12 w-auto object-contain brightness-0 invert">
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



        <!-- Event Management -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Event Management</span>
        <div x-data="{ open: {{ request()->routeIs('admin.events.*', 'admin.categories.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('admin.events.*', 'admin.categories.*') ? 'text-white bg-white/5' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500/20 transition-all">
                        <i class="fa-solid fa-calendar-alt text-emerald-400"></i>
                    </div>
                    Events
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1 border-l border-white/10 pl-4" x-cloak>
                <a href="{{ route('admin.events.hero') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.events.hero') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.events.hero') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-emerald-400 transition-all"></div>
                    Hero Section
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.events.index') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.events.index') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-emerald-400 transition-all"></div>
                    Published Events
                </a>
                <a href="{{ route('admin.events.drafts') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.events.drafts') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.events.drafts') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-emerald-400 transition-all"></div>
                    Draft Events
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.categories.index') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.categories.index') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-emerald-400 transition-all"></div>
                    Categories
                </a>
            </div>
        </div>

        <div x-data="{ open: {{ request()->routeIs('admin.home.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('admin.home.*') ? 'text-white bg-white/5' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-indigo-500/10 flex items-center justify-center group-hover:bg-indigo-500/20 transition-all">
                        <i class="fa-solid fa-home text-indigo-400"></i>
                    </div>
                    Home
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1 border-l border-white/10 pl-4" x-cloak>
                <a href="{{ route('admin.home.features.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.home.features.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.home.features.*') ? 'bg-indigo-400 shadow-[0_0_8px_rgba(129,140,248,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-indigo-400 transition-all"></div>
                    Platform Features
                </a>
                <a href="{{ route('admin.home.cta.edit') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.home.cta.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.home.cta.*') ? 'bg-indigo-400 shadow-[0_0_8px_rgba(129,140,248,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-indigo-400 transition-all"></div>
                    CTA Section
                </a>
            </div>
        </div>

        <!-- Gallery Management -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Gallery Space</span>
        <div x-data="{ open: {{ request()->routeIs('admin.gallery.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('admin.gallery.*') ? 'text-white bg-white/5' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-pink-500/10 flex items-center justify-center group-hover:bg-pink-500/20 transition-all">
                        <i class="fa-solid fa-images text-pink-400"></i>
                    </div>
                    Gallery
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1 border-l border-white/10 pl-4" x-cloak>
                <a href="{{ route('admin.gallery.hero') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.gallery.hero') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.gallery.hero') ? 'bg-pink-400 shadow-[0_0_8px_rgba(244,114,182,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-pink-400 transition-all"></div>
                    Hero Section
                </a>
                <a href="{{ route('admin.gallery.images.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.gallery.images.index') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.gallery.images.index') ? 'bg-pink-400 shadow-[0_0_8px_rgba(244,114,182,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-pink-400 transition-all"></div>
                    Manage Images
                </a>
            </div>
        </div>

        <!-- About Page -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Pages</span>
        <div x-data="{ open: {{ request()->routeIs('admin.about.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('admin.about.*') ? 'text-white bg-white/5' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-orange-500/10 flex items-center justify-center group-hover:bg-orange-500/20 transition-all">
                        <i class="fa-solid fa-info-circle text-orange-400"></i>
                    </div>
                    About
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1 border-l border-white/10 pl-4" x-cloak>
                <a href="{{ route('admin.about.hero.edit') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.about.hero.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.about.hero.*') ? 'bg-orange-400 shadow-[0_0_8px_rgba(251,146,60,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-orange-400 transition-all"></div>
                    Hero Section
                </a>
                <a href="{{ route('admin.about.story.edit') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.about.story.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.about.story.*') ? 'bg-orange-400 shadow-[0_0_8px_rgba(251,146,60,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-orange-400 transition-all"></div>
                    Our Story
                </a>
                <a href="{{ route('admin.about.statistics.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.about.statistics.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.about.statistics.*') ? 'bg-orange-400 shadow-[0_0_8px_rgba(251,146,60,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-orange-400 transition-all"></div>
                    Statistics
                </a>
                <a href="{{ route('admin.about.advantages.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.about.advantages.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.about.advantages.*') ? 'bg-orange-400 shadow-[0_0_8px_rgba(251,146,60,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-orange-400 transition-all"></div>
                    Advantages
                </a>
                <a href="{{ route('admin.about.cta.edit') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.about.cta.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.about.cta.*') ? 'bg-orange-400 shadow-[0_0_8px_rgba(251,146,60,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-orange-400 transition-all"></div>
                    Call to Action
                </a>
            </div>
        </div>

        <!-- Contact Page -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Contact</span>
        <div x-data="{ open: {{ request()->routeIs('admin.contact.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('admin.contact.*') ? 'text-white bg-white/5' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-cyan-500/10 flex items-center justify-center group-hover:bg-cyan-500/20 transition-all">
                        <i class="fa-solid fa-envelope text-cyan-400"></i>
                    </div>
                    Contact
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1 border-l border-white/10 pl-4" x-cloak>
                <a href="{{ route('admin.contact.hero.edit') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.contact.hero.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.contact.hero.*') ? 'bg-cyan-400 shadow-[0_0_8px_rgba(34,211,238,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-cyan-400 transition-all"></div>
                    Hero Section
                </a>
                <a href="{{ route('admin.contact.cards.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.contact.cards.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.contact.cards.*') ? 'bg-cyan-400 shadow-[0_0_8px_rgba(34,211,238,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-cyan-400 transition-all"></div>
                    Manage Cards
                </a>
                <a href="{{ route('admin.contact.form.edit') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.contact.form.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.contact.form.*') ? 'bg-cyan-400 shadow-[0_0_8px_rgba(34,211,238,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-cyan-400 transition-all"></div>
                    Form Settings
                </a>
                <a href="{{ route('admin.contact.support.edit') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.contact.support.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.contact.support.*') ? 'bg-cyan-400 shadow-[0_0_8px_rgba(34,211,238,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-cyan-400 transition-all"></div>
                    Support Staff
                </a>
                <a href="{{ route('admin.contact.map.edit') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.contact.map.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.contact.map.*') ? 'bg-cyan-400 shadow-[0_0_8px_rgba(34,211,238,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-cyan-400 transition-all"></div>
                    Map View
                </a>
                <a href="{{ route('admin.contact.messages.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.contact.messages.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.contact.messages.*') ? 'bg-cyan-400 shadow-[0_0_8px_rgba(34,211,238,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-cyan-400 transition-all"></div>
                    User Messages
                    @php $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                    @if($unreadCount > 0)
                        <span class="ml-auto bg-primary text-white text-[8px] font-black px-1.5 py-0.5 rounded-full shadow-sm">{{ $unreadCount }}</span>
                    @endif
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

        <div x-data="{ open: {{ request()->routeIs('admin.customers.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('admin.customers.*') ? 'text-white bg-white/5' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-violet-500/10 flex items-center justify-center group-hover:bg-violet-500/20 transition-all">
                        <i class="fa-solid fa-users text-violet-400"></i>
                    </div>
                    Customers
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1 border-l border-white/10 pl-4" x-cloak>
                <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.customers.index') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.customers.index') ? 'bg-violet-400 shadow-[0_0_8px_rgba(167,139,250,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-violet-400 transition-all"></div>
                    Database
                </a>
                <a href="{{ route('admin.customers.segmentation') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.customers.segmentation') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.customers.segmentation') ? 'bg-violet-400 shadow-[0_0_8px_rgba(167,139,250,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-violet-400 transition-all"></div>
                    Segmentation
                </a>
            </div>
        </div>

        <!-- Finance & Commission -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">Finance & Commission</span>
        <div x-data="{ open: {{ request()->routeIs('admin.finance.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('admin.finance.*') ? 'text-white bg-white/5' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-teal-500/10 flex items-center justify-center group-hover:bg-teal-500/20 transition-all">
                        <i class="fa-solid fa-hand-holding-usd text-teal-400"></i>
                    </div>
                    Commission
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1 border-l border-white/10 pl-4" x-cloak>
                <a href="{{ route('admin.finance.commission.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.finance.commission.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.finance.commission.*') ? 'bg-teal-400 shadow-[0_0_8px_rgba(45,212,191,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-teal-400 transition-all"></div>
                    Settings
                </a>
                <a href="{{ route('admin.finance.bookings.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.finance.bookings.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.finance.bookings.*') ? 'bg-teal-400 shadow-[0_0_8px_rgba(45,212,191,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-teal-400 transition-all"></div>
                    Booking Approval
                </a>
                <a href="{{ route('admin.finance.reports.sales') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.finance.reports.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.finance.reports.*') ? 'bg-teal-400 shadow-[0_0_8px_rgba(45,212,191,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-teal-400 transition-all"></div>
                    Sales Audits
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
        <div x-data="{ open: {{ request()->routeIs('admin.payout.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('admin.payout.*') ? 'text-white bg-white/5' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-blue-500/10 flex items-center justify-center group-hover:bg-blue-500/20 transition-all">
                        <i class="fa-solid fa-wallet text-blue-400"></i>
                    </div>
                    Payout
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1 border-l border-white/10 pl-4" x-cloak>
                <a href="{{ route('admin.payout.requests') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.payout.requests') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.payout.requests') ? 'bg-blue-400 shadow-[0_0_8px_rgba(96,165,250,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-blue-400 transition-all"></div>
                    Withdrawals
                </a>
                <a href="{{ route('admin.payout.history') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.payout.history') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.payout.history') ? 'bg-blue-400 shadow-[0_0_8px_rgba(96,165,250,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-blue-400 transition-all"></div>
                    History
                </a>
            </div>
        </div>

        <!-- Settings -->
        <span class="text-[10px] font-black tracking-widest text-white/30 uppercase px-4 py-2 block mt-6">System</span>
        <div x-data="{ open: {{ request()->routeIs('admin.site.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 {{ request()->routeIs('admin.site.*') ? 'text-white bg-white/5' : 'text-white/60' }} hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-slate-500/10 flex items-center justify-center group-hover:bg-slate-500/20 transition-all">
                        <i class="fa-solid fa-cog text-slate-400"></i>
                    </div>
                    Site Settings
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1 border-l border-white/10 pl-4" x-cloak>
                <a href="{{ route('admin.site.header.edit') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.site.header.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.site.header.*') ? 'bg-slate-400 shadow-[0_0_8px_rgba(148,163,184,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-slate-400 transition-all"></div>
                    Header Setup
                </a>
                <a href="{{ route('admin.site.footer.edit') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.site.footer.*') ? 'text-white font-black' : 'text-white/50 hover:text-white' }} text-xs font-medium transition-all group/sub">
                    <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.site.footer.*') ? 'bg-slate-400 shadow-[0_0_8px_rgba(148,163,184,0.5)]' : 'bg-white/10' }} group-hover/sub:bg-slate-400 transition-all"></div>
                    Footer Config
                </a>
            </div>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-6 mt-10 border-t border-white/5">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" @click="if(window.innerWidth < 1024) sidebarOpen = false" class="w-full flex items-center gap-4 px-4 py-4 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-2xl font-bold transition-all group">
                <div class="w-8 h-8 rounded-xl bg-red-500/20 flex items-center justify-center group-hover:bg-white/20">
                    <i class="fa-solid fa-sign-out-alt text-red-400 group-hover:text-white transition-colors"></i>
                </div>
                Logout
            </button>
        </form>
    </div>
</aside>

<!-- Sidebar Backdrop (Mobile Only) -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false"
     x-transition:enter="transition-opacity duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-dark/60 z-[45]" 
     x-cloak></div>
