@extends('layouts.app')

@section('title', 'Gallery - Relive the Magic | Ticket Kinun')

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-12 pb-24 bg-gradient-to-r from-[#520C6B] to-[#21032B] overflow-hidden min-h-[400px] flex items-center">
        <!-- Abstract Background Glows -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/10 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-accent/5 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/4"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-block px-4 py-1.5 rounded-full glass mb-6">
                <span class="text-accent font-black text-[10px] tracking-[0.2em] uppercase">{{ $hero->badge_text ?? 'VISUAL JOURNEY' }}</span>
            </div>
            
            <h1 class="font-outfit text-6xl md:text-8xl font-black text-white leading-tight mb-6 tracking-tighter italic">
                @php
                    $titleLines = explode('.', $hero->title ?? 'Moments In Motion');
                @endphp
                {{ $titleLines[0] }} @if(isset($titleLines[1])) <br><span class="text-accent not-italic tracking-normal">{{ $titleLines[1] }}.</span> @else . @endif
            </h1>
            <p class="text-slate-400 text-lg md:text-xl mb-12 max-w-2xl mx-auto font-light leading-relaxed">
                {{ $hero->subtitle ?? 'Step inside the most exclusive events. Explore our collection of captured memories, from high-energy concerts to elite sports finals.' }}
            </p>
        </div>
    </section>

    <!-- Gallery Categories -->
    <section class="py-8 bg-white border-b border-slate-100 sticky top-20 z-40">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-wrap justify-center gap-4">
                <button data-category="all" class="gallery-filter-btn active bg-dark text-white shadow-lg group relative px-8 py-3 rounded-2xl font-black text-xs tracking-widest transition-all">
                    <span class="relative z-10">ALL</span>
                </button>
                @foreach(\App\Models\EventCategory::all() as $cat)
                    <button data-category="{{ strtolower($cat->name) }}" class="gallery-filter-btn bg-slate-50 text-slate-400 hover:text-dark hover:bg-slate-100 group relative px-8 py-3 rounded-2xl font-black text-xs tracking-widest transition-all">
                        <span class="relative z-10">{{ strtoupper($cat->name) }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Modern Masonry Gallery -->
    <section class="py-24 bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-6">
            @php
                $dbImages = \App\Models\GalleryImage::with('category')->latest()->get();
            @endphp
            
            <div id="gallery-grid" class="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6">
                @forelse($dbImages as $img)
                    <div class="gallery-item break-inside-avoid relative group rounded-[2.5rem] overflow-hidden bg-white animate-fadeInUp shadow-premium hover:shadow-2xl transition-all duration-500" 
                         data-category="{{ strtolower($img->category->name) }}">
                        <img src="{{ str_starts_with($img->image_path, 'http') ? $img->image_path : asset('storage/' . $img->image_path) }}" alt="{{ $img->title }}" class="w-full object-cover transition-transform duration-[1.5s] group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-dark/95 via-dark/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-10 text-left text-white">
                            <span class="text-primary font-black text-[10px] tracking-[0.3em] mb-4 block uppercase">{{ $img->category->name }}</span>
                            <h3 class="font-black text-2xl tracking-tighter italic mb-6 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">{{ $img->title }}</h3>
                            <div class="flex items-center gap-4 translate-y-4 group-hover:translate-y-0 transition-transform duration-700 opacity-0 group-hover:opacity-100">
                                <button class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-dark hover:bg-primary hover:text-white transition-all">
                                    <i class="fas fa-expand-alt text-sm"></i>
                                </button>
                                <span class="text-[10px] font-bold text-white/40 uppercase tracking-widest italic tracking-tighter">Captured {{ $img->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-40 text-center flex flex-col items-center">
                        <div class="w-24 h-24 bg-white rounded-[2rem] shadow-premium flex items-center justify-center text-slate-200 text-4xl mb-8 italic">
                            <i class="fas fa-camera-retro"></i>
                        </div>
                        <h3 class="font-outfit text-3xl font-black text-dark tracking-tight italic">Exhibition Still in Prep</h3>
                        <p class="text-slate-400 text-lg font-light mt-4 max-w-md">Our curators are currently selecting the finest moments. Check back soon for the visual journey.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-40 bg-dark text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary/20 rounded-full blur-[150px] translate-x-1/2 -translate-y-1/2"></div>
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <h2 class="font-outfit text-5xl md:text-7xl font-black mb-10 tracking-tighter leading-[0.9] italic">Make Your Own <br><span class="text-primary not-italic">Memories.</span></h2>
            <p class="text-slate-400 text-xl font-light mb-16 max-w-xl mx-auto">Get your tickets today and be featured in our upcoming showcase of legends.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('events') }}" class="bg-primary text-white px-16 py-6 rounded-3xl font-black text-lg hover:bg-primary-dark transition-all hover:scale-105 active:scale-95 shadow-xl shadow-primary/30">EXPLORE EVENTS</a>
                <a href="#" class="glass text-white px-16 py-6 rounded-3xl font-black text-lg hover:border-white transition-all">FOLLOW US</a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.gallery-filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Update active state
            filterButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-dark', 'text-white', 'shadow-lg');
                btn.classList.add('bg-slate-50', 'text-slate-400');
            });
            button.classList.add('active', 'bg-dark', 'text-white', 'shadow-lg');
            button.classList.remove('bg-slate-50', 'text-slate-400');

            const category = button.getAttribute('data-category');

            galleryItems.forEach(item => {
                if (category === 'all' || item.getAttribute('data-category') === category) {
                    item.style.display = 'block';
                    // Re-trigger animation
                    item.classList.remove('animate-fadeInUp');
                    void item.offsetWidth; 
                    item.classList.add('animate-fadeInUp');
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection
