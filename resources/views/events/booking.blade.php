@extends('layouts.app')

@section('title', 'Booking Registration - ' . $event->title)

@section('content')
<div class="container mx-auto px-4 max-w-5xl mb-24" x-data="{ 
    mainTicketId: '{{ $ticketsData[0]['id'] }}',
    totalQty: {{ $totalQty }}
}">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- ── LEFT: FORM ── -->
        <div class="lg:col-span-2 space-y-8">
            <div class="animate-fadeInUp" style="animation-delay: 0.1s">
                <h1 class="font-outfit text-4xl font-black text-dark tracking-tight mb-2">Registration</h1>
                <p class="text-slate-500 font-medium">Please provide the attendee information to complete your booking.</p>
            </div>

            <form action="{{ route('events.booking.process', $event->slug) }}" method="POST" class="space-y-10">
                @csrf
                
                <!-- 1. Attendee Information Header & Choice -->
                <div class="space-y-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <h2 class="text-xl font-outfit font-black text-primary flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-sm">1</span>
                            Attendee Information
                        </h2>

                        @if(count($ticketsData) > 1)
                        <div class="bg-primary/5 p-2 rounded-2xl border border-primary/10 flex items-center gap-3">
                            <span class="text-[10px] font-black text-primary uppercase tracking-widest ml-2">I am booking for myself as:</span>
                            <div class="flex gap-2">
                                @foreach($ticketsData as $ticket)
                                <label class="relative flex items-center cursor-pointer group">
                                    <input type="radio" name="main_ticket_id" value="{{ $ticket['id'] }}" x-model="mainTicketId" class="sr-only peer">
                                    <div class="px-3 py-1.5 rounded-xl border border-primary/10 bg-white text-[10px] font-black uppercase text-slate-400 peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary transition-all group-hover:border-primary/30">
                                        {{ $ticket['name'] }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @else
                            <input type="hidden" name="main_ticket_id" value="{{ $ticketsData[0]['id'] }}">
                        @endif
                    </div>

                    <div class="space-y-6">
                        @foreach($ticketsData as $ticket)
                            @for($i = 1; $i <= $ticket['quantity']; $i++)
                                <div x-show="!(mainTicketId == '{{ $ticket['id'] }}' && {{ $i }} == 1)" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 transform -translate-y-4"
                                     x-transition:enter-end="opacity-100 transform translate-y-0"
                                     class="bg-white rounded-3xl p-8 border border-slate-100 shadow-premium group hover:border-primary/20 transition-all">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="font-black text-dark uppercase tracking-widest text-xs">
                                            <i class="fas fa-user-circle text-primary mr-2"></i>
                                            {{ $ticket['name'] }} - Other Participant
                                        </h3>
                                        <span class="text-[10px] font-black text-slate-300 uppercase italic">Attendee Profile</span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block ml-1">Full Name</label>
                                            <input type="text" name="attendees[{{ $ticket['id'] }}][{{ $i }}][name]" 
                                                :required="!(mainTicketId == '{{ $ticket['id'] }}' && {{ $i }} == 1)"
                                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner"
                                                placeholder="Enter name">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block ml-1">Mobile Number</label>
                                            <input type="text" name="attendees[{{ $ticket['id'] }}][{{ $i }}][mobile]" 
                                                :required="!(mainTicketId == '{{ $ticket['id'] }}' && {{ $i }} == 1)"
                                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner"
                                                placeholder="Enter mobile">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endforeach
                    </div>
                </div>

                <!-- 2. Dynamic Registration Form -->
                <div class="space-y-6">
                    <h2 class="text-xl font-outfit font-black text-primary flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-sm">2</span>
                        Main Registration Details
                    </h2>

                    <div class="bg-[#21032B] rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden">
                        <!-- Decorative background -->
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-accent/10 rounded-full blur-3xl"></div>

                        <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($event->formFields as $field)
                                <div class="{{ $field->type === 'textarea' || $field->is_default ? 'md:col-span-2' : '' }} space-y-3">
                                    <label class="text-[11px] font-black text-white/50 uppercase tracking-[0.2em] block ml-1">
                                        {{ $field->label }}
                                        @if($field->is_required) <span class="text-primary">*</span> @endif
                                    </label>
                                    
                                    @if($field->type === 'select')
                                        <select name="form_data[{{ $field->id }}]" {{ $field->is_required ? 'required' : '' }} 
                                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 outline-none focus:border-primary/50 focus:bg-white/10 transition-all text-sm font-bold cursor-pointer">
                                            <option value="" class="text-dark">Select an option</option>
                                            @foreach($field->options ?? [] as $option)
                                                <option value="{{ $option }}" class="text-dark">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    @elseif($field->type === 'textarea')
                                        <textarea name="form_data[{{ $field->id }}]" {{ $field->is_required ? 'required' : '' }} rows="3"
                                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 outline-none focus:border-primary/50 focus:bg-white/10 transition-all text-sm font-bold"
                                            placeholder="Enter {{ strtolower($field->label) }}"></textarea>
                                    @elseif($field->type === 'checkbox')
                                        <div class="flex items-center gap-3 py-2">
                                            <input type="checkbox" name="form_data[{{ $field->id }}]" {{ $field->is_required ? 'required' : '' }} 
                                                class="w-6 h-6 rounded-lg bg-white/5 border-white/10 text-primary focus:ring-primary/50">
                                            <span class="text-sm font-medium text-white/80">Agree to provide {{ strtolower($field->label) }}</span>
                                        </div>
                                    @else
                                        <input type="{{ $field->type }}" name="form_data[{{ $field->id }}]" {{ $field->is_required ? 'required' : '' }} 
                                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 outline-none focus:border-primary/50 focus:bg-white/10 transition-all text-sm font-bold"
                                            placeholder="Enter {{ strtolower($field->label) }}">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-[#F1556C] hover:bg-[#E1445B] text-white py-6 rounded-[2rem] font-black text-lg tracking-tight transition-all shadow-xl shadow-pink-100 active:scale-95 flex items-center justify-center gap-4">
                        Confirm & Pay ৳{{ number_format($totalPrice) }}
                        <i class="fas fa-arrow-right text-xs"></i>
                    </button>
                    <p class="text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-6">Secure Checkout • Instant E-Ticket generation</p>
                </div>
            </form>
        </div>

        <!-- ── RIGHT: SUMMARY ── -->
        <div class="lg:col-span-1">
            <div class="lg:sticky lg:top-40 space-y-6">
                <!-- Event Card -->
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-premium overflow-hidden animate-fadeInUp" style="animation-delay: 0.2s">
                    <div class="aspect-video w-full relative">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-primary/5 flex items-center justify-center">
                                <i class="fas fa-image text-3xl text-primary/20"></i>
                            </div>
                        @endif
                        <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-dark/80 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <span class="inline-block bg-primary text-white text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-widest mb-2">Selected Event</span>
                            <h3 class="text-white font-outfit font-black text-xl leading-tight">{{ $event->title }}</h3>
                        </div>
                    </div>
                    
                    <div class="p-8 space-y-6">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 text-slate-500">
                                <i class="fas fa-calendar-alt w-5 text-primary/40"></i>
                                <span class="text-sm font-bold">{{ $event->date->format('D, d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-4 text-slate-500">
                                <i class="fas fa-clock w-5 text-primary/40"></i>
                                <span class="text-sm font-bold">{{ $event->date->format('h:i A') }}</span>
                            </div>
                            <div class="flex items-start gap-4 text-slate-500">
                                <i class="fas fa-map-marker-alt w-5 text-primary/40 mt-1"></i>
                                <span class="text-sm font-bold leading-relaxed">{{ $event->venue_name ?? $event->location }}</span>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-50">
                            <h4 class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-4">Summary</h4>
                            <div class="space-y-3">
                                @foreach($ticketsData as $ticket)
                                <div class="flex justify-between items-center bg-slate-50 rounded-xl px-4 py-3">
                                    <div>
                                        <p class="text-sm font-bold text-dark">{{ $ticket['name'] }}</p>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">{{ $ticket['quantity'] }} Tickets × ৳{{ number_format($ticket['price']) }}</p>
                                    </div>
                                    <span class="text-sm font-black text-primary">৳{{ number_format($ticket['price'] * $ticket['quantity']) }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Payable</span>
                            <span class="text-3xl font-outfit font-black text-dark tracking-tighter">৳{{ number_format($totalPrice) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Trust Badge -->
                <div class="bg-primary/5 rounded-2xl p-6 flex items-center gap-4 border border-primary/10">
                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-primary shadow-sm shadow-primary/5">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-dark uppercase tracking-wide">Secure Transaction</h4>
                        <p class="text-[10px] text-slate-500 font-medium">Your data is encrypted and protected by standard SSL.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #F8FAFC !important; }
    header { background-color: white !important; }
</style>
@endsection
