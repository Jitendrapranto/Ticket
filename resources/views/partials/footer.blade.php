<!-- Footer -->
<footer class="bg-gradient-to-r from-[#520C6B] to-[#21032B] text-white pt-24 pb-12 shadow-[0_-10px_40px_-15px_rgba(82,12,107,0.3)]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 mb-20">
            <!-- Branding -->
            <div class="col-span-1">
                <a href="/" class="flex-shrink-0 mb-8 block">
                    <img src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Ticket Kinun Logo" class="h-16 w-auto object-contain brightness-0 invert">
                </a>
                <p class="text-slate-400 leading-relaxed mb-8 max-w-xs font-light">
                    Ticket Kinun is your premier gateway to life's most unforgettable experiences. Discover, book, and enjoy.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 hover:bg-primary hover:border-primary transition-all group">
                        <i class="fab fa-facebook-f text-white/40 group-hover:text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 hover:bg-primary hover:border-primary transition-all group">
                        <i class="fab fa-twitter text-white/40 group-hover:text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 hover:bg-primary hover:border-primary transition-all group">
                        <i class="fab fa-instagram text-white/40 group-hover:text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 hover:bg-primary hover:border-primary transition-all group">
                        <i class="fab fa-linkedin-in text-white/40 group-hover:text-white"></i>
                    </a>
                </div>
            </div>

            <!-- Explorer -->
            <div class="lg:pl-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-1 h-5 bg-accent"></div>
                    <h3 class="font-black text-xs tracking-[0.2em] uppercase">Explorer</h3>
                </div>
                <ul class="space-y-4 text-slate-400 font-medium text-sm">
                    <li><a href="{{ route('events') }}" class="hover:text-white transition-colors">Discover Events</a></li>
                    <li><a href="{{ url('/#trending') }}" class="hover:text-white transition-colors">Trending Now</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">The Kinun Story</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact Us</a></li>
                </ul>
            </div>

            <!-- Collections -->
            <div class="lg:pl-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-1 h-5 bg-accent"></div>
                    <h3 class="font-black text-xs tracking-[0.2em] uppercase">Collections</h3>
                </div>
                <ul class="space-y-4 text-slate-400 font-medium text-sm">
                    <li><a href="{{ route('events') }}?category=concert" class="hover:text-white transition-colors">Live Concerts</a></li>
                    <li><a href="{{ route('events') }}?category=sports" class="hover:text-white transition-colors">Elite Sports</a></li>
                    <li><a href="{{ route('events') }}?category=movies" class="hover:text-white transition-colors">Cinema Premiers</a></li>
                    <li><a href="{{ route('events') }}?category=festival" class="hover:text-white transition-colors">Culture Fests</a></li>
                </ul>
            </div>

            <!-- Get In Touch -->
            <div class="lg:pl-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-1 h-5 bg-accent"></div>
                    <h3 class="font-black text-xs tracking-[0.2em] uppercase">Get In Touch</h3>
                </div>
                <ul class="space-y-6">
                    <li class="flex items-start gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 group-hover:bg-primary/20 transition-all">
                            <i class="fas fa-envelope text-[10px] text-accent"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">EMAIL</span>
                            <span class="text-slate-200 text-sm font-medium leading-none">support@ticketkinun.com</span>
                        </div>
                    </li>
                    <li class="flex items-start gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 group-hover:bg-primary/20 transition-all">
                            <i class="fas fa-phone-alt text-[10px] text-accent"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">HOTLINE</span>
                            <span class="text-slate-200 text-sm font-medium leading-none">+880 1234 567 890</span>
                        </div>
                    </li>
                    <li class="flex items-start gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 group-hover:bg-primary/20 transition-all">
                            <i class="fas fa-map-marker-alt text-[10px] text-accent"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">LOCATION</span>
                            <span class="text-slate-200 text-sm font-medium leading-none">Gulshan, Dhaka, BD</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center text-white/20 text-[10px] font-black">N</div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest leading-loose">
                    Copyright © 2024 Ticket Kinun. Crafted with precision for the ultimate fans.
                </p>
            </div>
            <div class="flex gap-8 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">
                <a href="#" class="hover:text-white transition-colors">Privacy</a>
                <a href="#" class="hover:text-white transition-colors">Terms</a>
                <a href="#" class="hover:text-white transition-colors">Cookies</a>
            </div>
        </div>
    </div>
</footer>
