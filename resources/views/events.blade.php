@extends('layouts.app')

@section('title', 'Events - Find Your Next Experience | Ticket Kinun')

@section('content')
<div x-data="{
    activeCategory: 'all',
    searchQuery: '',
    matchEvent(categorySlug, title, location) {
        const matchesCategory = this.activeCategory === 'all' || categorySlug === this.activeCategory;
        const searchLower = this.searchQuery.toLowerCase();
        const matchesSearch = this.searchQuery === '' ||
                             title.toLowerCase().includes(searchLower) ||
                             location.toLowerCase().includes(searchLower);
        return matchesCategory && matchesSearch;
    }
}">
    <!-- Hero Section -->
    <section class="relative pt-12 pb-24 bg-gradient-to-r from-[#520C6B] to-[#21032B] overflow-hidden min-h-[400px] flex items-center">
        <!-- Abstract Background Effects -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/10 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-accent/5 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/4"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            @if($hero && $hero->badge_text)
                <div class="inline-block px-6 py-2 rounded-full border border-white/10 bg-white/5 mb-8 animate-fadeInUp">
                    <span class="text-blue-500 font-black text-[10px] tracking-[0.3em] uppercase">{{ $hero->badge_text }}</span>
                </div>
            @endif

            <h1 class="font-outfit text-4xl md:text-7xl font-black text-white leading-tight mb-6 tracking-tighter max-w-4xl mx-auto">
                {{ $hero->title ?? 'Find Your Next Experience' }}
            </h1>

            @if($hero && $hero->subtitle)
                <p class="text-white/40 text-lg font-light mb-12 max-w-2xl mx-auto leading-relaxed">
                    {{ $hero->subtitle }}
                </p>
            @endif

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto relative group">
                <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400 group-focus-within:text-white transition-colors"></i>
                </div>
                <input type="text" x-model="searchQuery"
                    placeholder="{{ $hero->search_placeholder ?? 'Search events, venues, or cities...' }}"
                    class="w-full bg-white/10 border border-white/10 rounded-2xl py-6 pl-14 pr-8 text-white placeholder:text-slate-400 outline-none focus:bg-white/20 focus:border-white/30 transition-all text-lg font-light shadow-2xl">

                <!-- Floating Glow -->
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-0 group-focus-within:opacity-20 transition duration-500"></div>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="py-6 bg-white border-b border-slate-100 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                <!-- Status Tabs -->
                <div class="flex items-center gap-3 w-full lg:w-auto overflow-x-auto no-scrollbar pb-2 lg:pb-0">
                    <button class="flex items-center gap-2 px-6 py-3 rounded-xl bg-primary text-white font-bold text-xs whitespace-nowrap shadow-lg shadow-primary/30">
                        <i class="far fa-calendar-check mt-0.5"></i> Live Events <span class="ml-1 opacity-70">{{ $events->total() }}</span>
                    </button>
                    <button class="flex items-center gap-2 px-6 py-3 rounded-xl border border-slate-100 text-slate-400 font-bold text-xs whitespace-nowrap hover:bg-slate-50 transition-all uppercase tracking-widest">
                        <i class="far fa-calendar-alt mt-0.5"></i> Archived
                    </button>
                </div>

                <!-- Category Filters -->
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar w-full lg:w-auto pb-2 lg:pb-0 scroll-smooth">
                    <span class="text-[10px] font-black text-primary uppercase tracking-widest mr-4 whitespace-nowrap flex items-center gap-2">
                        <i class="fas fa-sliders-h"></i> Filter:
                    </span>

                    <button @click="activeCategory = 'all'"
                        :class="activeCategory === 'all' ? 'text-primary border-b-2 border-primary' : 'text-slate-400 hover:text-dark'"
                        class="px-4 py-2 text-[11px] font-black uppercase tracking-tighter transition-all whitespace-nowrap cursor-pointer">
                        All
                    </button>

                    @foreach($categories as $category)
                        <button @click="activeCategory = '{{ $category->slug }}'"
                            :class="activeCategory === '{{ $category->slug }}' ? 'text-primary border-b-2 border-primary' : 'text-slate-400 hover:text-dark'"
                            class="px-4 py-2 text-[11px] font-black uppercase tracking-tighter transition-all whitespace-nowrap cursor-pointer">
                            {{ strtoupper($category->name) }} ({{ $category->events_count }})
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- @if($featuredEvents->count() > 0)
    <!-- Featured Events Section -->
    <section class="py-16 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <span class="text-primary font-black tracking-[0.3em] text-[10px] uppercase mb-4 block">PREMIER SELECTION</span>
                    <h2 class="font-outfit text-4xl font-black text-dark tracking-tighter leading-tight">Featured <span class="text-primary">Experiences.</span></h2>
                </div>
                <div class="hidden md:flex gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-300">
                        <i class="fas fa-star text-xs"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredEvents as $fEvent)
                <div class="relative group h-[450px] rounded-[2.5rem] overflow-hidden shadow-2xl">
                    <img src="{{ asset('storage/' . $fEvent->image) }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-dark via-dark/20 to-transparent"></div>

                    <!-- Content -->
                    <div class="absolute inset-0 p-10 flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <span class="px-5 py-2 bg-accent rounded-full text-white font-black text-[9px] tracking-widest uppercase shadow-lg shadow-accent/20">FEATURED</span>
                            <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white border border-white/10">
                                <i class="{{ $fEvent->category->icon ?? 'fas fa-bookmark' }} text-sm"></i>
                            </div>
                        </div>

                        <div>
                            <p class="text-accent font-black text-[10px] tracking-widest uppercase mb-3">{{ $fEvent->category ? $fEvent->category->name : 'Special' }}</p>
                            <h3 class="font-outfit text-3xl font-black text-white mb-6 leading-tight tracking-tight group-hover:text-accent transition-colors">{{ $fEvent->title }}</h3>

                            <div class="flex items-center gap-6 mb-8">
                                <div class="flex flex-col">
                                    <span class="text-white/40 text-[9px] font-black uppercase tracking-widest mb-1">DATE</span>
                                    <span class="text-white text-xs font-bold">{{ $fEvent->date->format('M d, Y') }}</span>
                                </div>
                                <div class="w-px h-8 bg-white/10"></div>
                                <div class="flex flex-col">
                                    <span class="text-white/40 text-[9px] font-black uppercase tracking-widest mb-1">PRICE</span>
                                    <span class="text-accent text-xs font-black">${{ number_format($fEvent->price, 2) }}</span>
                                </div>
                            </div>

                            <a href="#" class="inline-flex items-center gap-3 bg-white text-dark px-8 py-4 rounded-xl font-black text-[10px] tracking-widest uppercase hover:bg-accent hover:text-white transition-all">
                                Reserve Spot <i class="fas fa-arrow-right text-[8px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif --}}

    <!-- Events Grid -->
    <section class="py-16 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto px-2">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($events as $event)
                @php
                    $catSlug = $event->category ? $event->category->slug : 'none';
                    $escapedTitle = str_replace("'", "\\'", $event->title);
                    $escapedLocation = str_replace("'", "\\'", $event->location);
                @endphp
                <div class="event-card group bg-white rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col h-full border border-slate-100 overflow-hidden"
                     style="border-color: #EDDDDD;"
                     x-show="matchEvent('{{ $catSlug }}', '{{ $escapedTitle }}', '{{ $escapedLocation }}')"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">

                    <!-- Image Section (Full Cover) -->
                    <div class="relative aspect-[16/9] bg-slate-100 shrink-0 overflow-hidden">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-200 bg-slate-50">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        @endif

                        <!-- Overlays -->
                        <div class="absolute inset-x-4 top-4 flex justify-between items-start">
                            <span class="px-3 py-1 bg-black/50 backdrop-blur-md rounded-lg text-[10px] font-bold text-white tracking-tight">
                                {{ $event->category ? $event->category->name : 'Uncategorized' }}
                            </span>
                            <span class="px-3 py-1 bg-black/60 backdrop-blur-md rounded-lg text-[10px] font-bold text-white tracking-tight flex items-center gap-2">
                                Live Now
                            </span>
                        </div>
                    </div>

                    <!-- Details Section (Padded & Enlarged) -->
                    <div class="flex flex-col flex-1 p-8 md:p-10">
                        <h3 class="font-outfit text-[22px] md:text-[24px] font-black text-dark mb-6 leading-tight line-clamp-2 group-hover:text-primary transition-colors">
                            {{ $event->title }}
                        </h3>

                        <div class="flex items-center gap-6 mb-10">
                            <!-- Professional Date Card -->
                            <div class="shrink-0 w-16 h-20 bg-[#1B2B46] to-accent rounded-2xl flex flex-col items-center justify-center text-white shadow-lg border-4 border-white/20">
                                <span class="text-[32px] font-extrabold leading-none mb-0.5 drop-shadow-sm">{{ $event->date->format('d') }}</span>
                                <span class="text-xs font-bold uppercase tracking-widest text-white/80 mb-0.5">{{ $event->date->format('M') }}</span>
                                <span class="text-[10px] font-semibold tracking-wider text-white/60">{{ $event->date->format('Y') }}</span>
                            </div>

                            <!-- Info List -->
                            <div class="flex flex-col gap-3">
                                <div class="flex items-center gap-2.5 text-slate-600">
                                    <i class="fas fa-map-marker-alt text-[12px] text-[#84CC16]"></i>
                                    <span class="text-[14px] font-bold truncate max-w-[220px]">{{ $event->location }}</span>
                                </div>
                                <div class="flex items-center gap-2.5 text-slate-600">
                                    <i class="fas fa-tag text-[12px] text-[#84CC16] rotate-90"></i>
                                    <span class="text-[14px] font-bold">Starts from <span class="text-dark font-black tracking-tighter">৳ {{ number_format($event->price, 0) }}</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Spacer -->
                        <div class="flex-1"></div>

                        <!-- Book Now Button -->
                        <a href="{{ route('events.show', $event->slug) }}" class="w-full flex items-center justify-center gap-3 py-5 rounded-[1.5rem] bg-primary text-white font-black text-xs tracking-[0.2em] uppercase transition-all hover:bg-dark hover:shadow-2xl hover:shadow-primary/20 group/btn">
                            Book Your Seat <i class="fas fa-arrow-right text-[10px] group-hover/btn:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-24 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-6 text-slate-200">
                        <i class="fas fa-calendar-times text-3xl"></i>
                    </div>
                    <h3 class="font-outfit text-2xl font-black text-dark mb-2">No Active Experiences</h3>
                    <p class="text-slate-400 font-medium max-w-xs mx-auto">We're currently preparing new events. Please check back shortly.</p>
                </div>
                @endforelse
            </div>

            <!-- Custom Pagination -->
            <div class="mt-20 flex justify-center">
                <div class="bg-white px-6 py-4 rounded-[2rem] shadow-premium border border-slate-50 flex items-center gap-2">
                    @if ($events->onFirstPage())
                        <span class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-300 cursor-not-allowed">
                            <i class="fas fa-chevron-left text-xs"></i>
                        </span>
                    @else
                        <a href="{{ $events->previousPageUrl() }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                            <i class="fas fa-chevron-left text-xs"></i>
                        </a>
                    @endif

                    <div class="flex items-center gap-1 px-4">
                        @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                            @if ($page == $events->currentPage())
                                <span class="w-12 h-12 flex items-center justify-center rounded-2xl bg-blue-600 text-white font-black text-xs shadow-lg shadow-blue-600/30">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="w-12 h-12 flex items-center justify-center rounded-2xl text-slate-400 font-bold text-xs hover:bg-blue-50 hover:text-blue-600 transition-all">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    @if ($events->hasMorePages())
                        <a href="{{ $events->nextPageUrl() }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    @else
                        <span class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-300 cursor-not-allowed">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
