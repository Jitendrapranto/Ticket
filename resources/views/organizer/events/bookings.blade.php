@extends('layouts.organizer')

@section('title', 'Event Bookings')
@section('header_title', $event->title . ' - Bookings')

@section('content')
<div class="p-8 animate-fadeInUp">
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="font-outfit text-4xl font-black text-dark tracking-tighter">{{ $event->title }}</h1>
            <p class="text-slate-400 font-medium text-sm">Review incoming bookings and tickets for this event.</p>
        </div>
        <a href="{{ route('organizer.events.index') }}" class="px-8 py-4 bg-white text-dark border border-slate-200 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to Events
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-premium overflow-hidden border border-slate-50 relative min-h-[600px]">
        <div class="p-10 border-b border-slate-50 flex items-center justify-between bg-slate-50/10">
            <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Booking Roster</h3>
            <div class="flex items-center gap-3">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total: <span class="text-primary">{{ $bookings->total() }}</span></span>
            </div>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/20 border-b border-slate-50">
                        <th class="px-10 py-6">Customer Information</th>
                        <th class="px-8 py-6">Ticket Selection</th>
                        <th class="px-8 py-6">Revenue</th>
                        <th class="px-8 py-6">Status</th>
                        <th class="px-10 py-6 text-right">Acquisition Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-10 py-7">
                            <div class="space-y-1">
                                <p class="text-sm font-black text-dark group-hover:text-primary transition-colors">{{ $booking->first_name }} {{ $booking->last_name }}</p>
                                <p class="text-[10px] font-bold text-slate-400 tracking-wide uppercase">{{ $booking->email }}</p>
                                <p class="text-[9px] font-black text-slate-300">{{ $booking->phone }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-7">
                            <div class="flex flex-wrap gap-2">
                                @php $counts = $booking->attendees->groupBy('ticket_type_id')->map->count(); @endphp
                                @foreach($counts as $typeId => $count)
                                    @php $type = $booking->attendees->where('ticket_type_id', $typeId)->first()->ticketType; @endphp
                                    <span class="px-3 py-1 bg-primary/5 text-primary text-[9px] font-black rounded-lg border border-primary/10">
                                        {{ $count }}x {{ $type->name ?? 'Ticket' }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-8 py-7 font-black text-dark text-sm">৳{{ number_format($booking->total_amount, 2) }}</td>
                        <td class="px-8 py-7">
                            <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border
                                @if($booking->status === 'confirmed') bg-emerald-50 text-emerald-500 border-emerald-100 @else bg-orange-50 text-orange-500 border-orange-100 @endif">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="px-10 py-7 text-right">
                            <p class="text-xs font-black text-dark tracking-tight">{{ $booking->created_at->format('M d, Y') }}</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">{{ $booking->created_at->format('h:i A') }}</p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-32 text-center">
                            <div class="flex flex-col items-center gap-4 opacity-30">
                                <i class="fas fa-ticket-alt text-6xl"></i>
                                <p class="text-[10px] font-black uppercase tracking-[0.3em]">No Bookings Recorded Yet</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-10 bg-slate-50/30 border-t border-slate-50">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
