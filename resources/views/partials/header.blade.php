<!-- Header -->
<header class="fixed top-0 left-0 w-full z-30 bg-white border-b border-slate-100 transition-all duration-300">
    <!-- Top Row: Logo, Search, Actions -->
    <div class="max-w-7xl mx-auto px-6 h-16 md:h-20 flex items-center justify-between gap-8">
        <!-- Logo -->
        <a href="/" class="flex-shrink-0">
            <img src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Ticket Kinun Logo" class="h-14 md:h-16 w-auto object-contain">
        </a>

        <!-- Search Bar -->
        <div class="flex-1 max-w-2xl relative hidden md:block">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" placeholder="Search for Movies, Events, Plays, Sports and Activities" class="w-full bg-slate-50 border border-slate-200 pl-12 pr-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all">
        </div>

        <!-- Actions & Mobile Menu Btn -->
        <div class="flex items-center gap-4 md:gap-8">
            <div class="hidden md:flex items-center gap-6">
                @guest
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-dark font-semibold text-[13px] tracking-wide">Login</a>
                    <a href="{{ route('signup') }}" class="bg-[#520C6B] text-white px-6 py-2 rounded-lg font-bold text-[13px] tracking-wide hover:shadow-lg hover:-translate-y-0.5 transition-all uppercase">Sign Up</a>
                @else
                    <div class="flex items-center gap-6" x-data="{ open: false }">
                        <!-- Profile Trigger -->
                        <div class="relative">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 group focus:outline-none">
                                <div class="text-right hidden sm:block">
                                    <p class="text-[11px] font-black text-dark uppercase tracking-widest group-hover:text-primary transition-colors">{{ Auth::user()->name }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Verified Member</p>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-slate-100 border-2 border-white shadow-sm overflow-hidden group-hover:border-primary/20 transition-all">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-primary/5 text-primary text-xs font-black">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                            </button>

                            <!-- Professional Dropdown -->
                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                class="absolute right-0 mt-3 w-64 bg-white rounded-3xl shadow-2xl border border-slate-100 py-3 z-50 overflow-hidden"
                                style="display: none;">
                                
                                <div class="px-6 py-4 border-b border-slate-50 mb-2">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Account</p>
                                    <p class="text-xs font-bold text-dark truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <a href="{{ route('profile') }}" class="flex items-center gap-4 px-6 py-3 text-slate-600 hover:text-primary hover:bg-primary/5 transition-all group">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center group-hover:bg-white shadow-sm transition-all"><i class="fas fa-user-circle text-xs"></i></div>
                                    <span class="text-xs font-black uppercase tracking-wider">My Profile</span>
                                </a>

                                <a href="{{ route('bookings.index') }}" class="flex items-center gap-4 px-6 py-3 text-slate-600 hover:text-primary hover:bg-primary/5 transition-all group">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center group-hover:bg-white shadow-sm transition-all"><i class="fas fa-ticket-alt text-xs"></i></div>
                                    <span class="text-xs font-black uppercase tracking-wider">My Bookings</span>
                                </a>

                                <div class="mt-2 pt-2 border-t border-slate-50">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-4 px-6 py-3 text-red-500 hover:bg-red-50 transition-all group">
                                            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center group-hover:bg-white shadow-sm transition-all text-red-400"><i class="fas fa-sign-out-alt text-xs"></i></div>
                                            <span class="text-xs font-black uppercase tracking-wider">Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile Search Icon -->
            <button class="md:hidden text-slate-600 hover:text-primary transition-colors">
                <i class="fas fa-search text-xl"></i>
            </button>

            <!-- Burger -->
            <button id="mobile-menu-btn" class="md:hidden text-slate-900 focus:outline-none hover:text-primary transition-colors">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Drawer Overlay -->
    <div id="mobile-drawer-overlay" class="fixed inset-0 bg-dark/60 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300"></div>

    <!-- Mobile Drawer -->
    <div id="mobile-drawer" class="fixed top-0 right-0 w-[300px] h-full bg-white z-[70] translate-x-full transition-transform duration-500 ease-in-out shadow-2xl flex flex-col">
        <div class="p-6 flex items-center justify-between border-b border-slate-50">
            <span class="font-outfit font-black text-xl text-dark">Menu</span>
            <button id="close-drawer" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-dark transition-all">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-6">
            <nav class="space-y-6">
                <div>
                    <span class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-4 block">Navigation</span>
                    <ul class="space-y-4">
                        <li><a href="{{ url('/') }}" class="flex items-center gap-4 text-dark font-bold hover:text-primary transition-colors"><i class="fas fa-home w-5 text-slate-300"></i> Home</a></li>
                        <li><a href="{{ route('events') }}" class="flex items-center gap-4 text-dark font-bold hover:text-primary transition-colors"><i class="fas fa-ticket-alt w-5 text-slate-300"></i> Events</a></li>
                        <li><a href="{{ route('gallery') }}" class="flex items-center gap-4 text-dark font-bold hover:text-primary transition-colors"><i class="fas fa-images w-5 text-slate-300"></i> Gallery</a></li>
                        <li><a href="{{ route('about') }}" class="flex items-center gap-4 text-dark font-bold hover:text-primary transition-colors"><i class="fas fa-info-circle w-5 text-slate-300"></i> About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="flex items-center gap-4 text-dark font-bold hover:text-primary transition-colors"><i class="fas fa-envelope w-5 text-slate-300"></i> Contact</a></li>
                    </ul>
                </div>

                <div class="pt-6 border-t border-slate-50">
                    <span class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-4 block">Account</span>
                    @guest
                        <div class="grid grid-cols-1 gap-3">
                            <a href="{{ route('login') }}" class="w-full py-4 rounded-2xl bg-slate-50 text-dark font-black text-xs text-center tracking-widest hover:bg-slate-100 transition-all uppercase">Login</a>
                            <a href="{{ route('signup') }}" class="w-full py-4 rounded-2xl bg-primary text-white font-black text-xs text-center tracking-widest shadow-lg shadow-primary/20 hover:bg-primary-dark transition-all uppercase">Sign Up Free</a>
                        </div>
                    @else
                        <div class="space-y-4">
                            <p class="text-[11px] font-black text-slate-500 uppercase">Logged in as: {{ Auth::user()->name }}</p>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-4 rounded-2xl bg-red-50 text-red-500 font-black text-xs text-center tracking-widest hover:bg-red-100 transition-all uppercase">Logout</button>
                            </form>
                        </div>
                    @endguest
                </div>
            </nav>
        </div>

        <div class="p-8 bg-slate-50 text-center">
            <p class="text-[10px] font-bold text-slate-400 tracking-wider">TICKET KINUN V2.0</p>
        </div>
    </div>

    <!-- Bottom Row: Navigation Links -->
    <div class="bg-slate-50/50 border-t border-slate-100 hidden md:block">
        <div class="max-w-7xl mx-auto px-6 h-12 flex items-center">
            <nav>
                <ul class="flex items-center gap-8">
                    <li><a href="{{ url('/') }}" class="text-slate-600 hover:text-primary font-bold text-[12px] tracking-wider {{ request()->is('/') ? 'text-primary' : '' }}">HOME</a></li>
                    <li><a href="{{ route('events') }}" class="text-slate-600 hover:text-primary font-bold text-[12px] tracking-wider {{ request()->is('events') ? 'text-primary' : '' }}">EVENTS</a></li>
                    <li><a href="{{ route('gallery') }}" class="text-slate-600 hover:text-primary font-bold text-[12px] tracking-wider {{ request()->is('gallery') ? 'text-primary' : '' }}">GALLERY</a></li>
                    <li><a href="{{ route('about') }}" class="text-slate-600 hover:text-primary font-bold text-[12px] tracking-wider {{ request()->is('about') ? 'text-primary' : '' }}">ABOUT</a></li>
                    <li><a href="{{ route('contact') }}" class="text-slate-600 hover:text-primary font-bold text-[12px] tracking-wider {{ request()->is('contact') ? 'text-primary' : '' }}">CONTACT</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
