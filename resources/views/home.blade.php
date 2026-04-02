@extends('layouts.app')

@section('title', 'Ticket Kinun - Elevate Your Event Experience')

@section('content')
    <!-- Hero Section -->
    <section class="relative -mt-16 md:mt-0 pt-0 md:pt-6 lg:pt-8 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-0 md:px-6">
            <div class="relative flex flex-col lg:flex-row items-stretch gap-6 h-screen md:h-[600px] lg:h-[480px]">

                <!-- Main Slider / Banner -->
                <div class="absolute inset-0 md:relative md:flex-1 md:rounded-[2.5rem] overflow-hidden shadow-premium border-b md:border border-slate-50 z-0 group">
                    <div id="hero-slider" class="flex items-stretch h-full w-full transition-transform duration-700 ease-in-out bg-slate-900">
                        @forelse($featuredEvents as $event)
                        <div class="min-w-full h-full relative overflow-hidden flex items-center justify-center">
                            @if($event->image)
                                <img src="{{ $event->image_url }}"
                                     @if($loop->first) fetchpriority="high" @else loading="lazy" @endif
                                     class="absolute inset-0 w-full h-full object-cover md:group-hover:scale-105 transition-transform duration-[1.5s] ease-out-expo">
                            @else
                                <div class="absolute inset-0 w-full h-full bg-slate-100 flex items-center justify-center">
                                    <i class="fas fa-calendar-star text-7xl text-slate-300"></i>
                                </div>
                            @endif

                            <!-- Featured Tag -->
                            <div class="absolute top-24 md:top-6 left-6 z-10">
                                <span class="bg-primary/95 backdrop-blur-md text-white px-5 py-2.5 rounded-2xl text-[10px] font-black tracking-[0.2em] uppercase shadow-xl flex items-center gap-2 border border-white/20">
                                    <i class="fas fa-star text-[8px] animate-pulse"></i> FEATURED
                                </span>
                            </div>

                            <!-- Premium Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/80 pointer-events-none z-0"></div>
                        </div>
                        @empty
                        <div class="min-w-full h-full bg-slate-50 flex items-center justify-center">
                            <i class="fas fa-calendar-star text-5xl text-slate-200"></i>
                        </div>
                        @endforelse
                    </div>

                    <!-- Navigation Controls (Desktop) -->
                    @if($featuredEvents->count() > 1)
                    <button id="hero-prev" class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/90 backdrop-blur shadow-2xl rounded-full hidden md:flex items-center justify-center text-dark hover:bg-primary hover:text-white transition-all z-20 opacity-0 group-hover:opacity-100">
                        <i class="fas fa-chevron-left text-sm"></i>
                    </button>
                    <button id="hero-next" class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/90 backdrop-blur shadow-2xl rounded-full hidden md:flex items-center justify-center text-dark hover:bg-primary hover:text-white transition-all z-20 opacity-0 group-hover:opacity-100">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </button>
                    @endif
                </div>

                <!-- Right Side: Event Details Card (Floating on Mobile) -->
                <div class="absolute bottom-10 inset-x-4 md:static md:w-[380px] bg-[#EDF2F7] rounded-[2.5rem] p-8 md:p-10 flex flex-col justify-between overflow-hidden shadow-2xl md:shadow-premium border border-white/20 md:border-slate-100 animate-fadeInUp z-10" style="animation-delay: 0.2s">
                    <div class="relative z-10 h-full flex flex-col">
                        <span class="text-primary font-black text-[10px] tracking-[0.3em] uppercase mb-4 md:mb-6 block">Quick Overview</span>

                        @if($featuredEvents->count() > 0)
                        <div id="overview-card" class="flex-1 flex flex-col">
                            <h2 id="overview-title" class="font-outfit text-2xl md:text-3xl font-black text-dark leading-tight mb-6 md:mb-8 tracking-tight transition-all duration-500">
                                {{ $featuredEvents[0]->title }}
                            </h2>

                            <div class="space-y-4 md:space-y-5 mb-8 md:mb-10 text-left">
                                <div class="flex items-center gap-4 group/item">
                                    <div class="w-12 h-12 rounded-2xl bg-[#520C6B]/10 flex items-center justify-center group-hover/item:bg-primary/20 transition-all">
                                        <i class="fas fa-calendar-alt text-sm text-[#520C6B]"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Date</span>
                                        <span id="overview-date" class="text-sm font-bold text-dark tracking-wide">{{ strtoupper($featuredEvents[0]->date->format('d M, Y')) }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 group/item">
                                    <div class="w-12 h-12 rounded-2xl bg-[#2563EB]/10 flex items-center justify-center group-hover/item:bg-accent/20 transition-all">
                                        <i class="fas fa-map-marker-alt text-sm text-[#2563EB]"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Location</span>
                                        <span id="overview-location" class="text-sm font-bold text-dark tracking-wide">{{ strtoupper($featuredEvents[0]->location) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('events.show', $featuredEvents[0]->slug) }}" id="overview-book-btn" class="group/btn relative inline-flex items-center gap-3 bg-[#1B2B46] w-full py-5 rounded-[1.5rem] font-black text-xs tracking-[0.2em] uppercase hover:bg-primary transition-all overflow-hidden justify-center text-white mt-auto shadow-xl">
                            <span class="relative z-10 flex items-center gap-3">
                                Book Your Seat
                                <i class="fas fa-arrow-right text-[10px] group-hover/btn:translate-x-1 transition-transform"></i>
                            </span>
                        </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- Featured Events Carousel Section -->
    <section id="trending" class="py-12 mt-2 md:py-24 bg-[#E4EDF7] overflow-hidden">
        <!-- Header aligned with main container -->
        <div class="max-w-7xl mx-auto px-4 md:px-6 mb-8 md:mb-12">
            <div>
                <h2 class="font-outfit text-2xl md:text-4xl font-black text-dark mb-2 tracking-tighter">Featured <span class="text-primary">Events</span></h2>
                <p class="text-slate-400 text-sm md:text-base font-medium tracking-wide">The hottest tickets in town, updated every minute.</p>
            </div>
        </div>

        <!-- Carousel Container -->
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="overflow-hidden" style="max-width:100%;">
                <div id="featured-carousel" class="flex transition-transform duration-500 ease-out gap-6">
                    @forelse($featuredEvents as $index => $event)
                    <a href="{{ route('events.show', $event->slug) }}" class="featured-card shrink-0 w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] group bg-white rounded-[2rem] p-5 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col border border-slate-100">
                        <!-- Image Section -->
                        <div class="relative h-52 rounded-[1.5rem] overflow-hidden bg-slate-100 shrink-0">
                            @if($event->image)
                                <img loading="lazy" src="{{ $event->image_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
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
                                @if($event->is_sold_out)
                                <span class="px-4 py-2 bg-red-600 rounded-xl text-[10px] font-black text-white tracking-wider flex items-center gap-1.5 shadow-lg shadow-red-600/30 uppercase">
                                    <i class="fas fa-ban text-[8px]"></i> Sold Out
                                </span>
                                @else
                                <span class="px-4 py-2 bg-emerald-500 rounded-xl text-[10px] font-black text-white tracking-wider flex items-center gap-2 shadow-lg">
                                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                    Live Now
                                </span>
                                @endif
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

                            @if($event->is_sold_out)
                            <span class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl bg-slate-200 text-slate-500 font-black text-[10px] tracking-[0.15em] uppercase cursor-not-allowed">
                                <i class="fas fa-ban text-[9px]"></i> Sold Out
                            </span>
                            @else
                            <span class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl bg-secondary text-white font-black text-[10px] tracking-[0.15em] uppercase transition-all group-hover:bg-primary group-hover:shadow-lg group-hover:shadow-primary/30 group-hover:-translate-y-1">
                                Book Your Seat <i class="fas fa-arrow-right text-[9px]"></i>
                            </span>
                            @endif
                        </div>
                    </a>
                    @empty
                    <div class="w-full py-20 text-center bg-white rounded-[2rem] border border-slate-100 shadow-sm">
                        <i class="fas fa-calendar-xmark text-5xl text-slate-200 mb-4"></i>
                        <p class="text-slate-400 font-bold uppercase tracking-widest">No featured events at the moment.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Mobile Navigation Dots -->
            @if($featuredEvents->count() > 1)
            <div class="flex md:hidden justify-center gap-3 mt-10">
                @foreach($featuredEvents as $index => $event)
                <button class="featured-dot w-2.5 h-2.5 rounded-full {{ $index === 0 ? 'bg-primary ring-4 ring-primary/10' : 'bg-slate-300 transition-all hover:bg-slate-400' }}"></button>
                @endforeach
            </div>
            @endif

            <!-- View All Link -->
            <div class="flex justify-center mt-10">
                <a href="{{ route('events') }}" class="inline-flex items-center gap-3 bg-white px-8 py-4 rounded-2xl text-primary font-bold text-sm hover:bg-primary hover:text-white transition-all shadow-md border border-slate-100">
                    View All Events <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- All Events Section -->
    <section class="py-12 md:py-24 bg-[#F1F5F9] overflow-hidden" x-data="{ activeCategory: 'all' }">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <!-- Header with Filters -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 md:gap-6 mb-8 md:mb-12">
                <div>
                    <h2 class="font-outfit text-2xl md:text-4xl font-black text-dark mb-2 tracking-tighter">All <span class="text-primary">Events</span></h2>
                    <p class="text-slate-400 text-sm md:text-base font-medium tracking-wide">Explore our full library of experiences across every category.</p>
                </div>
                <div class="flex gap-3 overflow-x-auto pb-4 no-scrollbar w-full -mx-4 px-4 sm:mx-0 sm:px-0" style="-webkit-overflow-scrolling: touch;">
                    <button @click="activeCategory = 'all'"
                            :class="activeCategory === 'all' ? 'bg-dark text-white border-dark shadow-lg' : 'bg-white text-slate-500 border-slate-200 hover:border-dark hover:text-dark'"
                            class="px-6 py-2.5 rounded-full font-black text-[10px] tracking-widest transition-all border whitespace-nowrap">
                        ALL
                    </button>
                    @foreach($eventCategories as $category)
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
                            <img loading="lazy" src="{{ $event->image_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
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
                            @if($event->is_sold_out)
                            <span class="px-4 py-2 bg-red-600 rounded-xl text-[10px] font-black text-white tracking-wider flex items-center gap-1.5 shadow-lg shadow-red-600/30 uppercase">
                                <i class="fas fa-ban text-[8px]"></i> Sold Out
                            </span>
                            @else
                            <span class="px-4 py-2 bg-emerald-500 rounded-xl text-[10px] font-black text-white tracking-wider flex items-center gap-2 shadow-lg">
                                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                Live Now
                            </span>
                            @endif
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

                        @if($event->is_sold_out)
                        <span class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl bg-slate-200 text-slate-500 font-black text-[10px] tracking-[0.15em] uppercase cursor-not-allowed">
                            <i class="fas fa-ban text-[9px]"></i> Sold Out
                        </span>
                        @else
                        <span class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl bg-secondary text-white font-black text-[10px] tracking-[0.15em] uppercase transition-all group-hover:bg-primary group-hover:shadow-lg group-hover:shadow-primary/30 group-hover:-translate-y-1">
                            Book Your Seat <i class="fas fa-arrow-right text-[9px]"></i>
                        </span>
                        @endif
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
    <section class="py-12 md:py-24 bg-[#E4EDF7] overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="mb-8 md:mb-12 text-center">
                <h2 class="font-outfit text-2xl md:text-4xl font-black mb-2 tracking-tighter" style="color: #500C69;">
                    Past Signature Events
                </h2>
                <p class="text-slate-400 text-sm md:text-base font-medium tracking-wide">
                    A legacy of flawlessly executed events, powered by Ticket Kinun
                </p>
            </div>

            <!-- Marquee Row -->
            <div class="relative" x-data="{ paused: false }">
                <div class="overflow-hidden">
                    <div class="flex gap-6" :class="paused ? 'animate-none' : 'animate-marquee'"
                         @mouseenter="paused = true" @mouseleave="paused = false"
                         style="width: max-content">
                        @php $marqueeItems = $pastEvents; @endphp
                        @foreach($marqueeItems as $past)
                        <a href="{{ route('events.show', $past->slug) }}"
                           class="shrink-0 w-72 h-52 rounded-[2rem] overflow-hidden shadow-md group relative cursor-pointer block">
                            @if($past->image)
                                <img loading="lazy" src="{{ $past->image_url }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $past->title }}">
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
                        <img loading="lazy" src="{{ $past->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $past->title }}">
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
    {{-- <section class="py-24 bg-[#F1F5F9]">
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
    </section> --}}

    <!-- Features Section -->
    <section class="py-24 bg-[#E4EDF7]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-14 text-left">
                <h2 class="font-outfit text-4xl font-black text-[#500C69] tracking-tighter mb-2">Everything Optimized For Your Experience</h2>
                <p class="text-slate-400 font-medium">Powerful tools and support, designed around you.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($platformFeatures as $feature)
                <div class="rounded-3xl p-8 flex flex-col gap-6 border hover:shadow-lg transition-all duration-300"
                     style="background-color: {{ $feature->card_bg }}; border-color: {{ $feature->border_color }};">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-md"
                         style="background-color: {{ $feature->icon_bg }};">
                        <i class="{{ $feature->icon }} text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-dark text-xl mb-2">{{ $feature->title }}</h3>
                        <p class="text-slate-500 text-sm font-medium leading-relaxed">{{ $feature->description }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12 text-slate-400 font-semibold">No features configured yet.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Enhanced Gallery Section -->
    @php
        $galleryList = $homepageGalleryImages ?? collect();
        $gSection   = $gallerySection ?? null;
        $gTitle     = $gSection->title       ?? 'Moments That Stick Forever';
        $gDesc      = $gSection->description ?? 'Browse through thousands of captured memories from our global community of event lovers.';
        $gBtnText   = $gSection->button_text ?? 'OPEN GALLERY';
        $gBtnUrl    = $gSection->button_url  ?? '/gallery';

        // Build image list for lightbox
        $lightboxImages = $galleryList->count() ? $galleryList->map(fn($img) => [
            'src'     => $img->image_url,
            'caption' => $img->title ?? '',
        ])->values()->toArray() : [
            ['src' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=1400&q=90', 'caption' => 'Neon World Tour Final'],
            ['src' => 'https://images.unsplash.com/photo-1467810563316-b5476525c0f9?auto=format&fit=crop&w=900&q=90',  'caption' => 'Light Trails'],
            ['src' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&w=900&q=90',  'caption' => 'Festival Energy'],
            ['src' => 'https://images.unsplash.com/photo-1472653425572-ca97664ff3AD?auto=format&fit=crop&w=1400&q=90','caption' => 'Experience The Unseen'],
        ];
    @endphp

    <section class="py-32 bg-[#F1F5F9]"
             x-data="{
                 lightbox: false,
                 current: 0,
                 images: {{ json_encode($lightboxImages) }},
                 open(index) { this.current = index; this.lightbox = true; document.body.style.overflow = 'hidden'; },
                 close() { this.lightbox = false; document.body.style.overflow = ''; },
                 prev() { this.current = (this.current - 1 + this.images.length) % this.images.length; },
                 next() { this.current = (this.current + 1) % this.images.length; },
             }"
             @keydown.escape.window="close()"
             @keydown.arrow-left.window="lightbox && prev()"
             @keydown.arrow-right.window="lightbox && next()">

        <div class="max-w-7xl mx-auto px-6">
             <div class="flex flex-col md:flex-row items-end justify-between mb-20">
                <div class="max-w-xl">
                    <h2 class="font-outfit text-5xl font-black text-primary mb-6 tracking-tighter leading-none">{{ $gTitle }}</h2>
                    <p class="text-slate-400 text-lg font-light leading-relaxed">{{ $gDesc }}</p>
                </div>
                <div class="mt-8 md:mt-0">
                    <a href="{{ $gBtnUrl }}" class="px-12 py-5 bg-dark text-white rounded-2xl font-black text-sm hover:bg-primary transition-all shadow-xl shadow-dark/10">{{ $gBtnText }}</a>
                </div>
             </div>

             @if($galleryList->count())
             <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 auto-rows-[340px]">
                @foreach($galleryList as $index => $gImg)
                @php
                    // Optimization for exactly 5 images:
                    // Index 0: 2x2 span
                    // Indices 1-4: 1x1 span
                    if($index === 0) {
                        $gridClass = 'col-span-2 row-span-2 h-full rounded-[3.5rem]';
                    } else {
                        $gridClass = 'col-span-1 row-span-1 h-full rounded-[2.5rem]';
                    }
                @endphp
                <div class="{{ $gridClass }} overflow-hidden group relative cursor-zoom-in shadow-sm hover:shadow-xl transition-all duration-500"
                     @click="open({{ $index }})">
                    <img src="{{ $gImg->image_url }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" loading="lazy" alt="{{ $gImg->title ?? '' }}">
                    <!-- Hover overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-dark/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end justify-between p-8">
                        @if($gImg->title)
                        <h4 class="text-white font-black text-xl leading-tight translate-y-4 group-hover:translate-y-0 transition-transform duration-500 line-clamp-2 max-w-[80%]">{{ $gImg->title }}</h4>
                        @endif
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center translate-y-4 group-hover:translate-y-0 transition-transform duration-500 shrink-0 ml-auto border border-white/20">
                            <i class="fas fa-expand text-white text-sm"></i>
                        </div>
                    </div>
                </div>
                @endforeach
             </div>
             @else
             {{-- fallback static gallery optimized for 5 images --}}
             <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 auto-rows-[340px]">
                @php $fallbacks = [
                    ['src'=>'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=1000&q=80','caption'=>'Neon World Tour Final','cls'=>'col-span-2 row-span-2 rounded-[3.5rem]'],
                    ['src'=>'https://images.unsplash.com/photo-1467810563316-b5476525c0f9?auto=format&fit=crop&w=600&q=80','caption'=>'Light Trails','cls'=>'col-span-1 rounded-[2.5rem]'],
                    ['src'=>'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&w=600&q=80','caption'=>'Festival Energy','cls'=>'col-span-1 rounded-[2.5rem]'],
                    ['src'=>'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=600&q=80','caption'=>'Mainstage Crowd','cls'=>'col-span-1 rounded-[2.5rem]'],
                    ['src'=>'https://images.unsplash.com/photo-1472653425572-ca97664ff3AD?auto=format&fit=crop&w=1200&q=80','caption'=>'Experience The Unseen','cls'=>'col-span-1 rounded-[2.5rem]'],
                ]; @endphp
                @foreach($fallbacks as $fi => $fb)
                <div class="{{ $fb['cls'] }} overflow-hidden group relative cursor-zoom-in shadow-sm hover:shadow-xl transition-all duration-500" @click="open({{ $fi }})">
                    <img src="{{ $fb['src'] }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" alt="{{ $fb['caption'] }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-dark/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end justify-between p-8">
                        <h4 class="text-white font-black text-xl leading-tight translate-y-4 group-hover:translate-y-0 transition-transform duration-500">{{ $fb['caption'] }}</h4>
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shrink-0 ml-2 border border-white/20">
                            <i class="fas fa-expand text-white text-sm"></i>
                        </div>
                    </div>
                </div>
                @endforeach
             </div>
             @endif
        </div>

        <!-- ===== LIGHTBOX ===== -->
        <div x-show="lightbox" x-cloak
             class="fixed inset-0 z-[9999] flex items-center justify-center"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-end="opacity-0">

            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/95 backdrop-blur-lg" @click="close()"></div>

            <!-- Close button -->
            <button @click="close()"
                    class="absolute top-5 right-5 z-10 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-2xl flex items-center justify-center text-white transition-all hover:scale-110">
                <i class="fas fa-times text-lg"></i>
            </button>

            <!-- Counter -->
            <div class="absolute top-5 left-1/2 -translate-x-1/2 z-10 bg-white/10 text-white text-xs font-black tracking-widest px-4 py-2 rounded-full">
                <span x-text="current + 1"></span> / <span x-text="images.length"></span>
            </div>

            <!-- Prev arrow -->
            <button @click.stop="prev()"
                    class="absolute left-4 md:left-8 z-10 w-12 h-12 md:w-14 md:h-14 bg-white/10 hover:bg-primary rounded-2xl flex items-center justify-center text-white transition-all hover:scale-110 group">
                <i class="fas fa-chevron-left text-lg"></i>
            </button>

            <!-- Image container -->
            <div class="relative z-10 w-full max-w-5xl mx-4 md:mx-20 flex flex-col items-center gap-4">
                <template x-for="(img, idx) in images" :key="idx">
                    <div x-show="current === idx"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="w-full flex flex-col items-center gap-4">
                        <img :src="img.src" :alt="img.caption"
                             class="max-h-[75vh] w-full object-contain rounded-3xl shadow-2xl shadow-black/50 select-none">
                        <p x-show="img.caption" x-text="img.caption"
                           class="text-white/80 font-black text-sm tracking-widest text-center px-4"></p>
                    </div>
                </template>
            </div>

            <!-- Next arrow -->
            <button @click.stop="next()"
                    class="absolute right-4 md:right-8 z-10 w-12 h-12 md:w-14 md:h-14 bg-white/10 hover:bg-primary rounded-2xl flex items-center justify-center text-white transition-all hover:scale-110">
                <i class="fas fa-chevron-right text-lg"></i>
            </button>

            <!-- Thumbnail strip -->
            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-10 flex items-center gap-2 px-4 max-w-full overflow-x-auto no-scrollbar">
                <template x-for="(img, idx) in images" :key="idx">
                    <button @click.stop="current = idx"
                            class="shrink-0 w-14 h-10 md:w-16 md:h-11 rounded-xl overflow-hidden transition-all duration-300 border-2"
                            :class="current === idx ? 'border-primary scale-110 shadow-lg shadow-primary/30' : 'border-transparent opacity-50 hover:opacity-80'">
                        <img :src="img.src" :alt="img.caption" class="w-full h-full object-cover">
                    </button>
                </template>
            </div>
        </div>
    </section>

    <!-- Cinematic Final CTA -->
    <section class="py-40 relative bg-[#4F0B67] overflow-hidden">
        <!-- Background Animation -->
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1540575861501-7ad05823123d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80')] bg-cover bg-fixed bg-center opacity-20"></div>

        <div class="max-w-5xl mx-auto px-6 text-center relative z-10 animate-fadeInUp">
            <h2 class="font-outfit text-6xl md:text-8xl font-black text-[#FFE700] leading-[0.8] mb-12 tracking-tighter">Your Journey</h2>
            <p class="text-xl text-white mb-16 max-w-2xl mx-auto font-light">Join over 2.5 million event enthusiasts discovering the most exclusive experiences every day.</p>

            <div class="flex flex-col sm:flex-row justify-center gap-6">

                <a href="{{ route('organizer.register') }}" class="px-16 py-6 rounded-3xl font-black text-2xl transition-all hover:scale-105 hover:shadow-2xl" style="background-color: #FFE700; color: #1B2B46;">Join as a Organizer</a>
            </div>
        </div>

        <!-- Floating Decorative Elements -->
        <div class="absolute top-20 right-[10%] w-40 h-40 border-2 border-white/5 rounded-full animate-pulse"></div>
        <div class="absolute bottom-20 left-[10%] w-24 h-24 bg-primary/10 rounded-full blur-2xl"></div>
    </section>

    <!-- Page Specific Scripts (Injected here for Swup Compatibility) -->
    <script>
        if (typeof heroAutoSlideInterval === 'undefined') {
            window.heroAutoSlideInterval = null;
            window.featuredAutoSlideInterval = null;
        }

        function initHomePage() {
            const slider = document.getElementById('hero-slider');
            if (!slider) return;

            // Clear existing intervals if any (to prevent multiple intervals running)
            if (window.heroAutoSlideInterval) clearInterval(window.heroAutoSlideInterval);
            if (window.featuredAutoSlideInterval) clearInterval(window.featuredAutoSlideInterval);

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
                if (!slider) return;
                slider.style.transform = `translateX(-${currentSlide * 100}%)`;

                // Update Swipe Dots
                const dotInners = document.querySelectorAll('.hero-dot-inner');
                dotInners.forEach((dot, index) => {
                    const isActive = index === currentSlide;
                    dot.classList.toggle('bg-white/40', !isActive);
                    dot.classList.toggle('w-4', !isActive);
                    dot.classList.toggle('bg-white', isActive);
                    dot.classList.toggle('w-8', isActive);
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

            // Initialize Slider State Immediately
            updateSlider();

            // Add click listeners to hero dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    currentSlide = index;
                    updateSlider();
                });
            });

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
                window.heroAutoSlideInterval = setInterval(() => {
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

                // Get cards per view based on screen size
                function getCardsPerView() {
                    if (window.innerWidth >= 1024) return 3; // lg
                    if (window.innerWidth >= 768) return 2;  // md
                    return 1; // mobile
                }

                function getMaxIndex() {
                    return Math.max(0, totalCards - getCardsPerView());
                }

                function updateFeaturedCarousel() {
                    if (!featuredCards[0]) return;
                    const cardWidth = featuredCards[0].offsetWidth;
                    const gap = 24; // 1.5rem gap
                    const offset = featuredIndex * (cardWidth + gap);
                    featuredCarousel.style.transform = `translateX(-${offset}px)`;

                    // Update dots for mobile
                    featuredDots.forEach((dot, i) => {
                        const isActive = i === featuredIndex;
                        dot.classList.toggle('bg-slate-300', !isActive);
                        dot.classList.toggle('w-2.5', !isActive);
                        dot.classList.toggle('bg-primary', isActive);
                        dot.classList.toggle('w-6', isActive);
                        dot.classList.toggle('ring-4', isActive);
                        dot.classList.toggle('ring-primary/10', isActive);
                    });
                }

                // Auto slide function
                function featuredAutoSlide() {
                    const maxIndex = getMaxIndex();
                    if (featuredIndex < maxIndex) {
                        featuredIndex++;
                    } else {
                        featuredIndex = 0; // Loop back to start
                    }
                    updateFeaturedCarousel();
                }

                // Start auto sliding
                function startFeaturedAutoSlide() {
                    if (window.featuredAutoSlideInterval) clearInterval(window.featuredAutoSlideInterval);
                    if (totalCards > getCardsPerView()) {
                        window.featuredAutoSlideInterval = setInterval(featuredAutoSlide, 4000);
                    }
                }

                // Pause on hover
                featuredCarousel.addEventListener('mouseenter', () => {
                    if (window.featuredAutoSlideInterval) clearInterval(window.featuredAutoSlideInterval);
                });

                featuredCarousel.addEventListener('mouseleave', startFeaturedAutoSlide);

                // Handle dot clicks on mobile
                featuredDots.forEach((dot, i) => {
                    dot.addEventListener('click', () => {
                        featuredIndex = Math.min(i, getMaxIndex());
                        updateFeaturedCarousel();
                        startFeaturedAutoSlide();
                    });
                });

                // Handle resize
                window.addEventListener('resize', () => {
                    featuredIndex = Math.min(featuredIndex, getMaxIndex());
                    updateFeaturedCarousel();
                });

                // Initialize after a small delay to ensure layout is ready
                setTimeout(() => {
                    updateFeaturedCarousel();
                    startFeaturedAutoSlide();
                }, 800);

                // Touch/Swipe support for mobile
                let touchStartX = 0;
                let touchEndX = 0;

                featuredCarousel.addEventListener('touchstart', (e) => {
                    touchStartX = e.changedTouches[0].screenX;
                    if (window.featuredAutoSlideInterval) clearInterval(window.featuredAutoSlideInterval);
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
                    startFeaturedAutoSlide();
                }, { passive: true });
            }
        }

        // Run immediately as it's part of the Swup replacement fragment
        initHomePage();

        // Additional hooks for safety
        document.addEventListener('swup:animationInDone', initHomePage);
    </script>
@endsection
