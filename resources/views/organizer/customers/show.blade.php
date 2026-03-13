@extends('layouts.organizer')

@section('title', 'Customer Detail Profile')
@section('header_title', 'Customer Detail Profile')

@section('content')
<div class="p-8 animate-fadeInUp">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Left: Profile Identity -->
        <div class="lg:col-span-4 space-y-10">
            <div class="bg-white rounded-[3rem] p-10 shadow-premium border border-slate-50 text-center transition-transform hover:scale-[1.02]">
                <div class="relative inline-block mb-8">
                    <div class="w-36 h-36 rounded-[2.5rem] bg-gradient-to-br from-slate-50 to-slate-100 border-8 border-white shadow-2xl mx-auto flex items-center justify-center overflow-hidden">
                        @if($user->profile_picture)
                            <img loading="lazy" src="{{ asset('storage/' . $user->profile_picture) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-5xl font-black text-primary/40 uppercase">{{ substr($user->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-2xl bg-emerald-500 border-4 border-white flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                </div>
                <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter mb-2">{{ $user->name }}</h3>
                <p class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mb-6">Confirmed Attendee</p>

                <div class="flex items-center justify-center gap-2">
                    <span class="px-5 py-2 bg-slate-50 text-slate-400 text-[9px] font-black rounded-xl border border-slate-100 uppercase tracking-widest leading-none">Joined {{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>

            <div class="bg-white rounded-[3rem] p-10 shadow-premium border border-slate-50 space-y-8">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Contact Metadata</h4>

                <div class="flex flex-col gap-6">
                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50/50 border border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-primary shadow-sm">
                            <i class="far fa-envelope"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Email Identity</p>
                            <p class="text-xs font-black text-dark truncate max-w-[200px]">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50/50 border border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-accent shadow-sm">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Mobile Contact</p>
                            <p class="text-xs font-black text-dark">{{ $user->mobile ?: 'Not Provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Stats & History -->
        <div class="lg:col-span-8 space-y-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                <div class="bg-dark rounded-[2.5rem] p-10 text-white relative overflow-hidden group">
                    <i class="fas fa-ticket-alt absolute -right-6 -bottom-6 text-9xl text-white/5 transform rotate-12 transition-transform group-hover:scale-110"></i>
                    <div class="relative z-10">
                        <p class="text-[10px] font-black tracking-[0.2em] text-white/30 uppercase mb-4">Engagement Reach</p>
                        <h3 class="font-outfit text-5xl font-black tracking-tighter mb-2">{{ $bookings->count() }}</h3>
                        <p class="text-[11px] font-bold text-white/40 uppercase tracking-widest leading-none">Successful Bookings</p>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-10 shadow-premium border border-slate-50 relative overflow-hidden group">
                    <i class="fas fa-star absolute -right-6 -bottom-6 text-9xl text-primary/5 transform -rotate-12 transition-transform group-hover:scale-110"></i>
                    <div class="relative z-10">
                        <p class="text-[10px] font-black tracking-[0.2em] text-slate-400 uppercase mb-4">Retention Grade</p>
                        <h3 class="font-outfit text-5xl font-black text-dark tracking-tighter mb-2 uppercase">
                            @if($bookings->count() > 3) Platinum @elseif($bookings->count() > 1) Gold @else Base @endif
                        </h3>
                        <p class="text-[11px] font-bold text-slate-300 uppercase tracking-widest leading-none">Internal Rating</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[3rem] p-12 shadow-premium border border-slate-50 min-h-[500px]">
                <div class="flex items-center justify-between mb-12">
                    <h3 class="font-outfit text-2xl font-black text-dark tracking-tight">Ledger History</h3>
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Synced Across Nodes</span>
                    </div>
                </div>

                <div class="space-y-6">
                    @forelse($bookings as $booking)
                    <div class="flex items-center justify-between p-6 rounded-3xl bg-slate-50/50 border border-slate-100 hover:bg-white hover:shadow-premium transition-all group">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-primary text-xl shadow-sm transition-transform group-hover:scale-110">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-dark group-hover:text-primary transition-colors">{{ $booking->event->title ?? 'Archive Event' }}</p>
                                <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest leading-none">Ref: #{{ $booking->booking_id }} • {{ $booking->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-dark tracking-tight mb-1">৳{{ number_format($booking->total_amount, 2) }}</p>
                            <span class="text-[9px] font-black uppercase tracking-widest text-emerald-500 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100">{{ $booking->status }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-20 bg-slate-50/30 rounded-[2rem] border-2 border-dashed border-slate-100">
                        <i class="fas fa-receipt text-3xl text-slate-200 mb-6"></i>
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">No Transactions Found</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
