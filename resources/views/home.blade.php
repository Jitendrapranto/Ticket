@extends('layouts.app')

@section('title', 'Ticket Kinun - Elevate Your Event Experience')

@section('content')
    <!-- Hero Section -->
    <section class="relative mt-12 pt-20 pb-12 bg-[#F1F5F9] overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="relative flex flex-col lg:flex-row items-stretch gap-6 h-auto lg:h-[480px]">

                <!-- Left Side: Featured Event Banner Only -->
                <div class="flex-1 relative group rounded-[2.5rem] overflow-hidden shadow-premium border border-slate-50">
                    <div id="hero-slider" class="flex h-full transition-transform duration-700 ease-in-out">
                        @forelse($featuredEvents as $event)
                        <div class="min-w-full h-full relative overflow-hidden">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/30 flex items-center justify-center">
                                    <i class="fas fa-calendar-star text-6xl text-primary/30"></i>
                                </div>
                            @endif
                            
                            <!-- Featured Tag -->
                            <div class="absolute top-6 left-6 z-10">
                                <span class="bg-primary text-white px-5 py-2 rounded-full text-[10px] font-black tracking-widest uppercase shadow-lg flex items-center gap-2">
                                    <i class="fas fa-star text-[8px]"></i> FEATURED
                                </span>
                            </div>

                            <!-- Subtle Gradient Overlay at Bottom -->
                            <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-black/30 to-transparent"></div>
                        </div>
                        @empty
                        <!-- Fallback when no featured events -->
                        <div class="min-w-full h-full relative flex items-center bg-gradient-to-br from-primary/10 to-secondary/20 overflow-hidden">
                            <div class="absolute inset-0 opacity-[0.03] bg-[url('https://www.transparenttextures.com/patterns/islamic-exercise.png')]"></div>
                            <div class="relative z-10 w-full text-center flex flex-col items-center justify-center h-full">
                                <i class="fas fa-calendar-star text-6xl text-primary/30 mb-6"></i>
                                <h3 class="font-outfit text-2xl font-black text-dark/60">No Featured Events</h3>
                                <p class="text-slate-400 text-sm mt-2">Check back soon for exciting events!</p>
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
                        @foreach($featuredEvents as $index => $evt)
                        <div class="hero-dot w-8 h-1 {{ $index === 0 ? 'bg-white' : 'bg-white/40' }} rounded-full transition-all cursor-pointer hover:bg-white"></div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Right Side: Event Details Card -->
                <div class="lg:w-[380px] bg-white rounded-[2.5rem] p-10 flex flex-col justify-between relative overflow-hidden group shadow-premium border border-slate-100 animate-fadeInUp" style="animation-delay: 0.2s">
                    <div class="relative z-10 h-full flex flex-col">
                        <span class="text-primary font-black text-[10px] tracking-[0.3em] uppercase mb-6 block">Quick Overview</span>
                        
                        @if($featuredEvents->count() > 0)
                        <div id="overview-card" class="flex-1 flex flex-col">
                            <h2 id="overview-title" class="font-outfit text-3xl md:text-4xl font-black text-dark leading-tight mb-8 tracking-tight transition-all duration-500">
                                {{ $featuredEvents[0]->title }}
                            </h2>

                            <div class="space-y-5 mb-10 text-left">
                                <div class="flex items-center gap-4 group/item">
                                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center group-hover/item:bg-primary/20 transition-all">
                                        <i class="fas fa-calendar-alt text-sm text-primary"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Date</span>
                                        <span id="overview-date" class="text-sm font-bold text-dark tracking-wide">{{ strtoupper($featuredEvents[0]->date->format('d M, Y')) }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 group/item">
                                    <div class="w-12 h-12 rounded-2xl bg-accent/10 flex items-center justify-center group-hover/item:bg-accent/20 transition-all">
                                        <i class="fas fa-map-marker-alt text-sm text-accent"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Location</span>
                                        <span id="overview-location" class="text-sm font-bold text-dark tracking-wide">{{ strtoupper($featuredEvents[0]->location) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Book Your Seat Button -->
                        <a href="{{ route('events.show', $featuredEvents[0]->slug) }}" id="overview-book-btn" data-slug="{{ $featuredEvents[0]->slug }}" class="group/btn relative inline-flex items-center gap-3 bg-dark w-full py-5 rounded-[1.5rem] font-black text-xs tracking-[0.2em] uppercase hover:bg-primary transition-all overflow-hidden justify-center text-white mt-auto shadow-premium">
                            <span class="relative z-10 flex items-center gap-3">
                                Book Your Seat
                                <i class="fas fa-arrow-right text-[10px] group-hover/btn:translate-x-1 transition-transform"></i>
                            </span>
                        </a>
                        @else
                        <div class="flex-1 flex flex-col items-center justify-center text-center">
                            <i class="fas fa-calendar-xmark text-4xl text-slate-200 mb-4"></i>
                            <h2 class="font-outfit text-2xl font-black text-dark mb-3 tracking-tight">No Events Yet</h2>
                            <p class="text-slate-400 text-sm mb-8">Stay tuned for upcoming featured events.</p>
                        </div>
                        
                        <a href="{{ route('events') }}" class="group/btn relative inline-flex items-center gap-3 bg-dark w-full py-5 rounded-[1.5rem] font-black text-xs tracking-[0.2em] uppercase hover:bg-primary transition-all overflow-hidden justify-center text-white mt-auto shadow-premium">
                            <span class="relative z-10 flex items-center gap-3">
                                Explore All Events
                                <i class="fas fa-arrow-right text-[10px] group-hover/btn:translate-x-1 transition-transform"></i>
                            </span>
                        </a>
                        @endif
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -left-16 -top-16 w-48 h-48 bg-accent/5 rounded-full blur-3xl pointer-events-none"></div>
                </div>
            </div>
        </div>
    </section>



    <!-- Featured Events Carousel Section -->
    <section id="trending" class="py-24 bg-[#E4EDF7] overflow-hidden">
        <!-- Header aligned with main container -->
        <div class="max-w-7xl mx-auto px-6 mb-12">
            <div>
                <h2 class="font-outfit text-4xl font-black text-dark mb-2 tracking-tighter">Featured <span class="text-primary">Events</span></h2>
                <p class="text-slate-400 font-medium tracking-wide">The hottest tickets in town, updated every minute.</p>
            </div>
        </div>

        <!-- Carousel Container - Full width with proper inner alignment -->
        <div class="max-w-7xl mx-auto px-6">
            <div class="overflow-hidden">
                <div id="featured-carousel" class="flex transition-transform duration-500 ease-out gap-6">
                    @forelse($featuredEvents as $index => $event)
                    <a href="{{ route('events.show', $event->slug) }}" class="featured-card shrink-0 w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] group bg-white rounded-[2rem] p-5 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col border border-slate-100">
                        <!-- Image Section -->
                        <div class="relative h-52 rounded-[1.5rem] overflow-hidden bg-slate-100 shrink-0">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary/10 to-secondary/20 flex items-center justify-center text-slate-200">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                            @endif

                            <!-- Overlays -->
                            <div class="absolute inset-x-4 top-4 flex justify-between items-start">
                                <span class="px-4 py-2 bg-primary rounded-xl text-[10px] font-black text-white tracking-wider uppercase shadow-lg">
                                    {{ $event->category ? $event->category->name : 'Featured' }}
                                </span>
                                <span class="px-4 py-2 bg-emerald-500 rounded-xl text-[10px] font-black text-white tracking-wider flex items-center gap-2 shadow-lg">
                                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                    Live Now
                                </span>
                            </div>
                        </div>

                        <!-- Details Section -->
                        <div class="mt-5 flex flex-col flex-1 px-1">
                            <h3 class="font-outfit text-xl font-black text-dark mb-5 leading-tight group-hover:text-primary transition-colors line-clamp-1">
                                {{ $event->title }}
                            </h3>

                            <div class="flex items-start gap-4 mb-5">
                                <!-- Date Card -->
                                <div class="shrink-0 w-14 h-18 bg-primary rounded-xl flex flex-col items-center justify-center text-white shadow-md shadow-primary/20 overflow-hidden">
                                    <span class="text-xl font-black leading-none">{{ $event->date->format('d') }}</span>
                                    <span class="text-[9px] font-bold uppercase tracking-wider text-white/80">{{ $event->date->format('M') }}</span>
                                    <span class="text-[8px] font-medium text-white/60">{{ $event->date->format('Y') }}</span>
                                </div>

                                <!-- Info List -->
                                <div class="flex flex-col gap-2 pt-1 overflow-hidden flex-1">
                                    <div class="flex items-start gap-2 text-slate-600 leading-tight">
                                        <i class="fas fa-map-marker-alt text-xs mt-0.5 text-red-500"></i>
                                        <span class="text-xs font-semibold line-clamp-1">{{ $event->location }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-slate-500">
                                        <i class="fas fa-tag text-xs text-emerald-500"></i>
                                        <span class="text-xs font-semibold">Starts from <span class="text-dark font-black">৳ {{ number_format($event->price, 0) }}</span></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Spacer -->
                            <div class="flex-1 min-h-2"></div>

                            <span class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl bg-secondary text-white font-black text-[10px] tracking-[0.15em] uppercase transition-all group-hover:bg-primary group-hover:shadow-lg group-hover:shadow-primary/30 group-hover:-translate-y-1">
                                Book Your Seat <i class="fas fa-arrow-right text-[9px]"></i>
                            </span>
                        </div>
                    </a>
                    @empty
                    <div class="w-full py-20 text-center">
                        <i class="fas fa-calendar-xmark text-5xl text-slate-200 mb-4"></i>
                        <p class="text-slate-400 font-bold uppercase tracking-widest">No featured events at the moment.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Mobile Navigation Dots -->
            <div class="flex md:hidden justify-center gap-2 mt-8">
                @for($i = 0; $i < min(ceil($featuredEvents->count()), 3); $i++)
                <button class="featured-dot w-3 h-3 rounded-full {{ $i === 0 ? 'bg-primary' : 'bg-slate-300' }} transition-all"></button>
                @endfor
            </div>

            <!-- View All Link -->
            <div class="flex justify-center mt-10">
                <a href="{{ route('events') }}" class="inline-flex items-center gap-3 bg-white px-8 py-4 rounded-2xl text-primary font-bold text-sm hover:bg-primary hover:text-white transition-all shadow-md border border-slate-100">
                    View All Events <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- All Events Section -->
    <section class="py-24 bg-[#F1F5F9]" x-data="{ activeCategory: 'all' }">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header with Filters -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12">
                <div>
                    <h2 class="font-outfit text-4xl font-black text-dark mb-2 tracking-tighter">All <span class="text-primary">Events</span></h2>
                    <p class="text-slate-400 font-medium tracking-wide">Explore our full library of experiences across every category.</p>
                </div>
                <div class="flex gap-3 overflow-x-auto pb-2 no-scrollbar">
                    <button @click="activeCategory = 'all'" 
                            :class="activeCategory === 'all' ? 'bg-dark text-white border-dark shadow-lg' : 'bg-white text-slate-500 border-slate-200 hover:border-dark hover:text-dark'"
                            class="px-6 py-2.5 rounded-full font-black text-[10px] tracking-widest transition-all border whitespace-nowrap">
                        ALL
                    </button>
                    @foreach(\App\Models\EventCategory::all() as $category)
                    <button @click="activeCategory = '{{ strtolower($category->name) }}'" 
                            :class="activeCategory === '{{ strtolower($category->name) }}' ? 'bg-dark text-white border-dark shadow-lg' : 'bg-white text-slate-500 border-slate-200 hover:border-dark hover:text-dark'"
                            class="px-6 py-2.5 rounded-full font-black text-[10px] tracking-widest transition-all border whitespace-nowrap">
                        {{ strtoupper($category->name) }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Events Grid - 3 cards per row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @forelse($upcomingEvents as $event)
                <a href="{{ route('events.show', $event->slug) }}" 
                   x-show="activeCategory === 'all' || activeCategory === '{{ $event->category ? strtolower($event->category->name) : 'general' }}'"
                   x-transition:enter="transition ease-out duration-300"
                   x-transition:enter-start="opacity-0 transform scale-95"
                   x-transition:enter-end="opacity-100 transform scale-100"
                   class="group bg-white rounded-[2rem] p-5 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col border border-slate-100">
                    <!-- Image Section -->
                    <div class="relative h-52 rounded-[1.5rem] overflow-hidden bg-slate-100 shrink-0">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary/10 to-secondary/20 flex items-center justify-center text-slate-200">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        @endif

                        <!-- Overlays -->
                        <div class="absolute inset-x-4 top-4 flex justify-between items-start">
                            <span class="px-4 py-2 bg-primary rounded-xl text-[10px] font-black text-white tracking-wider uppercase shadow-lg">
                                {{ $event->category ? $event->category->name : 'General' }}
                            </span>
                            <span class="px-4 py-2 bg-emerald-500 rounded-xl text-[10px] font-black text-white tracking-wider flex items-center gap-2 shadow-lg">
                                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                Live Now
                            </span>
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="mt-5 flex flex-col flex-1 px-1">
                        <h3 class="font-outfit text-xl font-black text-dark mb-5 leading-tight group-hover:text-primary transition-colors line-clamp-1">
                            {{ $event->title }}
                        </h3>

                        <div class="flex items-start gap-4 mb-5">
                            <!-- Date Card -->
                            <div class="shrink-0 w-14 h-18 bg-primary rounded-xl flex flex-col items-center justify-center text-white shadow-md shadow-primary/20 overflow-hidden">
                                <span class="text-xl font-black leading-none">{{ $event->date->format('d') }}</span>
                                <span class="text-[9px] font-bold uppercase tracking-wider text-white/80">{{ $event->date->format('M') }}</span>
                                <span class="text-[8px] font-medium text-white/60">{{ $event->date->format('Y') }}</span>
                            </div>

                            <!-- Info List -->
                            <div class="flex flex-col gap-2 pt-1 overflow-hidden flex-1">
                                <div class="flex items-start gap-2 text-slate-600 leading-tight">
                                    <i class="fas fa-map-marker-alt text-xs mt-0.5 text-red-500"></i>
                                    <span class="text-xs font-semibold line-clamp-1">{{ $event->location }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-500">
                                    <i class="fas fa-tag text-xs text-emerald-500"></i>
                                    <span class="text-xs font-semibold">Starts from <span class="text-dark font-black">৳ {{ number_format($event->price, 0) }}</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Spacer -->
                        <div class="flex-1 min-h-2"></div>

                        <span class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl bg-secondary text-white font-black text-[10px] tracking-[0.15em] uppercase transition-all group-hover:bg-primary group-hover:shadow-lg group-hover:shadow-primary/30 group-hover:-translate-y-1">
                            Book Your Seat <i class="fas fa-arrow-right text-[9px]"></i>
                        </span>
                    </div>
                </a>
                @empty
                <div class="col-span-full py-20 text-center">
                    <i class="fas fa-calendar-xmark text-5xl text-slate-200 mb-4"></i>
                    <p class="text-slate-400 font-bold uppercase tracking-widest">More experiences coming soon.</p>
                </div>
                @endforelse
            </div>

            <!-- View All Link -->
            <div class="flex justify-center">
                <a href="{{ route('events') }}" class="inline-flex items-center gap-3 bg-white px-8 py-4 rounded-2xl text-primary font-bold text-sm hover:bg-primary hover:text-white transition-all shadow-md border border-slate-100">
                    View All Events <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Past Signature Events Section -->
    @if($pastEvents->count() > 0)
    <section class="py-24 bg-[#E4EDF7] overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-12">
                <span class="text-primary font-black tracking-[0.3em] text-[10px] uppercase mb-3 block">LEGACY</span>
                <h2 class="font-outfit text-4xl font-black text-dark mb-2 tracking-tighter">
                    Past Signature Events
                </h2>
                <p class="text-slate-400 font-medium tracking-wide">
                    A legacy of flawlessly executed events, powered by Ticket Kinun
                </p>
            </div>

            <!-- Marquee Row -->
            <div class="relative" x-data="{ paused: false }">
                <div class="overflow-hidden">
                    <div class="flex gap-6" :class="paused ? 'animate-none' : 'animate-marquee'"
                         @mouseenter="paused = true" @mouseleave="paused = false"
                         style="width: max-content">
                        @php $marqueeItems = $pastEvents->concat($pastEvents); @endphp
                        @foreach($marqueeItems as $past)
                        <a href="{{ route('events.show', $past->slug) }}"
                           class="shrink-0 w-72 h-52 rounded-[2rem] overflow-hidden shadow-md group relative cursor-pointer block">
                            @if($past->image)
                                <img src="{{ asset('storage/' . $past->image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $past->title }}">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/40 flex items-center justify-center">
                                    <i class="fas fa-image text-4xl text-white/30"></i>
                                </div>
                            @endif
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-6">
                                <span class="text-[9px] font-black text-white/70 uppercase tracking-widest mb-1">{{ $past->category ? $past->category->name : 'Event' }}</span>
                                <h4 class="text-white font-black text-base leading-tight line-clamp-2">{{ $past->title }}</h4>
                                <span class="text-white/60 text-[10px] font-semibold mt-1">{{ $past->date->format('d M, Y') }}</span>
                            </div>
                            <!-- Always-visible date badge -->
                            <div class="absolute top-4 left-4 bg-black/40 backdrop-blur-md rounded-xl px-3 py-1.5">
                                <span class="text-white text-[10px] font-black uppercase tracking-wide">{{ $past->date->format('M Y') }}</span>
                            </div>
                            <!-- Category badge -->
                            <div class="absolute top-4 right-4 bg-primary/80 backdrop-blur-md rounded-xl px-3 py-1.5">
                                <span class="text-white text-[9px] font-black uppercase tracking-wide">{{ $past->category ? $past->category->name : 'Event' }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Grid view for mobile -->
            <div class="grid grid-cols-2 md:hidden gap-4 mt-8">
                @foreach($pastEvents->take(4) as $past)
                <a href="{{ route('events.show', $past->slug) }}" class="rounded-2xl overflow-hidden h-40 group relative block">
                    @if($past->image)
                        <img src="{{ asset('storage/' . $past->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $past->title }}">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/40 flex items-center justify-center">
                            <i class="fas fa-image text-3xl text-white/30"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex flex-col justify-end p-3">
                        <h4 class="text-white font-black text-xs line-clamp-2">{{ $past->title }}</h4>
                        <span class="text-white/60 text-[9px] font-semibold">{{ $past->date->format('d M, Y') }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

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
    const bookBtn = document.getElementById('overview-book-btn');

    let currentSlide = 0;
    const slideCount = {{ $featuredEvents->count() }};

    if (slideCount <= 0) return;

    const slideData = @json($slideData);
    const baseUrl = '{{ url("/events") }}';

    function updateSlider() {
        slider.style.transform = `translateX(-${currentSlide * 100}%)`;

        // Update Swipe Dots
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.remove('bg-white/40');
                dot.classList.add('bg-white');
            } else {
                dot.classList.remove('bg-white');
                dot.classList.add('bg-white/40');
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
                
                // Update Book Your Seat button URL
                if (bookBtn && slideData[currentSlide].slug) {
                    bookBtn.href = baseUrl + '/' + slideData[currentSlide].slug;
                }

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

    // Featured Events Carousel - Auto Slide
    const featuredCarousel = document.getElementById('featured-carousel');
    const featuredCards = document.querySelectorAll('.featured-card');
    const featuredDots = document.querySelectorAll('.featured-dot');
    
    if (featuredCarousel && featuredCards.length > 0) {
        let featuredIndex = 0;
        const totalCards = featuredCards.length;
        let autoSlideInterval;
        
        // Get cards per view based on screen size
        function getCardsPerView() {
            if (window.innerWidth >= 1024) return 3; // lg
            if (window.innerWidth >= 768) return 2;  // md
            return 1; // mobile
        }
        
        let cardsPerView = getCardsPerView();
        
        function getMaxIndex() {
            return Math.max(0, totalCards - getCardsPerView());
        }
        
        function updateFeaturedCarousel() {
            const cardWidth = featuredCards[0].offsetWidth;
            const gap = 24; // 1.5rem gap
            const offset = featuredIndex * (cardWidth + gap);
            featuredCarousel.style.transform = `translateX(-${offset}px)`;
            
            // Update dots for mobile
            featuredDots.forEach((dot, i) => {
                if (i === featuredIndex) {
                    dot.classList.remove('bg-slate-300');
                    dot.classList.add('bg-primary');
                } else {
                    dot.classList.remove('bg-primary');
                    dot.classList.add('bg-slate-300');
                }
            });
        }
        
        // Auto slide function
        function autoSlide() {
            const maxIndex = getMaxIndex();
            if (featuredIndex < maxIndex) {
                featuredIndex++;
            } else {
                featuredIndex = 0; // Loop back to start
            }
            updateFeaturedCarousel();
        }
        
        // Start auto sliding
        function startAutoSlide() {
            autoSlideInterval = setInterval(autoSlide, 3000); // Slide every 3 seconds
        }
        
        // Pause on hover
        featuredCarousel.addEventListener('mouseenter', () => {
            clearInterval(autoSlideInterval);
        });
        
        featuredCarousel.addEventListener('mouseleave', () => {
            startAutoSlide();
        });
        
        // Handle dot clicks on mobile
        featuredDots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                featuredIndex = Math.min(i, getMaxIndex());
                updateFeaturedCarousel();
                // Reset auto slide timer
                clearInterval(autoSlideInterval);
                startAutoSlide();
            });
        });
        
        // Handle resize
        window.addEventListener('resize', () => {
            cardsPerView = getCardsPerView();
            featuredIndex = Math.min(featuredIndex, getMaxIndex());
            updateFeaturedCarousel();
        });
        
        // Initialize
        updateFeaturedCarousel();
        startAutoSlide();
        
        // Touch/Swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;
        
        featuredCarousel.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            clearInterval(autoSlideInterval);
        }, { passive: true });
        
        featuredCarousel.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            const maxIndex = getMaxIndex();
            
            if (Math.abs(diff) > 50) {
                if (diff > 0 && featuredIndex < maxIndex) {
                    featuredIndex++;
                } else if (diff < 0 && featuredIndex > 0) {
                    featuredIndex--;
                }
                updateFeaturedCarousel();
            }
            startAutoSlide();
        }, { passive: true });
    }
});
</script>
@endsection
