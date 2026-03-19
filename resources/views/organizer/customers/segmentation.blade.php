@extends('layouts.organizer')

@section('title', 'Precision Targeting')
@section('header_title', 'Precision Targeting')

@section('content')
<div class="p-8 animate-fadeInUp">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
        <div class="max-w-xl">
            <h1 class="font-outfit text-5xl font-black text-dark tracking-tighter mb-4">Precision Targeting</h1>
            <p class="text-slate-400 font-medium text-base leading-relaxed">Isolate specific attendee groups by event registration, ticket tiers, and individual data for more effective communication and planning.</p>
        </div>
        <div>
            <a href="{{ route('organizer.customers.segmentation.export', request()->all()) }}" target="_blank" class="bg-dark text-white px-10 py-5 rounded-[1.5rem] text-xs font-black uppercase tracking-widest hover:bg-primary transition-all flex items-center gap-4 shadow-2xl shadow-dark/10 group text-center">
                <i class="fas fa-file-csv text-[14px] group-hover:-translate-y-1 transition-transform"></i>
                <span>Download Segment</span>
            </a>
        </div>
    </div>

    <!-- Smart Filter Engine -->
    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-50 shadow-premium mb-12">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center text-sm">
                <i class="fas fa-filter"></i>
            </div>
            <h3 class="text-[10px] font-black text-dark uppercase tracking-[0.2em]">Active Segment Filters</h3>
        </div>

        <form action="{{ route('organizer.customers.segmentation') }}" method="GET" id="filterForm" x-data x-ref="filterForm" class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
            <!-- Event Select -->
            <div class="md:col-span-5 group">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 group-focus-within:text-primary transition-colors">By Individual Event</label>
                <div class="relative">
                    <select name="event_id" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-xs font-bold text-dark focus:ring-4 focus:ring-primary/5 focus:bg-white outline-none transition-all appearance-none cursor-pointer">
                        <option value="">All Active Events</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                {{ $event->title }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-[10px]"></i>
                </div>
            </div>

            <!-- Search Input -->
            <div class="md:col-span-7 group">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 group-focus-within:text-primary transition-colors">Search Attendee Metadata</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-slate-300"></i>
                    <input type="text" name="search" id="segSearch" value="{{ request('search') }}"
                        @input.debounce.500ms="$refs.filterForm.submit()"
                        placeholder="Search by name, email, or phone..."
                        class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-14 pr-8 py-4 text-xs font-bold text-dark focus:ring-4 focus:ring-primary/5 focus:bg-white transition-all outline-none">
                </div>
            </div>
        </form>
    </div>

    <!-- Main Data View -->
    <div class="bg-white rounded-[3rem] shadow-premium border border-white overflow-hidden relative min-h-[600px]">
        <!-- Data Header -->
        <div class="p-12 pb-8 flex flex-col md:flex-row md:items-center justify-between gap-8 border-b border-slate-50 bg-slate-50/10">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 rounded-[1.5rem] bg-dark flex items-center justify-center text-white text-2xl shadow-xl shadow-dark/10">
                    <i class="fas fa-users-viewfinder"></i>
                </div>
                <div>
                    <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter mb-1">
                        @if(request('event_id') && $events->find(request('event_id')))
                            {{ $events->find(request('event_id'))->title }}
                        @else
                            Current Audience Segment
                        @endif
                    </h3>
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Total Sample Size:</span>
                        <span class="bg-emerald-50 text-emerald-600 text-[11px] font-black px-3 py-1 rounded-lg">{{ number_format($attendees->total()) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Table Layout -->
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/30 text-[10px] font-black tracking-[0.2em] text-slate-400 uppercase border-b border-slate-50">
                        <th class="px-12 py-6">Registration Data</th>
                        <th class="px-8 py-6 text-center">Ticket Tier</th>
                        <th class="px-8 py-6 text-center">Payment Status</th>
                        <th class="px-12 py-6 text-right">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium">
                    @forelse($attendees as $attendee)
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-12 py-8">
                            <div class="flex items-center gap-5">
                                <div class="relative">
                                    <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 shadow-sm flex items-center justify-center overflow-hidden transition-transform group-hover:scale-110">
                                        @php
                                            $customerPhoto = null;
                                            if ($attendee->booking->form_data && $attendee->booking->event && $attendee->booking->event->formFields) {
                                                $fileFields = $attendee->booking->event->formFields->where('type', 'file');
                                                foreach ($fileFields as $ff) {
                                                    $val = $attendee->booking->form_data[$ff->id] ?? null;
                                                    if ($val && \Storage::disk('public')->exists($val)) {
                                                        $ext = strtolower(pathinfo($val, PATHINFO_EXTENSION));
                                                        if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                                                            $customerPhoto = asset('storage/' . $val);
                                                        }
                                                    }
                                                }
                                            }
                                            $initials = substr($attendee->name && $attendee->name !== 'Self' ? $attendee->name : ($attendee->booking->user->name ?? 'U'), 0, 1);
                                        @endphp
                                        @if($customerPhoto)
                                            <img loading="lazy" src="{{ $customerPhoto }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-base font-black text-primary/30 uppercase">{{ $initials }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-dark tracking-tight leading-none group-hover:text-primary transition-colors">
                                        {{ $attendee->name && $attendee->name !== 'Self' ? $attendee->name : ($attendee->booking->user->name ?? 'Guest Attendee') }}
                                    </p>
                                    @if($attendee->booking->user)
                                        <p class="text-[10px] font-bold text-slate-400 mt-1.5">{{ $attendee->booking->user->email }}</p>
                                    @endif

                                    @if($attendee->booking->form_data && $attendee->booking->event && $attendee->booking->event->formFields->count())
                                    <div class="flex flex-wrap gap-y-1.5 gap-x-2 mt-3 pt-3 border-t border-slate-50">
                                        @foreach($attendee->booking->event->formFields as $field)
                                            @php 
                                                $val = $attendee->booking->form_data[$field->id] ?? null; 
                                                if (!$val || $field->type === 'file') continue;
                                            @endphp
                                            <div class="flex items-center gap-1.5 bg-slate-50/80 border border-slate-100/50 px-2.5 py-1 rounded-lg text-[9px] font-bold text-slate-500 hover:bg-white hover:border-primary/20 transition-all cursor-default group/tag" title="{{ $field->label }}">
                                                <span class="text-primary/60 font-black uppercase tracking-tighter group-hover/tag:text-primary transition-colors">{{ $field->label }}:</span>
                                                <span class="text-dark">{{ is_array($val) ? implode(', ', $val) : $val }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-8 text-center">
                            <span class="px-4 py-1.5 rounded-full border border-slate-100 bg-white text-[10px] font-black text-slate-500 uppercase tracking-widest shadow-sm">
                                {{ $attendee->ticketType->name ?? 'Standard' }}
                            </span>
                        </td>
                        <td class="px-8 py-8 text-center">
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-[0.1em] 
                                @if($attendee->booking->status == 'confirmed') bg-emerald-50 text-emerald-500 border border-emerald-100 @else bg-orange-50 text-orange-500 border border-orange-100 @endif">
                                {{ $attendee->booking->status }}
                            </div>
                        </td>
                        <td class="px-12 py-8 text-right">
                            <div class="text-right">
                                <p class="text-xs font-black text-dark tracking-tight">{{ $attendee->created_at->format('M d, Y') }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $attendee->created_at->format('h:i A') }}</p>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-12 py-24 text-center">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">No matching souls in this segment.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-12 bg-slate-50/50 border-t border-slate-50 flex flex-col md:flex-row items-center justify-between gap-8">
            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">
                Found <span class="text-dark">{{ $attendees->total() }}</span> registered identities.
            </p>
            <div>
                {{ $attendees->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.addEventListener('load', function() {
        const input = document.getElementById('segSearch');
        if (input && "{{ request('search') }}") {
            input.focus();
            const length = input.value.length;
            input.setSelectionRange(length, length);
        }
    });
</script>
@endpush
