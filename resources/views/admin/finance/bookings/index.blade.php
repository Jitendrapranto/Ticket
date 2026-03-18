@extends('admin.dashboard')

@section('admin_content')
<div class="px-6 py-6 animate-fadeIn font-sans">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-dark tracking-tighter">Booking <span class="text-primary underline decoration-primary/10 decoration-8 underline-offset-8">Approval</span></h1>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.3em] mt-3">Verify and approve manual payment transactions</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.finance.bookings.index') }}" class="px-6 py-3 rounded-full text-[10px] font-black uppercase tracking-widest transition-all shadow-sm border {{ !request('status') ? 'bg-secondary text-white border-secondary' : 'bg-white text-slate-400 border-slate-100 hover:text-primary' }}">All</a>
            <a href="{{ route('admin.finance.bookings.index', ['status' => 'confirmed']) }}" class="px-6 py-3 rounded-full text-[10px] font-black uppercase tracking-widest transition-all shadow-sm border {{ request('status') == 'confirmed' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-emerald-500 border-emerald-100 hover:bg-emerald-50' }}">Confirmed</a>
        </div>
    </div>

    <!-- Main Table Container -->
    <div class="bg-white rounded-[2rem] shadow-premium border border-slate-50 relative overflow-visible">
        <div class="w-full overflow-visible min-h-[400px]">
            <table class="w-full text-left border-collapse table-fixed relative z-10">
                <thead>
                    <tr class="bg-slate-50/40 border-b border-slate-100">
                        <th class="w-[13%] pl-6 pr-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Transaction</th>
                        <th class="w-[15%] px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                        <th class="w-[12%] px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Sender Info</th>
                        <th class="w-[16%] px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Event</th>
                        <th class="w-[10%] px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Method</th>
                        <th class="w-[10%] px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Amount</th>
                        <th class="w-[8%] px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Date</th>
                        <th class="w-[8%] px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="w-[8%] pl-4 pr-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($bookings as $index => $booking)
                    <tr class="hover:bg-slate-50/60 transition-all group">
                        <!-- Transaction Info -->
                        <td class="pl-6 pr-4 py-4">
                            <div class="flex flex-col">
                                <span class="text-[11px] font-black text-primary hover:underline cursor-default tracking-tight truncate">
                                    {{ $booking->transaction_id ?? 'N/A' }}
                                </span>
                                <span class="text-[8px] text-slate-400 font-bold uppercase mt-1 tracking-tighter truncate">ID: {{ $booking->booking_id }}</span>
                            </div>
                        </td>
                        
                        <!-- Customer -->
                        <td class="px-4 py-4">
                            <div class="flex flex-col">
                                <span class="text-[11px] font-extrabold text-dark truncate w-full">{{ $booking->user->name ?? 'Unknown' }}</span>
                                <span class="text-[9px] text-slate-400 font-bold tracking-tight lowercase truncate w-full">{{ $booking->user->email ?? '' }}</span>
                            </div>
                        </td>
 
                        <!-- Sender Info -->
                        <td class="px-4 py-4">
                            <span class="text-[11px] font-black text-slate-600 tracking-wider truncate block w-full">{{ $booking->payment_number ?? 'N/A' }}</span>
                        </td>
 
                        <!-- Event -->
                        <td class="px-4 py-4">
                            <div class="flex flex-col">
                                <span class="text-[11px] font-black text-dark tracking-tighter truncate w-full">{{ $booking->event->title }}</span>
                                <span class="text-[8px] text-slate-400 font-bold uppercase mt-0.5 tracking-widest truncate w-full">{{ $booking->event->event_code ?? $booking->event->id }}</span>
                            </div>
                        </td>
 
                        <!-- Method -->
                        <td class="px-4 py-4">
                            <div class="flex justify-center">
                                <span class="px-2 py-1 bg-slate-50 border border-slate-100 rounded-lg text-[8px] font-black uppercase tracking-tighter text-slate-500 whitespace-nowrap block w-full text-center truncate">
                                    {{ $booking->payment_method_name ?? $booking->payment_method ?? 'Unknown' }}
                                </span>
                            </div>
                        </td>
 
                        <!-- Amount -->
                        <td class="px-4 py-4 text-right">
                            <span class="text-[11px] font-black text-dark tracking-tight truncate block w-full">৳{{ number_format($booking->total_amount) }}</span>
                        </td>
 
                        <!-- Date -->
                        <td class="px-4 py-4 text-center">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-dark truncate">{{ $booking->created_at->format('d M') }}</span>
                            </div>
                        </td>
 
                        <!-- Status -->
                        <td class="px-4 py-4">
                            <div class="flex justify-center">
                                @if($booking->status == 'pending')
                                    <span class="px-2 py-1 bg-amber-500/10 text-amber-600 border border-amber-500/10 rounded-lg text-[8px] font-black uppercase tracking-widest whitespace-nowrap w-full text-center truncate">Pending</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="px-2 py-1 bg-emerald-500/10 text-emerald-600 border border-emerald-500/10 rounded-lg text-[8px] font-black uppercase tracking-widest whitespace-nowrap w-full text-center truncate">Approved</span>
                                @else
                                    <span class="px-2 py-1 bg-rose-500/10 text-rose-600 border border-rose-500/10 rounded-lg text-[8px] font-black uppercase tracking-widest whitespace-nowrap w-full text-center truncate">{{ $booking->status }}</span>
                                @endif
                            </div>
                        </td>
 
                        <!-- Actions -->
                        <td class="pl-4 pr-6 py-4">
                            <div class="flex items-center justify-center">
                                <div x-data="{ open: false }" class="relative" :class="open ? 'z-[60]' : 'z-20'">
                                    <button @click="open = !open" @click.away="open = false" 
                                        class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all duration-300 shadow-sm"
                                        :class="open ? 'bg-primary text-white ring-4 ring-primary/10' : ''">
                                        <i class="fas fa-ellipsis-v text-[10px]"></i>
                                    </button>
                                    
                                      <div x-show="open" 
                                           x-transition:enter="transition ease-out duration-200"
                                           x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                           x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                           x-transition:leave="transition ease-in duration-150"
                                           x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                           x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                           class="absolute right-0 {{ $loop->last || ($loop->count > 1 && $loop->iteration >= $loop->count - 1) ? 'bottom-full mb-3' : 'top-full mt-3' }} w-48 bg-white rounded-2xl shadow-2xl border border-slate-100 z-50 overflow-hidden" 
                                          x-cloak>
                                        <div class="p-2 space-y-1">
                                            <a href="{{ route('admin.finance.bookings.show', $booking->id) }}" class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 hover:text-primary rounded-xl transition-all group/item">
                                                <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center group-hover/item:bg-white transition-all"><i class="fas fa-eye"></i></div>
                                                View Info
                                            </a>
                                            
                                            @if($booking->status == 'pending')
                                            <button @click="approveBooking({{ $booking->id }}); open = false" class="w-full flex items-center gap-3 px-4 py-2.5 text-[10px] font-black uppercase tracking-widest text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all group/item">
                                                <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center group-hover/item:bg-white transition-all"><i class="fas fa-check-circle"></i></div>
                                                Approve
                                            </button>
                                            
                                            <button @click="rejectBooking({{ $booking->id }}); open = false" class="w-full flex items-center gap-3 px-4 py-2.5 text-[10px] font-black uppercase tracking-widest text-rose-600 hover:bg-rose-50 rounded-xl transition-all group/item">
                                                <div class="w-7 h-7 rounded-lg bg-rose-50 flex items-center justify-center group-hover/item:bg-white transition-all"><i class="fas fa-times-circle"></i></div>
                                                Reject
                                            </button>
                                            @endif

                                            <div class="border-t border-slate-50 my-1"></div>
                                            
                                            <button @click="deleteBooking({{ $booking->id }}); open = false" class="w-full flex items-center gap-3 px-4 py-2.5 text-[10px] font-black uppercase tracking-widest text-red-500 hover:bg-red-50 rounded-xl transition-all group/item">
                                                <div class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center group-hover/item:bg-white transition-all"><i class="fas fa-trash-alt"></i></div>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
 
        @if($bookings->isEmpty())
        <div class="py-32 text-center flex flex-col items-center justify-center">
            <div class="w-16 h-16 bg-slate-50 rounded-[1.5rem] flex items-center justify-center mb-6 text-slate-200">
                <i class="fas fa-search text-xl"></i>
            </div>
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em]">No Transaction Records Found</p>
        </div>
        @endif
    </div>
 
    @if($bookings->hasPages())
    <div class="mt-8 flex justify-end">
        <div class="bg-white p-2 rounded-2xl shadow-premium border border-slate-100">
            {{ $bookings->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Invisible Forms -->
<form id="approve-form" method="POST" class="hidden">@csrf</form>
<form id="reject-form" method="POST" class="hidden">@csrf</form>
<form id="delete-form" method="POST" class="hidden">@csrf @method('DELETE')</form>

<script>
    function approveBooking(id) {
        Swal.fire({
            title: 'Confirm Payment?',
            text: "User will receive their e-tickets immediately.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10B981',
            cancelButtonColor: '#475569',
            confirmButtonText: 'Yes, Approve',
            background: '#ffffff',
            color: '#1e293b',
            customClass: {
                popup: 'rounded-[2rem] border border-slate-100 shadow-2xl font-sans',
                confirmButton: 'rounded-xl px-10 py-4 font-black uppercase tracking-widest text-[9px]',
                cancelButton: 'rounded-xl px-10 py-4 font-black uppercase tracking-widest text-[9px]'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('approve-form');
                form.action = `/admin/finance/bookings/${id}/approve`;
                form.submit();
            }
        })
    }

    function rejectBooking(id) {
        Swal.fire({
            title: 'Reject Transaction?',
            text: "This will invalidate the payment submission.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F43F5E',
            cancelButtonColor: '#475569',
            confirmButtonText: 'Yes, Reject',
            background: '#ffffff',
            color: '#1e293b',
            customClass: {
                popup: 'rounded-[2rem] border border-slate-100 shadow-2xl font-sans',
                confirmButton: 'rounded-xl px-10 py-4 font-black uppercase tracking-widest text-[9px]',
                cancelButton: 'rounded-xl px-10 py-4 font-black uppercase tracking-widest text-[9px]'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('reject-form');
                form.action = `/admin/finance/bookings/${id}/reject`;
                form.submit();
            }
        })
    }

    function deleteBooking(id) {
        Swal.fire({
            title: 'Delete Booking?',
            text: "This action cannot be undone. All related data will be removed.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F43F5E',
            cancelButtonColor: '#475569',
            confirmButtonText: 'Yes, Delete',
            background: '#ffffff',
            color: '#1e293b',
            customClass: {
                popup: 'rounded-[2rem] border border-slate-100 shadow-2xl font-sans',
                confirmButton: 'rounded-xl px-10 py-4 font-black uppercase tracking-widest text-[9px]',
                cancelButton: 'rounded-xl px-10 py-4 font-black uppercase tracking-widest text-[9px]'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = `/admin/finance/bookings/${id}`;
                form.submit();
            }
        })
    }

</script>

<style>
    .font-sans { font-family: 'Inter', sans-serif !important; }
    .shadow-premium { box-shadow: 0 40px 100px -20px rgba(0,0,0,0.03); }
    .animate-fadeIn { animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    /* Compact Layout Styling */
    table td, table th { border-color: #F8FAFC !important; }
    tr:last-child td { border-bottom: none !important; }
    
    /* Custom Scrollbar for the horizontal table */
    ::-webkit-scrollbar { height: 4px; }
    ::-webkit-scrollbar-track { background: #F8FAFC; }
    ::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }
</style>
@endsection
