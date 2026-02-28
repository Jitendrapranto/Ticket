@extends('layouts.app')

@section('title', $event->title . ' | Ticket Kinun')

@section('content')
<div class="bg-[#F8FAFC]">
    <!-- Breadcrumb (Optional but good for UX) -->
    <div class="bg-white border-b border-slate-100 py-4">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                <a href="{{ route('events') }}" class="hover:text-primary transition-colors">Events</a>
                <i class="fas fa-chevron-right text-[8px]"></i>
                <span class="text-slate-600">{{ $event->category ? $event->category->name : 'Special' }}</span>
                <i class="fas fa-chevron-right text-[8px]"></i>
                <span class="text-primary truncate max-w-[200px]">{{ $event->title }}</span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-12">
        <!-- Header Section (Full Width Alignment) -->
        <div class="mb-12 animate-fadeIn">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <h1 class="font-outfit text-4xl md:text-5xl font-black text-dark tracking-tight leading-tight">
                    {{ $event->title }}
                </h1>
                <button class="w-14 h-14 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary transition-all shadow-sm shrink-0">
                    <i class="fas fa-share-alt text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="flex flex-col lg:flex-row gap-10 relative items-start">

            <!-- ── LEFT SIDE (Scrollable) ── -->
            <div class="lg:w-3/5 space-y-10">

                <!-- Banner -->
                <div id="eventBanner" class="rounded-lg overflow-hidden shadow-2xl relative group">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-105">
                    @else
                        <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                            <i class="fas fa-image text-6xl text-slate-300"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-dark/40 to-transparent"></div>
                </div>

                <!-- Labels -->
                <div class="flex flex-wrap gap-4">
                    <span class="px-5 py-2.5 bg-secondary/5 border border-secondary/10 rounded-xl text-secondary font-black text-[11px] tracking-widest uppercase shadow-sm">
                        {{ $event->category ? $event->category->name : 'Event' }}
                    </span>
                    <span class="px-5 py-2.5 bg-accent/5 border border-accent/10 rounded-xl text-accent font-black text-[11px] tracking-widest uppercase shadow-sm">
                        Live Experience
                    </span>
                </div>

                <!-- About The Event -->
                <div class="bg-white rounded-[2.5rem] p-12 shadow-sm border border-slate-100">
                    <h2 class="font-outfit text-2xl font-black text-dark mb-8 tracking-tight flex items-center gap-4">
                        <span class="w-2 h-10 bg-primary rounded-full"></span>
                        About The Event
                    </h2>
                    <div class="text-slate-500 leading-relaxed font-medium text-lg">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>

                <!-- You Should Know -->
                @if($event->you_should_know)
                <div class="bg-[#FFF7ED] rounded-[2.5rem] p-10 border border-orange-100 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-32 h-32 bg-orange-200/20 rounded-full blur-3xl"></div>
                    <div class="flex gap-8 relative z-10">
                        <div class="w-16 h-16 bg-white rounded-[1.5rem] shadow-md flex items-center justify-center flex-shrink-0 text-orange-500 text-2xl border border-orange-50">
                            <i class="far fa-lightbulb"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-orange-900 mb-2">You Should Know</h3>
                            <p class="text-orange-900/70 text-base leading-relaxed font-medium">
                                {{ $event->you_should_know }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Artists -->
                @if($event->artists && is_array($event->artists))
                <div class="space-y-10">
                    <h2 class="font-outfit text-2xl font-black text-dark tracking-tight flex items-center gap-4">
                        <span class="w-2 h-10 bg-primary rounded-full"></span>
                        Performing Artists
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                        @foreach($event->artists as $artist)
                        <div class="space-y-5 text-center group">
                            <div class="aspect-square rounded-[2.5rem] overflow-hidden border-4 border-white shadow-xl transition-all duration-500 hover:scale-105 hover:shadow-2xl ring-1 ring-slate-100">
                                <img src="{{ $artist['image'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($artist['name'] ?? 'Artist') . '&background=520C6B&color=fff' }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold text-dark text-base">{{ $artist['name'] ?? 'Artist Name' }}</h4>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mt-1.5">{{ $artist['role'] ?? 'Artist' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Terms & Conditions -->
                @if($event->terms_conditions)
                <div class="space-y-6">
                    <button class="flex items-center justify-between w-full font-outfit text-2xl font-black text-dark tracking-tight pb-6 border-b border-slate-100 group transition-all hover:text-primary">
                        <span>Terms & Conditions</span>
                        <i class="fas fa-arrow-right text-xs text-slate-200 group-hover:text-primary group-hover:translate-x-2 transition-all"></i>
                    </button>
                    <div class="text-slate-400 text-base leading-relaxed font-medium space-y-6 px-2">
                        {!! nl2br(e($event->terms_conditions)) !!}
                    </div>
                </div>
                @endif

                <!-- You May Also Like -->
                @if($relatedEvents->count() > 0)
                <div class="space-y-10 pt-12 border-t border-slate-200">
                    <div class="flex items-end justify-between">
                        <div>
                            <span class="text-primary font-black tracking-[0.3em] text-[10px] uppercase mb-4 block text-center lg:text-left">RECOMMENDED</span>
                            <h2 class="font-outfit text-3xl font-black text-dark tracking-tighter leading-tight">Similar <span class="text-primary">Experiences.</span></h2>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($relatedEvents as $rEvent)
                        <a href="{{ route('events.show', $rEvent->slug) }}" class="group block bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-500">
                            <div class="aspect-video relative overflow-hidden">
                                <img src="{{ asset('storage/' . $rEvent->image) }}" class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110">
                                <div class="absolute inset-x-4 top-4">
                                    <span class="px-3 py-1 bg-black/50 backdrop-blur-md rounded-lg text-[9px] font-bold text-white uppercase tracking-widest">
                                        {{ $rEvent->category->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h4 class="font-outfit text-lg font-black text-dark group-hover:text-primary transition-colors line-clamp-1">{{ $rEvent->title }}</h4>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-400"><i class="far fa-calendar-alt mr-2 text-primary"></i> {{ $rEvent->date->format('d M, Y') }}</span>
                                    <span class="text-xs font-black text-primary uppercase">From ৳ {{ number_format($rEvent->price) }}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- ── RIGHT SIDE (Fixed/Sticky) ── -->
            <div class="lg:w-2/5 self-stretch">
                <div class="lg:sticky lg:top-8">
                    <div id="bookingCard" class="bg-white rounded-[2rem] border border-slate-50 shadow-sm p-5 flex flex-col justify-between animate-fadeIn">
                        <!-- Event Details List -->
                        <div class="space-y-2">
                            <!-- Date -->
                            <div class="flex items-center gap-3 text-slate-500">
                                <i class="fas fa-calendar-alt text-base w-4"></i>
                                <span class="text-[13px] font-bold">{{ $event->date->format('D d M Y') }}</span>
                            </div>
                            <!-- Time -->
                            <div class="flex items-center gap-3 text-slate-500">
                                <i class="fas fa-clock text-base w-4"></i>
                                <span class="text-[13px] font-bold">{{ $event->date->format('h:i A') }}</span>
                            </div>
                            <!-- Duration -->
                            <div class="flex items-center gap-3 text-slate-500">
                                <i class="fas fa-hourglass-half text-base w-4"></i>
                                <span class="text-[13px] font-bold">{{ $event->duration ?? '3 Hours' }}</span>
                            </div>
                            <!-- Age Limit -->
                            <div class="flex items-center gap-3 text-slate-500">
                                <i class="fas fa-users text-base w-4"></i>
                                <span class="text-[13px] font-bold">Age Limit - {{ $event->age_limit ?? '18+ only' }}</span>
                            </div>
                            <!-- Language -->
                            <div class="flex items-center gap-3 text-slate-500">
                                <i class="fas fa-language text-base w-4"></i>
                                <span class="text-[13px] font-bold">{{ $event->language ?? 'English , Bangla' }}</span>
                            </div>
                            <!-- Category -->
                            <div class="flex items-center gap-3 text-slate-500">
                                <i class="fas fa-music text-base w-4"></i>
                                <span class="text-[13px] font-bold">{{ $event->category ? $event->category->name : 'Music' }}</span>
                            </div>
                            <!-- Venue -->
                            <div class="flex items-start gap-3 text-slate-500">
                                <i class="fas fa-map-marker-alt text-base w-4 mt-0.5"></i>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-[13px] font-bold leading-snug">{{ $event->venue_name ?? $event->location }}</span>
                                        <i class="fas fa-location-arrow text-primary/40 text-[9px]"></i>
                                    </div>
                                    <p class="text-[10px] text-slate-400 font-bold">{{ $event->location }}</p>
                                </div>
                            </div>

                            <button class="text-[#F1556C] text-[11px] font-bold hover:underline">
                                View 1 Other City
                            </button>
                        </div>

                        <!-- Ticket Selection -->
                        @if($event->ticketTypes->where('quantity', '>', 0)->count() > 0)
                        <div class="pt-3 border-t border-slate-100">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Select Tickets</h4>
                            <div class="space-y-1.5">
                                @foreach($event->ticketTypes as $tier)
                                    @if($tier->quantity > 0)
                                    <div class="flex items-center justify-between bg-white border border-slate-100 rounded-xl px-4 py-3 ticket-row {{ $loop->first ? 'first-ticket' : '' }} shadow-sm hover:border-primary/20 transition-all" 
                                         data-price="{{ $tier->price }}" 
                                         data-tier-id="{{ $tier->id }}"
                                         data-available="{{ $tier->quantity }}">
                                         
                                         <!-- 1. Ticket Type -->
                                         <div class="flex-1 min-w-0">
                                             <span class="text-[13px] font-black text-dark block truncate">{{ $tier->name }}</span>
                                         </div>

                                         <!-- 2. Price -->
                                         <div class="flex-shrink-0 px-4">
                                             <span class="text-[11px] font-black text-primary">৳{{ number_format($tier->price) }}</span>
                                         </div>
                                         
                                         <!-- 3. Controls -->
                                         <div class="flex items-center gap-3 flex-shrink-0 bg-slate-50 p-1.5 rounded-lg border border-slate-100">
                                             <button type="button" class="w-7 h-7 rounded-md bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-primary transition-all decrement-qty shadow-sm">
                                                 <i class="fas fa-minus text-[8px]"></i>
                                             </button>
                                             <span class="text-sm font-black text-dark w-5 text-center qty-display">{{ $loop->first ? '1' : '0' }}</span>
                                             <button type="button" class="w-7 h-7 rounded-md bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-primary transition-all increment-qty shadow-sm">
                                                 <i class="fas fa-plus text-[8px]"></i>
                                             </button>
                                         </div>
                                     </div>
                                     @endif
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Bottom Section -->
                        <div class="space-y-3 pt-3">
                            <!-- Alert Box -->
                            <div class="bg-[#FFF8F1] rounded-lg p-3 flex items-center gap-2.5 border border-orange-50/50">
                                <div class="w-4 h-4 rounded-full bg-orange-400 flex items-center justify-center shrink-0">
                                    <i class="fas fa-info text-[7px] text-white"></i>
                                </div>
                                <p class="text-[11px] font-bold text-slate-700">Bookings are filling fast for {{ Str::words($event->location, 1, '') }}</p>
                            </div>

                            <!-- Price and Book Button -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xl font-black text-dark tracking-tighter">৳ <span id="totalDisplay">{{ number_format($event->ticketTypes->min('price') ?? 0) }}</span></p>
                                    <p class="text-[9px] font-black text-orange-500 mt-0.5 uppercase tracking-[0.15em]">Filling Fast</p>
                                </div>
                                <button id="bookNowBtn" class="px-6 py-3 bg-[#F1556C] hover:bg-[#E1445B] text-white rounded-lg font-black text-[13px] tracking-tight transition-all shadow-xl shadow-pink-100/50 active:scale-95">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.8s ease-out forwards;
    }
    #eventBanner img, #eventBanner > div {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<script>
    function syncBannerHeight() {
        const banner = document.getElementById('eventBanner');
        const card = document.getElementById('bookingCard');
        if (banner && card && window.innerWidth >= 1024) {
            banner.style.height = card.offsetHeight + 'px';
        } else if (banner) {
            banner.style.height = 'auto';
            banner.style.aspectRatio = '16/9';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        syncBannerHeight();
        const img = document.querySelector('#eventBanner img');
        if (img) img.addEventListener('load', syncBannerHeight);

        // Ticket Selection Logic
        const maxTickets = 4;
        const ticketRows = document.querySelectorAll('.ticket-row');
        const totalDisplay = document.getElementById('totalDisplay');

        function updateTotal() {
            let total = 0;
            let totalQty = 0;
            ticketRows.forEach(row => {
                const qty = parseInt(row.querySelector('.qty-display').textContent);
                const price = parseFloat(row.dataset.price);
                total += qty * price;
                totalQty += qty;
            });
            
            // Format number for display
            totalDisplay.textContent = total.toLocaleString();
        }

        ticketRows.forEach(row => {
            const incrementBtn = row.querySelector('.increment-qty');
            const decrementBtn = row.querySelector('.decrement-qty');
            const qtyDisplay = row.querySelector('.qty-display');
            const available = parseInt(row.dataset.available);

            incrementBtn.addEventListener('click', () => {
                let currentTotalQty = 0;
                ticketRows.forEach(r => currentTotalQty += parseInt(r.querySelector('.qty-display').textContent));

                if (currentTotalQty < maxTickets) {
                    let qty = parseInt(qtyDisplay.textContent);
                    if (qty < available) {
                        qtyDisplay.textContent = qty + 1;
                        updateTotal();
                    } else {
                        // Optional: Toast or small message instead of alert
                        console.log('Tier limit reached');
                    }
                } else {
                    alert('You can only purchase a maximum of 4 tickets in total.');
                }
            });

            decrementBtn.addEventListener('click', () => {
                let qty = parseInt(qtyDisplay.textContent);
                const minQty = row.classList.contains('first-ticket') ? 1 : 0;
                if (qty > minQty) {
                    qtyDisplay.textContent = qty - 1;
                    updateTotal();
                }
            });
        });
        
        // Book Now Redirect
        const bookNowBtn = document.getElementById('bookNowBtn');
        if (bookNowBtn) {
            bookNowBtn.addEventListener('click', () => {
                let params = new URLSearchParams();
                let hasTickets = false;
                
                ticketRows.forEach(row => {
                    const qty = parseInt(row.querySelector('.qty-display').textContent);
                    const tierId = row.dataset.tierId;
                    if (qty > 0) {
                        params.append(`tickets[${tierId}]`, qty);
                        hasTickets = true;
                    }
                });

                if (hasTickets) {
                    window.location.href = `{{ route('events.booking', $event->slug) }}?${params.toString()}`;
                } else {
                    alert('Please select at least one ticket to proceed.');
                }
            });
        }
        
        // Initial call to set total correctly based on quantities (0)
        updateTotal();
    });
    window.addEventListener('resize', syncBannerHeight);
</script>
@endsection
