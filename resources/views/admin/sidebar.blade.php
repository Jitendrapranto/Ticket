<aside id="admin-sidebar" class="fixed top-0 left-0 h-full w-72 bg-[#1B2B46] text-white transition-transform duration-300 transform -translate-x-full lg:translate-x-0 z-50 overflow-y-auto no-scrollbar shadow-2xl border-r border-white/5">
    <!-- Close Button (Mobile) -->
    <button onclick="document.getElementById('toggle-sidebar').click()" class="lg:hidden absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-white/70 hover:bg-white/10 hover:text-white transition-all z-[60]">
        <i class="fas fa-xmark"></i>
    </button>
    <!-- Sidebar Header -->
    <div class="p-8 border-b border-white/5 space-y-10">
        <a href="{{ route('admin.dashboard') }}" class="flex justify-center">
            <img loading="lazy" src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Logo" class="h-12 w-auto object-contain brightness-0 invert">
        </a>

        <div x-data="{ userOpen: false }" class="relative w-full">
            <button @click="userOpen = !userOpen" class="w-full flex flex-col items-center gap-6 group focus:outline-none">
                <div class="relative">
                    <div class="w-20 h-20 rounded-[2rem] bg-gradient-to-br from-primary to-accent p-0.5 shadow-2xl group-hover:scale-105 transition-transform duration-500">
                        <div class="w-full h-full rounded-[1.8rem] bg-secondary flex items-center justify-center overflow-hidden border-2 border-secondary">
                            @if(Auth::user()->avatar)
                                <img loading="lazy" src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user-shield text-slate-400 text-2xl"></i>
                            @endif
                        </div>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-lg bg-accent text-white flex items-center justify-center shadow-lg border-2 border-secondary group-hover:bg-primary transition-colors">
                        <i class="fas fa-chevron-down text-[8px] transition-transform" :class="userOpen ? 'rotate-180' : ''"></i>
                    </div>
                </div>
                <div class="text-center">
                    <h4 class="text-white font-black text-sm tracking-tight group-hover:text-accent transition-colors leading-none mb-1.5">{{ Auth::user()->name }}</h4>
                    <p class="text-[8px] font-black tracking-[0.4em] text-accent uppercase">Super Admin</p>
                </div>
            </button>

            <!-- Profile Dropdown Content -->
            <div x-show="userOpen"
                 @click.away="userOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="absolute left-1/2 -translate-x-1/2 mt-4 w-56 bg-white rounded-[1.5rem] shadow-2xl py-3 z-[60] border border-slate-100 overflow-hidden"
                 style="display: none;">

                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-6 py-3 text-slate-600 hover:text-primary hover:bg-slate-50 transition-all group/item">
                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center group-hover/item:bg-white shadow-sm transition-all text-xs">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest">View Profile</span>
                </a>

                <div class="mx-4 my-2 border-t border-slate-50"></div>

                <form action="{{ route('admin.logout') }}" method="POST" class="px-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all group/logout">
                        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center group-hover/logout:bg-white/20 shadow-sm transition-all text-xs">
                            <i class="fas fa-power-off"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest">Logout</span>
                    </button>
                </form>
            </div>
        </div>
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
                <a href="{{ route('admin.contact.messages.index') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.contact.messages.*') ? 'text-white font-black' : 'text-white/60 hover:text-white' }} text-sm font-medium transition-all">
                    Contact Messages
                    @php $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                    @if($unreadCount > 0)
                        <span class="ml-auto bg-primary text-white text-[9px] font-black px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
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
        <div x-data="{ open: {{ request()->routeIs('admin.payout.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl text-sm font-bold transition-all focus:outline-none group">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-xl bg-blue-500/10 flex items-center justify-center group-hover:bg-blue-500/20">
                        <i class="fa-solid fa-wallet text-blue-400"></i>
                    </div>
                    Payout
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform text-white/20" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-2 ml-4 space-y-1 border-l border-white/5 pl-4" x-cloak>
                <a href="{{ route('admin.payout.requests') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.payout.requests') ? 'text-white font-black' : 'text-white/60 hover:text-white' }} text-sm font-medium transition-all">
                    Withdraw Request
                </a>
                <a href="{{ route('admin.payout.history') }}" class="flex items-center gap-4 px-4 py-2 {{ request()->routeIs('admin.payout.history') ? 'text-white font-black' : 'text-white/60 hover:text-white' }} text-sm font-medium transition-all">
                    Withdraw HistorY
                </a>
            </div>
        </div>

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
