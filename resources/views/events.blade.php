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
                    <span class="text-blue-500 font-black text-[10px] tracking-[0.3em] uppercase italic">{{ $hero->badge_text }}</span>
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
                    <button class="flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white font-bold text-xs whitespace-nowrap shadow-lg shadow-blue-600/30">
                        <i class="far fa-calendar-check mt-0.5"></i> Live Events <span class="ml-1 opacity-70">{{ $events->total() }}</span>
                    </button>
                    <button class="flex items-center gap-2 px-6 py-3 rounded-xl border border-slate-100 text-slate-400 font-bold text-xs whitespace-nowrap hover:bg-slate-50 transition-all uppercase tracking-widest">
                        <i class="far fa-calendar-alt mt-0.5"></i> Archived
                    </button>
                </div>

                <!-- Category Filters -->
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar w-full lg:w-auto pb-2 lg:pb-0 scroll-smooth">
                    <span class="text-[10px] font-black italic text-blue-600 uppercase tracking-widest mr-4 whitespace-nowrap flex items-center gap-2">
                        <i class="fas fa-sliders-h"></i> Filter:
                    </span>
                    
                    <button @click="activeCategory = 'all'"
                        :class="activeCategory === 'all' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-slate-400 hover:text-dark'"
                        class="px-4 py-2 text-[11px] font-black uppercase tracking-tighter transition-all whitespace-nowrap cursor-pointer">
                        All
                    </button>
                    
                    @foreach($categories as $category)
                        <button @click="activeCategory = '{{ $category->slug }}'"
                            :class="activeCategory === '{{ $category->slug }}' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-slate-400 hover:text-dark'"
                            class="px-4 py-2 text-[11px] font-black uppercase tracking-tighter transition-all whitespace-nowrap cursor-pointer">
                            {{ strtoupper($category->name) }} ({{ $category->events_count }})
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Events Grid -->
    <section class="py-16 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($events as $event)
                @php
                    $catSlug = $event->category ? $event->category->slug : 'none';
                    $escapedTitle = str_replace("'", "\\'", $event->title);
                    $escapedLocation = str_replace("'", "\\'", $event->location);
                @endphp
                <div class="event-card bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col hover:shadow-xl transition-all duration-500 group"
                     x-show="matchEvent('{{ $catSlug }}', '{{ $escapedTitle }}', '{{ $escapedLocation }}')"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
                    
                    <!-- Image Wrapper (Top) -->
                    <div class="h-56 relative overflow-hidden bg-slate-100">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-200">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        @endif
                        
                        <!-- Badges Overlay -->
                        <div class="absolute top-4 left-4">
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/95 backdrop-blur-md rounded-lg text-[10px] font-bold text-dark shadow-sm uppercase tracking-tight">
                                <i class="{{ $event->category->icon ?? 'fas fa-bookmark' }} text-blue-600"></i>
                                {{ $event->category ? $event->category->name : 'Uncategorized' }}
                            </span>
                        </div>

                        <div class="absolute bottom-4 right-4">
                            <div class="bg-blue-600 text-white px-4 py-1.5 rounded-lg font-black text-xs shadow-xl shadow-blue-600/20 italic">
                                ${{ number_format($event->price, 2) }}
                            </div>
                        </div>
                    </div>

                    <!-- Content Wrapper (Bottom) -->
                    <div class="p-6 flex flex-col flex-1">
                        <h3 class="font-outfit text-lg font-black text-dark mb-4 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                            {{ $event->title }}
                        </h3>
                        
                        <div class="space-y-3 mb-8 flex-1">
                            <div class="flex items-center gap-3 text-slate-400">
                                <i class="fas fa-map-marker-alt text-[10px] w-4 mt-0.5"></i>
                                <span class="text-[11px] font-medium leading-tight truncate">{{ $event->location }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-400">
                                <i class="far fa-calendar-alt text-[10px] w-4 mt-0.5"></i>
                                <span class="text-[11px] font-black text-dark tracking-tighter uppercase">{{ $event->date->format('M d, Y • h:i A') }}</span>
                            </div>
                        </div>

                        <a href="#" class="w-full flex items-center justify-center py-3.5 rounded-xl bg-slate-50 border border-slate-100 text-dark font-black text-[10px] tracking-[0.2em] uppercase italic transition-all hover:bg-blue-600 hover:text-white hover:border-blue-600 hover:shadow-lg hover:shadow-blue-600/20">
                            Book Experience
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
