@extends('layouts.app')

@section('title', 'Gallery - Relive the Magic | Ticket Kinun')

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-12 pb-24 bg-gradient-to-r from-[#520C6B] to-[#21032B] overflow-hidden min-h-[400px] flex items-center">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/10 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-accent/5 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/4"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10 text-center">
            <div class="inline-block px-4 py-1.5 rounded-full glass mb-6">
                <span class="text-accent font-black text-[10px] tracking-[0.2em] uppercase">{{ $hero->badge_text ?? 'VISUAL JOURNEY' }}</span>
            </div>
            <h1 class="font-outfit text-4xl sm:text-6xl md:text-8xl font-black text-white leading-tight mb-6 tracking-tighter">
                @php $titleLines = explode('.', $hero->title ?? 'Moments In Motion'); @endphp
                {{ $titleLines[0] }} @if(isset($titleLines[1])) <br><span class="text-accent tracking-normal">{{ $titleLines[1] }}.</span> @else . @endif
            </h1>
            <p class="text-slate-400 text-base sm:text-lg md:text-xl mb-12 max-w-2xl mx-auto font-light leading-relaxed px-4">
                {{ $hero->subtitle ?? 'Step inside the most exclusive events. Explore our collection of captured memories, from high-energy concerts to elite sports finals.' }}
            </p>
        </div>
    </section>

    <!-- Gallery Categories -->
    <section class="py-5 bg-white border-b border-slate-100 sticky top-20 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-wrap justify-center gap-2 sm:gap-4">
                <button data-category="all" class="gallery-filter-btn active bg-[#21032B] text-white shadow-lg px-5 sm:px-8 py-2.5 sm:py-3 rounded-2xl font-black text-[10px] sm:text-xs tracking-widest transition-all">
                    ALL
                </button>
                @foreach(\App\Models\EventCategory::all() as $cat)
                    <button data-category="{{ strtolower($cat->name) }}" class="gallery-filter-btn bg-slate-50 text-slate-400 hover:text-[#21032B] hover:bg-purple-50 px-5 sm:px-8 py-2.5 sm:py-3 rounded-2xl font-black text-[10px] sm:text-xs tracking-widest transition-all">
                        {{ strtoupper($cat->name) }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Grid -->
    <section class="py-12 sm:py-20 bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">

            <div id="gallery-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-5">
                @forelse($dbImages as $img)
                    @php
                        $accentColors = ['#520C6B', '#16a34a', '#f59e0b', '#3b82f6', '#ef4444', '#8b5cf6'];
                        $tagColors    = ['#f59e0b', '#16a34a', '#3b82f6', '#520C6B', '#a855f7', '#f97316'];
                        $colorIdx     = $loop->index % count($accentColors);
                        $imgSrc       = str_starts_with($img->image_path, 'http') ? $img->image_path : asset('storage/' . $img->image_path);
                    @endphp
                    <div class="gallery-item group cursor-pointer rounded-[0.75rem] overflow-hidden bg-white shadow-[0_2px_12px_rgba(0,0,0,0.07)] hover:shadow-[0_8px_28px_rgba(82,12,107,0.15)] transition-all duration-300 flex flex-col"
                         data-category="{{ strtolower($img->category->name) }}"
                         data-src="{{ $imgSrc }}"
                         data-title="{{ $img->title }}"
                         data-category-label="{{ $img->category->name }}"
                         data-date="{{ $img->created_at->format('d M, Y') }}"
                         data-color="{{ $accentColors[$colorIdx] }}"
                         onclick="openGalleryModal(this)">

                        <!-- Image -->
                        <div class="relative overflow-hidden">
                            <img src="{{ $imgSrc }}"
                                 alt="{{ $img->title }}"
                                 class="w-full object-cover aspect-[4/3] transition-transform duration-500 group-hover:scale-105">

                            <!-- Category badge top-right -->
                            <div class="absolute top-2 right-2 z-10">
                                <span class="text-white font-bold text-[9px] sm:text-[10px] px-2 py-0.5 rounded-md shadow tracking-wide uppercase"
                                      style="background:{{ $tagColors[$colorIdx] }}">
                                    {{ $img->category->name }}
                                </span>
                            </div>

                            <!-- Hover overlay -->
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 z-10"
                                 style="background:rgba(82,12,107,0.45)">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-full flex items-center justify-center shadow-lg scale-75 group-hover:scale-100 transition-transform duration-300">
                                    <i class="fas fa-expand-alt text-sm" style="color:{{ $accentColors[$colorIdx] }}"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Card footer -->
                        <div class="px-3 py-2.5 flex-1 flex flex-col justify-between" style="border-top: 2.5px solid {{ $accentColors[$colorIdx] }}">
                            <h3 class="font-bold text-[#111827] text-[11px] sm:text-[13px] leading-snug line-clamp-2 mb-1">{{ $img->title }}</h3>
                            <div class="flex items-center gap-1">
                                <i class="fas fa-calendar-alt text-[9px] sm:text-[10px]" style="color:{{ $accentColors[$colorIdx] }}"></i>
                                <span class="text-[9px] sm:text-[10px] text-gray-400 font-semibold">{{ $img->created_at->format('d M, Y') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-32 text-center flex flex-col items-center">
                        <div class="w-24 h-24 bg-white rounded-[2rem] shadow-lg flex items-center justify-center text-slate-200 text-4xl mb-8">
                            <i class="fas fa-camera-retro"></i>
                        </div>
                        <h3 class="font-outfit text-2xl sm:text-3xl font-black text-[#21032B] tracking-tight">Exhibition Still in Prep</h3>
                        <p class="text-slate-400 text-base font-light mt-4 max-w-md px-4">Our curators are currently selecting the finest moments. Check back soon.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($dbImages->hasPages())
            <div class="mt-12 flex items-center justify-center gap-1.5 sm:gap-2 flex-wrap" id="gallery-pagination">

                {{-- Previous --}}
                @if($dbImages->onFirstPage())
                    <span class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-300 cursor-not-allowed text-sm">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </span>
                @else
                    <a href="{{ $dbImages->previousPageUrl() }}" class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:bg-[#520C6B] hover:text-white hover:border-[#520C6B] transition-all shadow-sm">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </a>
                @endif

                {{-- Page numbers --}}
                @foreach($dbImages->getUrlRange(1, $dbImages->lastPage()) as $page => $url)
                    @if($page == $dbImages->currentPage())
                        <span class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-[#520C6B] text-white font-bold text-sm shadow-md">
                            {{ $page }}
                        </span>
                    @elseif(abs($page - $dbImages->currentPage()) <= 2 || $page == 1 || $page == $dbImages->lastPage())
                        <a href="{{ $url }}" class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-[#520C6B] hover:text-white hover:border-[#520C6B] transition-all shadow-sm font-semibold text-sm">
                            {{ $page }}
                        </a>
                    @elseif(abs($page - $dbImages->currentPage()) == 3)
                        <span class="w-9 h-9 flex items-center justify-center text-gray-400 font-bold text-sm">…</span>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($dbImages->hasMorePages())
                    <a href="{{ $dbImages->nextPageUrl() }}" class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:bg-[#520C6B] hover:text-white hover:border-[#520C6B] transition-all shadow-sm">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </a>
                @else
                    <span class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-300 cursor-not-allowed text-sm">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </span>
                @endif
            </div>
            <p class="text-center text-[11px] text-gray-400 font-semibold mt-4 tracking-wide">
                Showing {{ $dbImages->firstItem() }}–{{ $dbImages->lastItem() }} of {{ $dbImages->total() }} images
            </p>
            @endif

        </div>
    </section>

    <!-- ===== LIGHTBOX MODAL ===== -->
    <div id="galleryModal"
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6"
         style="display:none!important; background:rgba(10,0,18,0.92); backdrop-filter:blur(10px);"
         onclick="closeGalleryModal(event)">

        <!-- Modal box -->
        <div id="galleryModalBox"
             class="relative w-full max-w-4xl rounded-2xl overflow-hidden shadow-2xl flex flex-col"
             style="max-height:90vh;"
             onclick="event.stopPropagation()">

            <!-- Close button -->
            <button onclick="closeGalleryModalBtn()"
                    class="absolute top-3 right-3 z-20 w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full text-white transition-all duration-200"
                    style="background:rgba(255,255,255,0.15); backdrop-filter:blur(6px);">
                <i class="fas fa-times text-sm"></i>
            </button>

            <!-- Nav: Prev -->
            <button id="modalPrev"
                    onclick="navigateModal(-1)"
                    class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full text-white transition-all duration-200"
                    style="background:rgba(255,255,255,0.15); backdrop-filter:blur(6px);">
                <i class="fas fa-chevron-left text-sm"></i>
            </button>

            <!-- Nav: Next -->
            <button id="modalNext"
                    onclick="navigateModal(1)"
                    class="absolute right-12 sm:right-14 top-1/2 -translate-y-1/2 z-20 w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full text-white transition-all duration-200"
                    style="background:rgba(255,255,255,0.15); backdrop-filter:blur(6px);">
                <i class="fas fa-chevron-right text-sm"></i>
            </button>

            <!-- Image -->
            <div class="relative bg-black flex items-center justify-center overflow-hidden" style="max-height:65vh;">
                <img id="modalImage" src="" alt=""
                     class="w-full object-contain transition-opacity duration-300"
                     style="max-height:65vh;">
            </div>

            <!-- Footer info -->
            <div class="px-5 sm:px-8 py-4 sm:py-5 flex items-center justify-between gap-4 flex-wrap"
                 style="background:linear-gradient(135deg,#520C6B,#21032B);">
                <div>
                    <span id="modalCategory"
                          class="text-[10px] font-black tracking-widest uppercase px-2.5 py-1 rounded-full mb-2 inline-block"
                          style="background:rgba(255,255,255,0.15); color:#fff;"></span>
                    <h3 id="modalTitle" class="font-black text-white text-base sm:text-xl tracking-tight leading-snug mt-1"></h3>
                    <p id="modalDate" class="text-purple-200 text-[11px] font-semibold mt-1 flex items-center gap-1.5">
                        <i class="fas fa-calendar-alt"></i> <span></span>
                    </p>
                </div>
                <div class="text-right">
                    <span id="modalCounter" class="text-purple-300 text-xs font-bold tracking-widest"></span>
                </div>
            </div>
        </div>
    </div>
    <!-- ===== END LIGHTBOX MODAL ===== -->

    <!-- CTA Section -->
    <section class="py-24 sm:py-40 bg-[#21032B] text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary/20 rounded-full blur-[150px] translate-x-1/2 -translate-y-1/2"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10">
            <h2 class="font-outfit text-4xl sm:text-5xl md:text-7xl font-black mb-8 sm:mb-10 tracking-tighter leading-[0.9]">Make Your Own <br><span class="text-accent">Memories.</span></h2>
            <p class="text-slate-400 text-base sm:text-xl font-light mb-10 sm:mb-16 max-w-xl mx-auto px-4">Get your tickets today and be featured in our upcoming showcase of legends.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6 px-6">
                <a href="{{ route('events') }}" class="bg-primary text-white px-10 sm:px-16 py-4 sm:py-6 rounded-3xl font-black text-base sm:text-lg hover:opacity-90 transition-all hover:scale-105 active:scale-95 shadow-xl shadow-primary/30">EXPLORE EVENTS</a>
                <a href="#" class="glass text-white px-10 sm:px-16 py-4 sm:py-6 rounded-3xl font-black text-base sm:text-lg hover:border-white transition-all">FOLLOW US</a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Filter buttons ── */
    const filterBtns  = document.querySelectorAll('.gallery-filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => {
                b.classList.remove('bg-[#21032B]', 'text-white', 'shadow-lg');
                b.classList.add('bg-slate-50', 'text-slate-400');
            });
            btn.classList.add('bg-[#21032B]', 'text-white', 'shadow-lg');
            btn.classList.remove('bg-slate-50', 'text-slate-400');

            const cat = btn.getAttribute('data-category');
            galleryItems.forEach(item => {
                const show = cat === 'all' || item.getAttribute('data-category') === cat;
                item.style.display = show ? 'flex' : 'none';
            });
        });
    });

    /* ── Keyboard navigation ── */
    document.addEventListener('keydown', e => {
        const modal = document.getElementById('galleryModal');
        if (modal.style.display === 'none' || modal.style.display === '') return;
        if (e.key === 'Escape')      closeGalleryModalBtn();
        if (e.key === 'ArrowLeft')   navigateModal(-1);
        if (e.key === 'ArrowRight')  navigateModal(1);
    });
});

/* ── Collect visible items for navigation ── */
let currentModalIndex = 0;

function getVisibleItems() {
    return Array.from(document.querySelectorAll('.gallery-item'))
                .filter(el => el.style.display !== 'none');
}

function openGalleryModal(card) {
    const visibleItems = getVisibleItems();
    currentModalIndex  = visibleItems.indexOf(card);
    showModalItem(currentModalIndex, visibleItems);

    const modal = document.getElementById('galleryModal');
    modal.style.removeProperty('display');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function showModalItem(idx, items) {
    items = items || getVisibleItems();
    if (!items[idx]) return;

    const card    = items[idx];
    const src     = card.getAttribute('data-src');
    const title   = card.getAttribute('data-title');
    const cat     = card.getAttribute('data-category-label');
    const date    = card.getAttribute('data-date');

    const img     = document.getElementById('modalImage');
    img.style.opacity = '0';
    img.src = src;
    img.onload = () => { img.style.opacity = '1'; };

    document.getElementById('modalTitle').textContent    = title;
    document.getElementById('modalCategory').textContent = cat;
    document.getElementById('modalDate').querySelector('span').textContent = date;
    document.getElementById('modalCounter').textContent  = (idx + 1) + ' / ' + items.length;
}

function navigateModal(dir) {
    const items = getVisibleItems();
    currentModalIndex = (currentModalIndex + dir + items.length) % items.length;
    showModalItem(currentModalIndex, items);
}

function closeGalleryModal(e) {
    if (e.target === document.getElementById('galleryModal')) closeGalleryModalBtn();
}

function closeGalleryModalBtn() {
    const modal = document.getElementById('galleryModal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
}
</script>
@endsection
