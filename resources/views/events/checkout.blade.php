@extends('layouts.app')

@section('title', 'Secure Checkout - ' . $booking->event->title)

@section('content')
<div class="container mx-auto px-4 max-w-5xl mb-24">
    <div class="flex flex-col items-center justify-center mb-12 animate-fadeInUp">
        <div class="w-20 h-20 rounded-3xl bg-primary/10 flex items-center justify-center text-primary text-3xl mb-6 shadow-inner">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h1 class="font-outfit text-4xl font-black text-dark tracking-tight mb-2">Secure Checkout</h1>
        <p class="text-slate-500 font-medium">Verify your selection and choose a payment method to finalize your booking.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- ── LEFT: VERIFICATION ── -->
        <div class="lg:col-span-2 space-y-8 animate-fadeInUp" style="animation-delay: 0.1s">
            <!-- Order Details -->
            <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-premium relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8">
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-1">Booking ID</span>
                    <span class="text-xs font-black text-primary">{{ $booking->booking_id }}</span>
                </div>

                <h2 class="text-xl font-outfit font-black text-dark mb-8 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-sm">
                        <i class="fas fa-ticket-alt text-[10px]"></i>
                    </span>
                    Ticket Verification
                </h2>

                <div class="space-y-4">
                    @foreach($booking->attendees->groupBy('ticket_type_id') as $tierId => $attendees)
                        <div class="flex items-center justify-between p-6 bg-slate-50 rounded-2xl border border-slate-100">
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 rounded-xl bg-white flex flex-col items-center justify-center shadow-sm border border-slate-200/50">
                                    <span class="text-xl font-black text-dark">{{ $attendees->count() }}</span>
                                    <span class="text-[8px] font-black text-slate-400 uppercase">Qty</span>
                                </div>
                                <div>
                                    <h3 class="font-black text-dark text-sm">{{ $attendees->first()->ticketType->name }}</h3>
                                    <p class="text-[10px] font-black text-primary uppercase tracking-widest mt-0.5">৳{{ number_format($attendees->first()->ticketType->price) }} per ticket</p>
                                </div>
                            </div>
                            <span class="text-lg font-outfit font-black text-dark">৳{{ number_format($attendees->first()->ticketType->price * $attendees->count()) }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Total Row -->
                <div class="mt-10 pt-10 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Estimated Total</h4>
                        <p class="text-[10px] text-slate-400 font-medium italic">Inclusive of all convenience fees</p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-outfit font-black text-dark tracking-tighter">৳{{ number_format($booking->total_amount) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <form action="{{ route('events.checkout.complete', $booking->booking_id) }}" method="POST" x-data="{ method: 'card' }">
                @csrf
                <div class="bg-[#21032B] rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
                    
                    <h2 class="text-xl font-outfit font-black mb-10 relative z-10 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-sm">
                            <i class="fas fa-credit-card text-[10px]"></i>
                        </span>
                        Payment Gateway
                    </h2>

                    <input type="hidden" name="payment_method" :value="method">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10 mb-10">
                        <!-- bKash -->
                        <button type="button" @click="method = 'bkash'" :class="method === 'bkash' ? 'bg-primary border-primary' : 'bg-white/5 border-white/10'" class="group border p-8 rounded-3xl hover:bg-white/10 transition-all text-left relative overflow-hidden">
                            <div class="w-12 h-12 bg-white rounded-2xl mb-4 flex items-center justify-center overflow-hidden">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR0Y64iI0G9Jb4Z4_mU_N4b8v6iK_F9G6m_ZA&s" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-black text-[10px] mb-1 uppercase tracking-widest">Mobile Banking</h3>
                            <p class="text-[9px] text-white/50 font-medium">bKash Gateway</p>
                        </button>

                        <!-- Cards -->
                        <button type="button" @click="method = 'card'" :class="method === 'card' ? 'bg-primary border-primary' : 'bg-white/5 border-white/10'" class="group border p-8 rounded-3xl hover:bg-white/10 transition-all text-left relative overflow-hidden">
                            <div class="w-12 h-12 bg-white rounded-2xl mb-4 flex items-center justify-center text-primary text-xl">
                                <i class="fas fa-credit-card text-sm"></i>
                            </div>
                            <h3 class="font-black text-[10px] mb-1 uppercase tracking-widest">Credit Card</h3>
                            <p class="text-[9px] text-white/50 font-medium">Visa, Mastercard</p>
                        </button>

                        <!-- Cash on Delivery -->
                        <button type="button" @click="method = 'cod'" :class="method === 'cod' ? 'bg-primary border-primary' : 'bg-white/5 border-white/10'" class="group border p-8 rounded-3xl hover:bg-white/10 transition-all text-left relative overflow-hidden">
                            <div class="w-12 h-12 bg-white rounded-2xl mb-4 flex items-center justify-center text-primary text-xl">
                                <i class="fas fa-hand-holding-usd text-sm"></i>
                            </div>
                            <h3 class="font-black text-[10px] mb-1 uppercase tracking-widest">Cash On Delivery</h3>
                            <p class="text-[9px] text-white/50 font-medium">Pay on Entrance</p>
                        </button>
                    </div>

                    <button type="submit" class="w-full bg-white text-secondary py-5 rounded-2xl font-black text-xs tracking-[0.2em] transition-all shadow-xl active:scale-[0.98] uppercase flex items-center justify-center gap-3 relative z-10 hover:bg-slate-50">
                        <i class="fas fa-check-circle"></i> Complete Booking
                    </button>
                </div>
            </form>
        </div>

        <!-- ── RIGHT: SUMMARY ── -->
        <div class="lg:col-span-1 animate-fadeInUp" style="animation-delay: 0.2s">
            <div class="lg:sticky lg:top-40 space-y-6">
                <!-- Event Info -->
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-premium overflow-hidden">
                    <div class="aspect-[16/10] w-full relative">
                        @if($booking->event->image)
                            <img src="{{ asset('storage/' . $booking->event->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-primary/5 flex items-center justify-center"><i class="fas fa-image text-2xl text-primary/10"></i></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <h3 class="text-white font-outfit font-black text-lg leading-tight">{{ $booking->event->title }}</h3>
                        </div>
                    </div>
                    <div class="p-8 space-y-4">
                        <div class="flex items-center gap-3 text-slate-500">
                            <i class="fas fa-map-marker-alt w-5 text-primary/40 text-[10px]"></i>
                            <span class="text-xs font-bold">{{ $booking->event->location }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-500">
                            <i class="fas fa-calendar-alt w-5 text-primary/40 text-[10px]"></i>
                            <span class="text-xs font-bold">{{ $booking->event->date->format('d M, Y • h:i A') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Checkout Tip -->
                <div class="bg-amber-50 rounded-3xl p-8 border border-amber-100">
                    <div class="flex items-center gap-3 text-amber-700 mb-2">
                        <i class="fas fa-info-circle"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest">Limited Time</span>
                    </div>
                    <p class="text-[11px] text-amber-900/60 font-medium leading-relaxed">Your tickets are reserved for the next <span class="font-bold text-amber-900">10:00 minutes</span>. Please complete payment to avoid release.</p>
                </div>

                <!-- Footnote -->
                <p class="text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest px-8">By proceeding, you agree to Ticket Kinun's <a href="#" class="text-primary hover:underline">Terms of Service</a></p>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #F8FAFC !important; }
    header { background-color: white !important; }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
@endsection
