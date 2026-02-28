@extends('layouts.app')

@section('title', 'My Bookings - Ticket Kinun')

@section('content')
<div class="container mx-auto px-4 max-w-5xl mb-24 animate-fadeInUp">
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="font-outfit text-4xl font-black text-dark tracking-tight mb-2">My Bookings</h1>
            <p class="text-slate-500 font-medium">Track your tickets and explore your event history.</p>
        </div>
        <a href="{{ route('events') }}" class="bg-primary/5 text-primary px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-primary hover:text-white transition-all">
            Find More Events
        </a>
    </div>

    @if(session('booking_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success!',
                text: "{{ session('booking_success') }}",
                icon: 'success',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                background: '#ffffff',
                color: '#0F172A',
                iconColor: '#520C6B',
            });
        });
    </script>
    @endif

    @if($bookings->isEmpty())
        <div class="bg-white rounded-[2.5rem] p-20 border border-slate-100 shadow-premium text-center">
            <div class="w-20 h-20 rounded-3xl bg-slate-50 flex items-center justify-center text-slate-200 text-3xl mx-auto mb-6">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <h2 class="text-xl font-outfit font-black text-dark mb-2">No bookings found</h2>
            <p class="text-slate-400 font-medium max-w-xs mx-auto mb-10">You haven't booked any events yet. Start exploring now!</p>
            <a href="{{ route('events') }}" class="inline-block bg-primary text-white px-10 py-5 rounded-2xl font-black text-xs tracking-[0.2em] shadow-xl shadow-primary/20 hover:-translate-y-1 transition-all uppercase">
                Explore Events
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($bookings as $booking)
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-premium overflow-hidden group hover:border-primary/20 transition-all">
                    <div class="flex flex-col lg:flex-row">
                        <!-- Event Image -->
                        <div class="w-full lg:w-64 h-48 lg:h-auto relative overflow-hidden">
                            @if($booking->event->image)
                                <img src="{{ asset('storage/' . $booking->event->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-primary/5 flex items-center justify-center font-black text-primary/10">TICKET</div>
                            @endif
                            <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-dark/60 opacity-60"></div>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-white text-[9px] font-black px-3 py-1 rounded-full text-dark uppercase tracking-widest">{{ $booking->event->category->name ?? 'Event' }}</span>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="flex-1 p-8 lg:p-10 flex flex-col justify-between">
                            <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                                <div>
                                    <h3 class="font-outfit text-2xl font-black text-dark leading-tight group-hover:text-primary transition-colors">{{ $booking->event->title }}</h3>
                                    <div class="flex items-center gap-4 mt-2 text-slate-400">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-calendar-alt text-[10px]"></i>
                                            <span class="text-xs font-bold">{{ $booking->event->date->format('D, d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-map-marker-alt text-[10px]"></i>
                                            <span class="text-xs font-bold">{{ $booking->event->location }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $booking->status === 'confirmed' ? 'bg-green-50 text-green-500' : 'bg-amber-50 text-amber-500' }}">
                                        {{ $booking->status }}
                                    </span>
                                    <p class="text-[10px] font-black text-slate-300 uppercase mt-2 tracking-tighter">ID: {{ $booking->booking_id }}</p>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-6 pt-6 border-t border-slate-50">
                                <div class="flex items-center gap-8">
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Paid</p>
                                        <p class="font-outfit font-black text-xl text-dark">৳{{ number_format($booking->total_amount) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tickets</p>
                                        <div class="flex gap-1">
                                            @foreach($booking->attendees->groupBy('ticket_type_id') as $tier)
                                                <span class="text-[10px] font-black text-slate-500 bg-slate-100 px-2 py-1 rounded-lg">{{ $tier->count() }}x {{ $tier->first()->ticketType->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    @if($booking->status === 'confirmed' || $booking->payment_status === 'paid')
                                        <button class="bg-primary text-white px-6 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-primary/10 hover:shadow-primary/20 hover:-translate-y-1 transition-all">
                                            Download E-Ticket
                                        </button>
                                    @else
                                        <a href="{{ route('events.checkout', $booking->booking_id) }}" class="bg-[#F1556C] text-white px-6 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-pink-100 hover:shadow-pink-200 hover:-translate-y-1 transition-all">
                                            Complete Payment
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
