<div class="flex items-center gap-3 pl-6 border-l border-slate-100 ml-2" x-data="{ open: false }">
    <div class="relative">
        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-4 group focus:outline-none">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-black text-dark group-hover:text-primary transition-colors">Super Admin</p>
                <p class="text-[9px] font-black text-primary uppercase tracking-widest">Master Portal</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary to-secondary p-0.5 shadow-premium group-hover:scale-105 transition-transform">
                <div class="w-full h-full rounded-[14px] bg-white flex items-center justify-center overflow-hidden">
                    @if(Auth::check() && Auth::user()->avatar)
                        <img loading="lazy" src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-crown text-primary text-xs"></i>
                    @endif
                </div>
            </div>
        </button>

        <!-- Admin Action Dropdown -->
        <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            class="absolute right-0 mt-4 w-64 bg-white rounded-[2rem] shadow-2xl border border-slate-50 py-4 z-50 overflow-hidden"
            style="display: none;">

            <div class="px-8 py-5 border-b border-slate-50 mb-3 bg-slate-50/50">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Authenticated via SSL</p>
                @auth
                    <p class="text-[11px] font-black text-dark truncate">{{ Auth::user()->email }}</p>
                @endauth
            </div>

            <a href="{{ route('profile') }}" class="flex items-center gap-4 px-8 py-3.5 text-slate-600 hover:text-primary hover:bg-primary/5 transition-all group">
                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center group-hover:bg-white shadow-sm transition-all text-xs"><i class="fas fa-user-edit"></i></div>
                <span class="text-[10px] font-black uppercase tracking-widest">Edit Profile</span>
            </a>

            <a href="/" target="_blank" class="flex items-center gap-4 px-8 py-3.5 text-slate-600 hover:text-primary hover:bg-primary/5 transition-all group">
                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center group-hover:bg-white shadow-sm transition-all text-xs"><i class="fas fa-external-link-alt"></i></div>
                <span class="text-[10px] font-black uppercase tracking-widest">Visit Front End</span>
            </a>

            <div class="mt-3 pt-3 border-t border-slate-50 px-4">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-4 px-6 py-4 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-[1.5rem] transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center group-hover:bg-white/20 shadow-sm transition-all text-red-500 group-hover:text-white text-xs"><i class="fas fa-power-off"></i></div>
                        <span class="text-[10px] font-black uppercase tracking-widest">Secure Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
