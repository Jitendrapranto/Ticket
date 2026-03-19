<!-- Header -->
@php
    $h = $siteHeader ?? null;
    $logoSrc = $h && $h->logo_path
        ? (str_starts_with($h->logo_path, 'site/') ? asset('storage/'.$h->logo_path) : asset($h->logo_path))
        : asset('Blue_Simple_Technology_Logo.png');
    $searchPlaceholder = $h->search_placeholder ?? 'Search for Movies, Events, Plays, Sports and Activities';
    $loginText  = $h->login_text ?? 'Login';
    $signupText = $h->signup_text ?? 'Sign Up';
    $navLinks   = $h->nav_links ?? [
        ['label'=>'HOME','url'=>'/'],
        ['label'=>'EVENTS','url'=>'/events'],
        ['label'=>'GALLERY','url'=>'/gallery'],
        ['label'=>'ABOUT','url'=>'/about'],
        ['label'=>'CONTACT','url'=>'/contact'],
    ];
    $curPath = request()->path();
@endphp

<div x-data="{ isMobileNavOpen: false, searchOpen: false }">
    <header style="background-color: #ffffff !important;" 
            class="fixed top-0 left-0 w-full z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 transition-all duration-300">

    {{-- ═══════════════════════════════════════
         TOP ROW: Logo · Search · Auth · Burger
    ════════════════════════════════════════════ --}}
    <div class="max-w-7xl mx-auto px-4 md:px-6 h-16 md:h-20 flex items-center justify-between gap-3 md:gap-6">

        {{-- Logo --}}
        <a href="/" class="flex-shrink-0">
            <img loading="lazy" src="{{ $logoSrc }}" alt="Ticket Kinun" class="h-10 md:h-14 w-auto object-contain">
        </a>

        {{-- Desktop Search --}}
        <form action="{{ route('events') }}" method="GET" class="flex-1 max-w-xl relative hidden lg:block">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="{{ $searchPlaceholder }}"
                   class="w-full bg-slate-50 border border-slate-200 pl-11 pr-10 py-2.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all">
            @if(request('search'))
                <a href="{{ url()->current() }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-xs"></i>
                </a>
            @endif
        </form>

        {{-- Auth + Buttons --}}
        <div class="flex items-center gap-2 md:gap-4">

            {{-- Desktop Auth --}}
            <div class="hidden md:flex items-center gap-3 lg:gap-5">
                @guest
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-primary font-bold text-sm tracking-wide transition-colors">{{ $loginText }}</a>
                    <a href="{{ route('signup') }}" class="bg-primary text-white px-5 py-2 rounded-xl font-black text-[11px] tracking-widest uppercase hover:opacity-90 hover:shadow-lg hover:-translate-y-px transition-all">{{ $signupText }}</a>
                @else
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-2 group focus:outline-none">
                            <div class="hidden xl:block text-right">
                                <p class="text-[11px] font-black text-dark uppercase tracking-widest group-hover:text-primary transition-colors leading-none mb-0.5">{{ Auth::user()->name }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter leading-none">Member</p>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-primary/10 border-2 border-white shadow-sm flex items-center justify-center overflow-hidden group-hover:border-primary/20 transition-all">
                                @if(Auth::user()->avatar)
                                    <img loading="lazy" src="{{ asset('storage/'.Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-primary text-sm font-black">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</span>
                                @endif
                            </div>
                            <i class="fas fa-chevron-down text-[9px] text-slate-400 group-hover:text-primary transition-all" :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                             class="absolute right-0 mt-3 w-60 bg-white rounded-[1.5rem] shadow-xl border border-slate-100 py-2 z-50"
                             style="display:none;">
                            <div class="px-5 py-3 border-b border-slate-50 mb-1">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Account</p>
                                <p class="text-xs font-bold text-dark truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile') }}" class="flex items-center gap-3 px-5 py-2.5 text-slate-600 hover:text-primary hover:bg-primary/5 transition-all group text-xs font-black uppercase tracking-wider">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center group-hover:bg-primary/10 transition-all"><i class="fas fa-user-circle text-xs text-slate-400 group-hover:text-primary"></i></div>
                                My Profile
                            </a>
                            @if(!in_array(Auth::user()->role, ['organizer','admin','pending_organizer']) && Auth::user()->organizer_status !== 'pending')
                            <a href="{{ route('organizer.register') }}" class="flex items-center gap-3 px-5 py-2.5 text-slate-600 hover:text-primary hover:bg-primary/5 transition-all group text-xs font-black uppercase tracking-wider">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center group-hover:bg-primary/10 transition-all"><i class="fas fa-user-tie text-xs text-slate-400 group-hover:text-primary"></i></div>
                                Join as Organizer
                            </a>
                            @endif
                            @if(Auth::user()->role === 'pending_organizer' || Auth::user()->organizer_status === 'pending')
                            <div class="px-3 py-1">
                                <a href="{{ route('organizer.pending') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 animate-pulse"></span> Pending
                                </a>
                            </div>
                            @endif
                            <div class="pt-1 mt-1 border-t border-slate-50">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-5 py-2.5 text-rose-500 hover:bg-rose-50 transition-all group text-xs font-black uppercase tracking-wider">
                                        <div class="w-7 h-7 rounded-lg bg-rose-50 flex items-center justify-center group-hover:bg-white transition-all"><i class="fas fa-sign-out-alt text-xs text-rose-400"></i></div>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>

            <button @click="searchOpen = !searchOpen" type="button"
                    class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl bg-primary/5 text-primary hover:bg-primary/10 transition-all">
                <i class="fas fa-search text-sm"></i>
            </button>

            {{-- ═══════════
                 MENU BTN — visible on MOBILE ONLY
            ══════════════ --}}
            <div class="md:hidden">
                <button @click="isMobileNavOpen = true" type="button"
                        class="flex flex-col items-center justify-center gap-[5px] w-10 h-10 rounded-xl focus:outline-none transition-all active:scale-95"
                        style="background: linear-gradient(135deg,#520C6B,#1B2B46); box-shadow: 0 4px 12px rgba(82,12,107,.35);">
                    <span class="block w-5 h-[2px] bg-white rounded-full"></span>
                    <span class="block w-3.5 h-[2px] bg-white/70 rounded-full"></span>
                    <span class="block w-5 h-[2px] bg-white rounded-full"></span>
                </button>
            </div>

        </div>
    </div>

    {{-- Desktop Nav bar --}}
    <div class="hidden md:block bg-slate-50/60 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-11 flex items-center justify-between">
            <nav>
                <ul class="flex items-center gap-7">
                    @foreach($navLinks as $link)
                        @php $active = ($link['url'] === '/' ? $curPath === '' || $curPath === '/' : str_starts_with('/'.$curPath, $link['url'])); @endphp
                        <li>
                            <a href="{{ $link['url'] }}"
                               class="text-[12px] font-black tracking-wider transition-colors uppercase
                                      {{ $active ? 'text-primary' : 'text-slate-500 hover:text-primary' }}">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            @guest
            <a href="{{ route('organizer.register') }}"
               class="inline-flex items-center gap-2 font-black text-[11px] tracking-widest uppercase px-4 py-1.5 rounded-lg hover:opacity-90 transition-all shadow-sm hover:-translate-y-px"
               style="background:#FFE700; color:#4F0B67;">
                <i class="fas fa-user-tie text-[10px]"></i> Join as a Organizer
            </a>
            @else
                @if(Auth::user()->role === 'user')
                <a href="{{ route('bookings.index') }}"
                   class="inline-flex items-center gap-2 font-black text-[11px] tracking-widest uppercase px-4 py-1.5 rounded-lg hover:opacity-90 transition-all shadow-sm hover:-translate-y-px"
                   style="background:#FFE700; color:#4F0B67;">
                    <i class="fas fa-ticket-alt text-[10px]"></i> My Bookings
                </a>
                @elseif(Auth::user()->role === 'pending_organizer')
                <a href="{{ route('organizer.pending') }}"
                   class="inline-flex items-center gap-2 bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-1.5 rounded-lg font-black text-[11px] uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 animate-pulse"></span> Pending
                </a>
                @endif
            @endguest
        </div>
    </div>

    {{-- Mobile search bar (toggled via Alpine) --}}
    <div x-show="searchOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden border-t border-slate-100 bg-white px-4 py-3" 
         x-cloak>
        <form action="{{ route('events') }}" method="GET" class="relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="{{ $searchPlaceholder }}"
                    class="w-full bg-slate-50 border border-slate-200 pl-11 pr-4 py-2.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all">
        </form>
    </div>

</header>

{{-- ═══════════════════════════════════════════════
     MOBILE DRAWER OVERLAY
════════════════════════════════════════════════════ --}}
<div x-show="isMobileNavOpen"
     @click="isMobileNavOpen = false"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[60] bg-slate-900/60 backdrop-blur-sm"
     x-cloak>
</div>

{{-- ═══════════════════════════════════════════════
     MOBILE NAVIGATION DRAWER
════════════════════════════════════════════════════ --}}
<div x-show="isMobileNavOpen"
     x-transition:enter="transition ease-in-out duration-500 transform"
     x-transition:enter-start="translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in-out duration-500 transform"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="translate-x-full"
     class="fixed top-0 right-0 h-screen z-[70] flex flex-col w-[280px] bg-white shadow-2xl"
     x-cloak>

    {{-- Drawer Header --}}
    <div class="relative flex items-center justify-between px-5 py-4 overflow-hidden flex-shrink-0"
         style="background: linear-gradient(135deg,#520C6B 0%,#1B2B46 100%);">
        {{-- decorative blobs --}}
        <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full" style="background:rgba(255,255,255,0.08);"></div>
        <div class="absolute -bottom-4 left-4 w-14 h-14 rounded-full" style="background:rgba(255,255,255,0.05);"></div>

        <div class="relative flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2);">
                <i class="fas fa-bars-staggered text-white text-sm"></i>
            </div>
            <div>
                <p class="text-white font-black text-sm leading-none tracking-tight">Navigation</p>
                <p class="text-white/50 text-[10px] font-medium mt-0.5">Ticket Kinun</p>
            </div>
        </div>

        <button @click="isMobileNavOpen = false" type="button"
                class="relative w-9 h-9 rounded-xl flex items-center justify-center text-white/60 hover:text-white hover:bg-white/10 transition-all focus:outline-none">
            <i class="fas fa-xmark text-base"></i>
        </button>
    </div>

    {{-- Scrollable body --}}
    <div class="flex-1 overflow-y-auto overscroll-contain min-h-0" style="-webkit-overflow-scrolling: touch;">
        <div class="p-4 space-y-1 pt-5">

            {{-- Section label --}}
            <p class="text-[9px] font-black tracking-[0.3em] text-slate-400 uppercase px-3 pb-2">Pages</p>

            @php
                $mobileNav = [
                    ['href'=>url('/'),         'icon'=>'fa-house',       'label'=>'Home',     'match'=>''],
                    ['href'=>route('events'),  'icon'=>'fa-ticket',      'label'=>'Events',   'match'=>'events'],
                    ['href'=>route('gallery'), 'icon'=>'fa-images',      'label'=>'Gallery',  'match'=>'gallery'],
                    ['href'=>route('about'),   'icon'=>'fa-circle-info', 'label'=>'About Us', 'match'=>'about'],
                    ['href'=>route('contact'), 'icon'=>'fa-envelope',    'label'=>'Contact',  'match'=>'contact'],
                ];
            @endphp

            @foreach($mobileNav as $item)
                @php
                    $isActive = $item['match'] === ''
                        ? ($curPath === '' || $curPath === '/')
                        : str_starts_with($curPath, $item['match']);
                @endphp
                <a href="{{ $item['href'] }}"
                   @click="isMobileNavOpen = false"
                   class="flex items-center gap-3 px-3 py-3 rounded-2xl font-bold text-sm transition-all group"
                   @if($isActive)
                       style="background:linear-gradient(135deg,#520C6B,#1B2B46); color:#fff;"
                   @else
                       style="color:#334155;"
                   @endif>
                    <span class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 transition-all text-sm
                                 {{ $isActive ? 'text-white' : 'text-slate-400 bg-slate-100 group-hover:bg-primary/10 group-hover:text-primary' }}"
                          @if($isActive) style="background:rgba(255,255,255,0.18);" @endif>
                        <i class="fas {{ $item['icon'] }}"></i>
                    </span>
                    <span class="flex-1">{{ $item['label'] }}</span>
                    @if($isActive)
                        <span class="w-1.5 h-1.5 rounded-full bg-white/60 flex-shrink-0"></span>
                    @else
                        <i class="fas fa-chevron-right text-[9px] text-slate-300 group-hover:text-primary/50 flex-shrink-0"></i>
                    @endif
                </a>
            @endforeach

            {{-- Categories section --}}
            @if(isset($activeCategories) && $activeCategories->count() > 0)
                <div class="pt-6 pb-2">
                    <p class="text-[9px] font-black tracking-[0.3em] text-slate-400 uppercase px-3 pb-3">Categories</p>
                    <div class="grid grid-cols-2 gap-2 px-1">
                        @foreach($activeCategories->take(8) as $cat)
                        <a href="{{ route('events', ['search' => $cat->name]) }}"
                           @click="isMobileNavOpen = false"
                           class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-primary/30 hover:bg-primary/5 transition-all">
                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-all">
                                @if($cat->icon)
                                    <i class="{{ $cat->icon }} text-primary text-sm"></i>
                                @else
                                    <i class="fas fa-shapes text-slate-300 text-sm"></i>
                                @endif
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-wider text-slate-600 group-hover:text-primary text-center truncate w-full">{{ $cat->name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Divider --}}
            <div class="border-t border-slate-100 my-4 mx-2"></div>

            {{-- Account label --}}
            <p class="text-[9px] font-black tracking-[0.3em] text-slate-400 uppercase px-3 pb-2">Account</p>

            @guest
                <div class="space-y-2 px-1">
                    <a href="{{ route('login') }}"
                       class="flex items-center justify-center gap-2 w-full py-3 rounded-2xl border border-slate-200 bg-slate-50 font-black text-xs uppercase tracking-widest text-dark hover:bg-slate-100 transition-all">
                        <i class="fas fa-sign-in-alt text-slate-400 text-xs"></i> Login
                    </a>
                    <a href="{{ route('signup') }}"
                       class="flex items-center justify-center gap-2 w-full py-3 rounded-2xl text-white font-black text-xs uppercase tracking-widest hover:opacity-90 transition-all shadow-md"
                       style="background:linear-gradient(135deg,#520C6B,#1B2B46);">
                        <i class="fas fa-user-plus text-xs"></i> Sign Up Free
                    </a>
                    <a href="{{ route('organizer.register') }}"
                       class="flex items-center justify-center gap-2 w-full py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:opacity-90 transition-all"
                       style="background:#FFE700; color:#4F0B67;">
                        <i class="fas fa-user-tie text-xs"></i> Join as a Organizer
                    </a>
                </div>
            @else
                {{-- User card --}}
                <div class="mx-1 p-3 rounded-2xl mb-3 flex items-center gap-3 border border-slate-100"
                     style="background:linear-gradient(135deg,rgba(82,12,107,.06),rgba(27,43,70,.06));">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white font-black text-base flex-shrink-0 shadow-lg"
                         style="background:linear-gradient(135deg,#520C6B,#1B2B46);">
                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-black text-dark leading-none mb-1 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-slate-400 font-medium truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div class="space-y-1 px-1">
                    <a href="{{ route('profile') }}"
                       @click="isMobileNavOpen = false"
                       class="flex items-center gap-3 px-3 py-3 rounded-2xl text-slate-600 font-bold text-sm hover:bg-primary/5 hover:text-primary transition-all group">
                        <span class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center group-hover:bg-primary/10 transition-all">
                            <i class="fas fa-user-circle text-sm text-slate-400 group-hover:text-primary"></i>
                        </span>
                        My Profile
                    </a>

                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                       @click="isMobileNavOpen = false"
                       class="flex items-center gap-3 px-3 py-3 rounded-2xl text-slate-600 font-bold text-sm hover:bg-primary/5 hover:text-primary transition-all group">
                        <span class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center group-hover:bg-primary/10 transition-all">
                            <i class="fas fa-gauge-high text-sm text-slate-400 group-hover:text-primary"></i>
                        </span>
                        Admin Dashboard
                    </a>
                    @elseif(Auth::user()->role === 'organizer')
                    <a href="{{ route('organizer.dashboard') }}"
                       @click="isMobileNavOpen = false"
                       class="flex items-center gap-3 px-3 py-3 rounded-2xl text-slate-600 font-bold text-sm hover:bg-primary/5 hover:text-primary transition-all group">
                        <span class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center group-hover:bg-primary/10 transition-all">
                            <i class="fas fa-gauge-high text-sm text-slate-400 group-hover:text-primary"></i>
                        </span>
                        Organizer Dashboard
                    </a>
                    @endif
                    @if(!in_array(Auth::user()->role, ['organizer','admin','pending_organizer']))
                    <a href="{{ route('bookings.index') }}"
                       class="flex items-center justify-center gap-2 w-full py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:opacity-90 transition-all"
                       style="background:#FFE700; color:#4F0B67;">
                        <i class="fas fa-ticket-alt text-xs"></i> My Bookings
                    </a>
                    @elseif(Auth::user()->role === 'pending_organizer')
                    <a href="{{ route('organizer.pending') }}"
                       class="flex items-center justify-center gap-2 w-full py-3 rounded-2xl bg-yellow-50 border border-yellow-200 text-yellow-700 font-black text-xs uppercase tracking-widest transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 animate-pulse"></span> Pending Approval
                    </a>
                    @endif
                    <div class="pt-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="flex items-center justify-center gap-2 w-full py-3 rounded-2xl bg-rose-50 border border-rose-100 text-rose-500 font-black text-xs uppercase tracking-widest hover:bg-rose-100 transition-all">
                                <i class="fas fa-sign-out-alt text-xs"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endguest

            {{-- Social & Contact info --}}
            @php $sf = \App\Models\SiteFooter::first(); @endphp
            @if($sf)
                <div class="border-t border-slate-100 my-6 mx-2"></div>
                
                <p class="text-[9px] font-black tracking-[0.3em] text-slate-400 uppercase px-3 pb-3">Stay Connected</p>
                <div class="flex gap-3 px-3 pb-6">
                    @if($sf->facebook_url)<a href="{{ $sf->facebook_url }}" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-[#1877F2] hover:text-white transition-all"><i class="fab fa-facebook-f text-sm"></i></a>@endif
                    @if($sf->twitter_url)<a href="{{ $sf->twitter_url }}" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-[#1DA1F2] hover:text-white transition-all"><i class="fab fa-twitter text-sm"></i></a>@endif
                    @if($sf->instagram_url)<a href="{{ $sf->instagram_url }}" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-[#E4405F] hover:text-white transition-all"><i class="fab fa-instagram text-sm"></i></a>@endif
                    @if($sf->linkedin_url)<a href="{{ $sf->linkedin_url }}" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-[#0A66C2] hover:text-white transition-all"><i class="fab fa-linkedin-in text-sm"></i></a>@endif
                </div>

                <p class="text-[9px] font-black tracking-[0.3em] text-slate-400 uppercase px-3 pb-3">Get In Touch</p>
                <div class="px-3 space-y-4 pb-8">
                    @if($sf->contact_email)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center"><i class="fas fa-envelope text-[10px] text-primary"></i></div>
                        <span class="text-xs font-bold text-slate-500">{{ $sf->contact_email }}</span>
                    </div>
                    @endif
                    @if($sf->contact_address)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center"><i class="fas fa-map-marker-alt text-[10px] text-primary"></i></div>
                        <span class="text-xs font-bold text-slate-500">{{ $sf->contact_address }}</span>
                    </div>
                    @endif
                </div>
            @endif

        </div>
    </div>

    {{-- Drawer Footer --}}
    <div class="px-5 py-3 flex-shrink-0 border-t border-slate-100 text-center"
         style="background:linear-gradient(135deg,rgba(82,12,107,.04),rgba(27,43,70,.04));">
        <p class="text-[9px] font-black text-slate-400 tracking-[0.3em] uppercase">Ticket Kinun &copy; {{ date('Y') }}</p>
    </div>
    </div>
</div>
