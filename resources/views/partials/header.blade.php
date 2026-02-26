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
                <a href="#" class="text-slate-600 hover:text-dark font-semibold text-[13px] tracking-wide">Login</a>
                <a href="#" class="bg-[#520C6B] text-white px-6 py-2 rounded-lg font-bold text-[13px] tracking-wide hover:shadow-lg hover:-translate-y-0.5 transition-all">SIGN UP</a>
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
                    <div class="grid grid-cols-1 gap-3">
                        <a href="#" class="w-full py-4 rounded-2xl bg-slate-50 text-dark font-black text-xs text-center tracking-widest hover:bg-slate-100 transition-all uppercase">Login</a>
                        <a href="#" class="w-full py-4 rounded-2xl bg-primary text-white font-black text-xs text-center tracking-widest shadow-lg shadow-primary/20 hover:bg-primary-dark transition-all uppercase">Sign Up Free</a>
                    </div>
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
