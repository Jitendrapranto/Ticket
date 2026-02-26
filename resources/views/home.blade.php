@extends('layouts.app')

@section('title', 'Ticket Kinun - Elevate Your Event Experience')

@section('content')
    <!-- Hero Section -->
    <section class="relative mt-12 pt-20 pb-12 bg-[#F1F5F9] overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="relative flex flex-col lg:flex-row items-stretch gap-6 h-auto lg:h-[480px]">

                <!-- Main Slider Container -->
                <div class="flex-1 relative group rounded-[2.5rem] overflow-hidden shadow-premium border border-slate-50 bg-white">
                    <div id="hero-slider" class="flex h-full transition-transform duration-700 ease-in-out">
                        @forelse($featuredEvents as $event)
                        <div class="min-w-full h-full relative bg-dark overflow-hidden">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover opacity-50">
                            @else
                                <div class="w-full h-full bg-primary/10"></div>
                            @endif
                            <div class="absolute inset-0 flex flex-col justify-center px-12 md:px-20">
                                <span class="bg-accent/20 text-accent px-4 py-1 rounded-full text-[10px] font-black tracking-widest uppercase w-fit mb-6">FEATURED EXPERIENCE</span>
                                <h2 class="text-white font-outfit text-5xl md:text-7xl font-black tracking-tighter mb-8 leading-none">{{ $event->title }}</h2>
                                <div class="flex flex-wrap gap-4 mb-10">
                                    <div class="flex items-center gap-2 text-white/60 text-xs font-bold uppercase tracking-widest">
                                        <i class="fas fa-calendar-alt text-accent"></i> {{ $event->date->format('d M, Y') }}
                                    </div>
                                    <div class="flex items-center gap-2 text-white/60 text-xs font-bold uppercase tracking-widest">
                                        <i class="fas fa-map-marker-alt text-primary"></i> {{ $event->location }}
                                    </div>
                                </div>
                                <a href="{{ route('events') }}" class="bg-white text-dark px-10 py-4 rounded-2xl font-black text-xs tracking-widest hover:bg-primary hover:text-white transition-all w-fit uppercase flex items-center gap-3">
                                    Book Your Seat <i class="fas fa-arrow-right text-[8px]"></i>
                                </a>
                            </div>
                        </div>
                        @empty
                        <!-- Fallback Slide -->
                        <div class="min-w-full h-full relative flex items-center bg-white overflow-hidden">
                            <div class="absolute inset-0 opacity-[0.03] bg-[url('https://www.transparenttextures.com/patterns/islamic-exercise.png')]"></div>
                            <div class="relative z-10 w-full px-12 md:px-20 text-center flex flex-col items-center">
                                <h1 class="font-outfit text-5xl md:text-7xl font-black text-dark tracking-tighter leading-none mb-8">
                                    <span class="text-accent">Ticket Kinun</span> <br>
                                    <span class="text-primary">Official 2026</span>
                                </h1>
                                <a href="{{ route('events') }}" class="bg-dark text-white px-10 py-4 rounded-2xl font-black text-xs tracking-widest hover:bg-primary transition-all w-fit uppercase">Explore Events</a>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Navigation Controls -->
                    @if($featuredEvents->count() > 1)
                    <button id="hero-prev" class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/90 backdrop-blur shadow-2xl rounded-full flex items-center justify-center text-dark hover:bg-primary hover:text-white transition-all z-20 opacity-0 group-hover:opacity-100 transform -translate-x-4 group-hover:translate-x-0">
                        <i class="fas fa-chevron-left text-sm"></i>
                    </button>
                    <button id="hero-next" class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/90 backdrop-blur shadow-2xl rounded-full flex items-center justify-center text-dark hover:bg-primary hover:text-white transition-all z-20 opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </button>

                    <!-- Indicators -->
                    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                        @foreach($featuredEvents as $index => $event)
                        <div class="hero-dot w-8 h-1 {{ $index === 0 ? 'bg-primary' : 'bg-slate-200' }} rounded-full transition-all cursor-pointer"></div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Secondary Card: CTA -->
                <div class="lg:w-[380px] bg-dark rounded-[2.5rem] p-10 flex flex-col justify-between relative overflow-hidden group shadow-premium animate-fadeInUp" style="animation-delay: 0.2s">
                    <div class="relative z-10 h-full flex flex-col">
                        <span class="text-primary font-black text-[10px] tracking-[0.3em] uppercase mb-4 block">Quick Overview</span>
                        @if($featuredEvents->count() > 0)
                        <div id="overview-card" class="flex-1 flex flex-col">
                            <h2 id="overview-title" class="font-outfit text-3xl md:text-4xl font-black text-white leading-tight mb-8 tracking-tight transition-all duration-500">
                                {{ $featuredEvents[0]->title }}
                            </h2>

                            <div class="space-y-4 mb-10 text-left">
                                <div class="flex items-center gap-4 group/item">
                                    <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 group-hover/item:border-primary/30 transition-all">
                                        <i class="fas fa-calendar-alt text-xs text-primary"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-500">Date</span>
                                        <span id="overview-date" class="text-xs font-bold text-slate-200 tracking-wide">{{ strtoupper($featuredEvents[0]->date->format('d M, Y')) }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 group/item">
                                    <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/10 group-hover/item:border-accent/30 transition-all">
                                        <i class="fas fa-map-marker-alt text-xs text-accent"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-500">Location</span>
                                        <span id="overview-location" class="text-xs font-bold text-slate-200 tracking-wide">{{ strtoupper($featuredEvents[0]->location) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <h2 class="font-outfit text-3xl font-black text-white mb-8 tracking-tight">Stay tuned for <span class="text-primary">new thrills.</span></h2>
                        @endif

                        <a href="{{ route('events') }}" class="group/btn relative inline-flex items-center gap-3 bg-white/5 border border-white/10 backdrop-blur w-full py-5 rounded-[1.5rem] font-black text-xs tracking-[0.2em] uppercase hover:bg-primary hover:border-primary transition-all overflow-hidden justify-center text-white mt-auto">
                            <span class="relative z-10 flex items-center gap-3">
                                Explore All Events
                                <i class="fas fa-angles-right text-[10px] group-hover/btn:translate-x-1 transition-transform"></i>
                            </span>
                        </a>
                    </div>

                    <!-- Decorative Element -->
                    <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-primary/20 rounded-full blur-[100px] pointer-events-none"></div>
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] pointer-events-none"></div>
                </div>
            </div>
        </div>
    </section>



    <!-- Trending Now - App-Style Layout -->
    <section id="trending" class="py-24 bg-[#E4EDF7]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-end justify-between mb-16 px-4">
                <div>
                    <h2 class="font-outfit text-4xl font-black text-dark mb-2 tracking-tighter">Trending <span>Events</span></h2>
                    <p class="text-slate-400 font-medium tracking-wide">The hottest tickets in town, updated every minute.</p>
                </div>
                <div class="flex gap-3">
                    <button class="w-12 h-12 rounded-2xl border border-slate-100 flex items-center justify-center hover:bg-dark hover:text-white transition-all"><i class="fas fa-chevron-left text-xs"></i></button>
                    <button class="w-12 h-12 rounded-2xl border border-slate-100 flex items-center justify-center hover:bg-dark hover:text-white transition-all"><i class="fas fa-chevron-right text-xs"></i></button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                @forelse($trendingEvents as $event)
                <div class="group bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col h-full border border-slate-50">
                    <!-- Image Section -->
                    <div class="relative h-64 rounded-[1.5rem] overflow-hidden bg-slate-100 shrink-0">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-slate-50 flex items-center justify-center text-slate-200">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        @endif

                        <!-- Overlays -->
                        <div class="absolute inset-x-4 top-4 flex justify-between items-start">
                            <span class="px-3 py-1.5 bg-black/30 backdrop-blur-md rounded-lg text-[10px] font-bold text-white tracking-tight uppercase">
                                {{ $event->category ? $event->category->name : 'TRENDING' }}
                            </span>
                            <span class="px-3 py-1.5 bg-black/40 backdrop-blur-md rounded-lg text-[10px] font-bold text-white tracking-tight flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                Live Now
                            </span>
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="mt-6 flex flex-col flex-1 px-1">
                        <h3 class="font-outfit text-xl font-black text-dark mb-5 leading-tight group-hover:text-primary transition-colors line-clamp-1">
                            {{ $event->title }}
                        </h3>

                        <div class="flex items-start gap-4 mb-6">
                            <!-- Date Card -->
                            <div class="shrink-0 w-14 h-14 bg-dark rounded-2xl flex flex-col items-center justify-center text-white shadow-lg shadow-dark/10">
                                <span class="text-xl font-black leading-none">{{ $event->date->format('d') }}</span>
                                <span class="text-[9px] font-bold uppercase tracking-wider text-white/60">{{ $event->date->format('M') }}</span>
                            </div>

                            <!-- Info List -->
                            <div class="flex flex-col gap-2 pt-1 overflow-hidden">
                                <div class="flex items-start gap-2 text-slate-500 leading-tight">
                                    <i class="fas fa-map-marker-alt text-[10px] mt-1 text-green-500"></i>
                                    <span class="text-[12px] font-bold truncate uppercase tracking-tighter">{{ $event->location }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-400">
                                    <i class="fas fa-tag text-[10px] text-lime-500 rotate-90"></i>
                                    <span class="text-[11px] font-medium">Starts from <span class="text-dark font-black tracking-tighter">৳ {{ number_format($event->price, 0) }}</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Spacer for flex grow -->
                        <div class="flex-1 min-h-[10px]"></div>

                        <a href="#" class="w-full flex items-center justify-center py-4 rounded-2xl bg-slate-50 border border-slate-100 text-dark font-black text-[10px] tracking-[0.3em] uppercase transition-all hover:bg-dark hover:text-white hover:border-dark group-hover:translate-y-[-4px]">
                            BOOK SITE
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-slate-400 font-bold uppercase tracking-widest">No trending events at the moment.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- All Events Section -->
    <section class="py-24 bg-[#F1F5F9]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end gap-10 mb-20 px-4">
                <div class="max-w-md">
                    <h2 class="font-outfit text-5xl font-black text-dark mb-4 tracking-tighter">All <span>Events</span></h2>
                    <p class="text-slate-400 font-medium tracking-wide">Explore our full library of experiences across every category.</p>
                </div>
                <div class="flex gap-4 overflow-x-auto pb-4 no-scrollbar">
                    @foreach(['All', 'Movies', 'Music', 'Sports', 'Theater', 'Workshops'] as $cat)
                        <button class="px-8 py-3 glass rounded-full font-black text-xs tracking-widest transition-all {{ $loop->first ? 'bg-dark text-white border-dark shadow-lg shadow-dark/10' : 'text-slate-400 hover:text-dark hover:border-slate-200' }}">
                            {{ strtoupper($cat) }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-20">
                @forelse($upcomingEvents as $event)
                <div class="group bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col h-full border border-slate-50">
                    <!-- Image Section -->
                    <div class="relative h-56 rounded-[1.5rem] overflow-hidden bg-slate-100 shrink-0">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-200 bg-slate-50">
                                <i class="fas fa-image text-3xl"></i>
                            </div>
                        @endif

                        <!-- Overlays -->
                        <div class="absolute inset-x-4 top-4 flex justify-between items-start">
                            <span class="px-2.5 py-1 bg-black/30 backdrop-blur-md rounded-lg text-[9px] font-bold text-white tracking-tight">
                                {{ $event->category ? $event->category->name : 'General' }}
                            </span>
                            <span class="px-2.5 py-1 bg-black/40 backdrop-blur-md rounded-lg text-[9px] font-bold text-white tracking-tight flex items-center gap-1.5">
                                <span class="w-1 h-1 bg-green-500 rounded-full animate-pulse"></span>
                                Live Now
                            </span>
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="mt-5 flex flex-col flex-1 px-1">
                        <h4 class="font-outfit text-[16px] font-black text-dark mb-4 leading-tight group-hover:text-primary transition-colors line-clamp-1">
                            {{ $event->title }}
                        </h4>

                        <div class="flex items-start gap-3">
                            <!-- Date Card -->
                            <div class="shrink-0 w-12 h-12 bg-dark rounded-xl flex flex-col items-center justify-center text-white shadow-lg shadow-dark/10">
                                <span class="text-lg font-black leading-none">{{ $event->date->format('d') }}</span>
                                <span class="text-[8px] font-bold uppercase tracking-wider text-white/50">{{ $event->date->format('M') }}</span>
                            </div>

                            <!-- Info List -->
                            <div class="flex flex-col gap-1.5 pt-0.5">
                                <div class="flex items-start gap-2 text-slate-500 leading-tight">
                                    <i class="fas fa-map-marker-alt text-[9px] mt-0.5 text-green-500"></i>
                                    <span class="text-[11px] font-bold line-clamp-1 uppercase tracking-tighter">{{ $event->location }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-400">
                                    <i class="fas fa-tag text-[9px] text-lime-500 rotate-90"></i>
                                    <span class="text-[10px] font-medium">Price starts from <span class="text-dark font-black tracking-tighter">৳ {{ number_format($event->price, 0) }}</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Spacer for flex grow -->
                        <div class="flex-1 min-h-[15px]"></div>

                        <a href="#" class="mt-4 w-full flex items-center justify-center py-3 rounded-xl bg-slate-50 border border-slate-100 text-dark font-black text-[9px] tracking-[0.2em] uppercase transition-all hover:bg-dark hover:text-white hover:border-dark group-hover:translate-y-[-2px]">
                            BOOK NOW
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-slate-400 font-bold uppercase tracking-widest">More experiences coming soon.</p>
                </div>
                @endforelse
            </div>

            <div class="text-center">
                <a href="#" class="inline-flex items-center gap-3 px-12 py-5 border-2 border-slate-100 rounded-2xl font-black text-xs tracking-widest hover:border-dark transition-all group">
                    VIEW ALL EXPERIENCES <i class="fas fa-chevron-right text-[8px] group-hover:translate-x-2 transition-transform"></i>
                </a>
            </div>
        </div>
    </section>

     <!-- Flagship Events Review Section -->
    <section class="py-24 bg-[#E4EDF7] overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-left font-outfit text-4xl md:text-5xl font-black text-dark mb-6 tracking-tight">
                    Past Signature Events
                </h2>
                <p class="text-left text-slate-400 text-lg font-light max-w-3xl">
                   A legacy of flawlessly executed events, powered by Ticket Kinun
                </p>
            </div>

            <div class="relative pause-on-hover">
                <div class="overflow-hidden">
                    <!-- Consolidated Single Row Marquee -->
                    <div class="flex gap-6 animate-marquee whitespace-nowrap">
                        @php
                            $allPosters = [
                                ['img' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=600&q=80', 'title' => 'Neon Nights'],
                                ['img' => 'https://images.unsplash.com/photo-1514525253344-f814d0c9e583?auto=format&fit=crop&w=600&q=80', 'title' => 'DJ Summit'],
                                ['img' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=600&q=80', 'title' => 'Electronic Live'],
                                ['img' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=600&q=80', 'title' => 'Festivus 2024'],
                                ['img' => 'https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?auto=format&fit=crop&w=600&q=80', 'title' => 'Rock Arena'],
                                ['img' => 'https://images.unsplash.com/photo-1453086411400-d12555627680?auto=format&fit=crop&w=600&q=80', 'title' => 'Gala Night'],
                                ['img' => 'https://images.unsplash.com/photo-1506157786151-b8491531f063?auto=format&fit=crop&w=600&q=80', 'title' => 'Stage Flow'],
                                ['img' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&w=600&q=80', 'title' => 'Stadium Jam'],
                                ['img' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=600&q=80', 'title' => 'Club Beats'],
                                ['img' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=600&q=80', 'title' => 'Techno Wave'],
                                ['img' => 'https://images.unsplash.com/photo-1429962714451-bb934ecdc4ec?auto=format&fit=crop&w=600&q=80', 'title' => 'Crowd Pulse'],
                                ['img' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=600&q=80', 'title' => 'Pro Arena'],
                            ];
                        @endphp
                        @foreach(array_merge($allPosters, $allPosters) as $poster)
                            <div class="min-w-[300px] h-[200px] rounded-[2rem] overflow-hidden shadow-lg border border-slate-100 flex-shrink-0 group relative cursor-pointer">
                                <img src="{{ $poster['img'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-8">
                                    <h4 class="text-white font-black text-xl">{{ $poster['title'] }}</h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Coming Soon Section -->
    <section class="py-24 bg-[#F1F5F9]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-16 px-4">
                <span class="text-primary font-black tracking-[0.3em] text-[10px] uppercase mb-4 block">GET READY</span>
                <h2 class="font-outfit text-5xl font-black text-dark tracking-tighter">Coming <span>Soon</span></h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @php
                    $comingSoon = [
                        ['cat' => 'FESTIVAL', 'img' => 'https://images.unsplash.com/photo-1459749411177-042180ce673c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80', 'title' => 'Winter Wonder'],
                        ['cat' => 'FASHION', 'img' => 'https://images.unsplash.com/photo-1539109132314-347596ad9c41?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80', 'title' => 'Style Week 2025'],
                        ['cat' => 'STADIUM', 'img' => 'https://images.unsplash.com/photo-1475721027185-403472097e8d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80', 'title' => 'Global Eco Con'],
                        ['cat' => 'THEATER', 'img' => 'https://images.unsplash.com/photo-1503095396549-807759c4bc0e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80', 'title' => 'Shakespeare Live'],
                    ];
                @endphp

                @foreach($comingSoon as $event)
                <div class="relative group bg-white p-5 rounded-[2.5rem] shadow-sm hover:shadow-premium transition-all">
                    <div class="h-64 rounded-[2rem] overflow-hidden mb-6 relative">
                        <img src="{{ $event['img'] }}" class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110">
                        <div class="absolute inset-0 bg-dark/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <button class="bg-white text-dark px-6 py-3 rounded-xl font-bold text-[10px] tracking-widest shadow-xl">NOTIFY ME</button>
                        </div>
                    </div>
                    <div class="text-center">
                        <span class="text-primary font-bold text-[9px] tracking-[0.2em] mb-2 block">{{ $event['cat'] }}</span>
                        <h3 class="font-black text-dark text-lg group-hover:text-primary transition-colors">{{ $event['title'] }}</h3>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Section - Bento Layout -->
    <section class="py-24 bg-[#E4EDF7]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-20 max-w-2xl px-4">
                <span class="text-primary font-black tracking-widest text-[10px] uppercase mb-4 block">PLATFORM SUPERPOWERS</span>
                <h2 class="font-outfit text-5xl font-black text-dark leading-[1.1] tracking-tighter mb-4">Everything Optimized For Your Experience</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 h-auto md:h-[600px]">
                <!-- Main Feature -->
                <div class="md:col-span-8 bg-white p-12 rounded-[3rem] shadow-premium border border-slate-50 flex flex-col justify-between group bento-card relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-black text-4xl text-dark mb-6 leading-tight">Digital-First <br>Smart Ticketing</h3>
                        <p class="text-slate-400 text-lg max-w-sm font-light">Skip the lines with our proprietary zero-wait entry technology. Your phone is your key to the world of events.</p>
                    </div>
                    <div class="relative z-10 flex items-center gap-6">
                        <button class="bg-dark text-white px-10 py-4 rounded-2xl font-bold text-sm shadow-xl shadow-dark/10">LEARN MORE</button>
                    </div>
                    <!-- Decorative Icon -->
                    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-primary/5 rounded-full flex items-center justify-center translate-y-1/4 translate-x-1/4 group-hover:scale-110 transition-transform duration-700">
                        <i class="fas fa-mobile-alt text-[150px] text-primary/10"></i>
                    </div>
                </div>

                <!-- Secondary Features Stack -->
                <div class="md:col-span-4 grid grid-rows-2 gap-6">
                    <div class="bg-primary p-10 rounded-[3rem] text-white bento-card flex flex-col justify-between relative overflow-hidden group">
                        <i class="fas fa-shield-alt text-4xl opacity-20"></i>
                        <div>
                            <h4 class="font-black text-2xl mb-2">Total Security</h4>
                            <p class="text-white/60 text-sm font-medium">Encrypted transactions & anti-fraud tech.</p>
                        </div>
                        <div class="absolute top-0 right-0 p-8 transform translate-x-1/2 -translate-y-1/2 group-hover:translate-x-1/4 group-hover:-translate-y-1/4 transition-transform duration-500">
                             <div class="w-32 h-32 border-4 border-white/10 rounded-full"></div>
                        </div>
                    </div>
                    <div class="bg-white p-10 rounded-[3rem] border border-slate-50 shadow-premium bento-card flex flex-col justify-between group">
                        <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-accent">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-2xl text-dark mb-2">VIP Support</h4>
                            <p class="text-slate-400 text-sm font-medium">Dedicated assistance 24/7/365.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Gallery Mosaic -->
    <section class="py-32 bg-[#F1F5F9]">
        <div class="max-w-7xl mx-auto px-6">
             <div class="flex flex-col md:flex-row items-end justify-between mb-20">
                <div class="max-w-xl">
                    <h2 class="font-outfit text-5xl font-black text-dark mb-6 tracking-tighter leading-none">Moments That <br>Stick Forever</h2>
                    <p class="text-slate-400 text-lg font-light leading-relaxed">Browse through thousands of captured memories from our global community of event lovers.</p>
                </div>
                <div class="mt-8 md:mt-0">
                    <a href="#" class="px-12 py-5 bg-dark text-white rounded-2xl font-black text-sm hover:bg-primary transition-all shadow-xl shadow-dark/10">OPEN GALLERY</a>
                </div>
             </div>

             <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Large Vertical -->
                <div class="col-span-2 row-span-2 rounded-[3.5rem] overflow-hidden group relative h-[700px]">
                    <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-12 left-12 transform translate-y-10 group-hover:translate-y-0 transition-transform duration-700 opacity-0 group-hover:opacity-100">
                        <span class="text-primary font-bold text-xs tracking-widest uppercase mb-4 block">CONCERT / 2024</span>
                        <h4 class="text-white font-black text-3xl leading-tight">Neon World Tour Final</h4>
                    </div>
                </div>

                <div class="rounded-[2.5rem] overflow-hidden h-[340px] group relative">
                    <img src="https://images.unsplash.com/photo-1467810563316-b5476525c0f9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-dark/20 group-hover:bg-primary/20 transition-colors"></div>
                </div>
                <div class="rounded-[2.5rem] overflow-hidden h-[340px] group relative">
                    <img src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                </div>
                <!-- Wide -->
                <div class="col-span-2 rounded-[2.5rem] overflow-hidden h-[340px] group relative">
                    <img src="https://images.unsplash.com/photo-1472653425572-ca97664ff3AD?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">
                    <div class="absolute inset-x-12 bottom-0 top-0 flex flex-col justify-center">
                         <span class="text-white font-black text-2xl tracking-tighter opacity-0 group-hover:opacity-100 transition-opacity translate-x-[-20px] group-hover:translate-x-0 transition-transform duration-700 italic">Experience The Unseen</span>
                    </div>
                </div>
             </div>
        </div>
    </section>

    <!-- Cinematic Final CTA -->
    <section class="py-40 relative bg-[#4F0B67] overflow-hidden">
        <!-- Background Animation -->
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1540575861501-7ad05823123d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80')] bg-cover bg-fixed bg-center opacity-20"></div>

        <div class="max-w-5xl mx-auto px-6 text-center relative z-10 animate-fadeInUp">
            <h2 class="font-outfit text-6xl md:text-8xl font-black text-white leading-[0.8] mb-12 tracking-tighter">Your Journey <br><span class="text-primary tracking-normal">Starts Now.</span></h2>
            <p class="text-xl text-white/40 mb-16 max-w-2xl mx-auto font-light">Join over 2.5 million event enthusiasts discovering the most exclusive experiences every day.</p>

            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="#" class="bg-white text-dark px-16 py-6 rounded-3xl font-black text-lg hover:bg-primary hover:text-white transition-all hover:scale-110 hover:-rotate-2">EXPLORE ALL</a>
                <a href="#" class="glass text-white px-16 py-6 rounded-3xl font-black text-lg hover:border-white transition-all">BE A PARTNER</a>
            </div>
        </div>

        <!-- Floating Decorative Elements -->
        <div class="absolute top-20 right-[10%] w-40 h-40 border-2 border-white/5 rounded-full animate-pulse"></div>
        <div class="absolute bottom-20 left-[10%] w-24 h-24 bg-primary/10 rounded-full blur-2xl"></div>
    </section>
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('hero-slider');
    const dots = document.querySelectorAll('.hero-dot');
    const nextBtn = document.getElementById('hero-next');
    const prevBtn = document.getElementById('hero-prev');

    // Overview Elements
    const overviewTitle = document.getElementById('overview-title');
    const overviewDate = document.getElementById('overview-date');
    const overviewLocation = document.getElementById('overview-location');

    let currentSlide = 0;
    const slideCount = {{ $featuredEvents->count() }};

    if (slideCount <= 0) return;

    const slideData = @json($slideData);

    function updateSlider() {
        slider.style.transform = `translateX(-${currentSlide * 100}%)`;

        // Update Swipe Dots
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.replace('bg-slate-200', 'bg-primary');
                dot.classList.add('w-8');
            } else {
                dot.classList.replace('bg-primary', 'bg-slate-200');
                dot.classList.remove('w-8');
            }
        });

        // Update Overview Card with Fade Effect
        if (overviewTitle && slideData[currentSlide]) {
            overviewTitle.style.opacity = '0';
            overviewTitle.style.transform = 'translateY(10px)';

            setTimeout(() => {
                overviewTitle.innerHTML = slideData[currentSlide].title;
                overviewDate.innerText = slideData[currentSlide].date;
                overviewLocation.innerText = slideData[currentSlide].location;

                overviewTitle.style.opacity = '1';
                overviewTitle.style.transform = 'translateY(0)';
            }, 300);
        }
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % slideCount;
            updateSlider();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + slideCount) % slideCount;
            updateSlider();
        });
    }

    // Auto slide
    if (slideCount > 1) {
        setInterval(() => {
            currentSlide = (currentSlide + 1) % slideCount;
            updateSlider();
        }, 6000);
    }
});
</script>
@endsection
