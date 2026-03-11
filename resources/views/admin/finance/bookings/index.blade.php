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
            <a href="{{ route('admin.finance.bookings.index') }}" class="px-6 py-3 bg-white border border-slate-100 rounded-full text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-primary transition-all shadow-sm">All</a>
            <a href="{{ route('admin.finance.bookings.index', ['status' => 'pending']) }}" class="px-6 py-3 bg-white border border-amber-100 rounded-full text-[10px] font-black {{ request('status') == 'pending' ? 'bg-amber-500 text-white' : 'text-amber-500' }} uppercase tracking-widest hover:bg-amber-500 hover:text-white transition-all shadow-sm">Pending</a>
            <a href="{{ route('admin.finance.bookings.index', ['status' => 'confirmed']) }}" class="px-6 py-3 bg-white border border-emerald-100 rounded-full text-[10px] font-black {{ request('status') == 'confirmed' ? 'bg-emerald-500 text-white' : 'text-emerald-500' }} uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all shadow-sm">Confirmed</a>
        </div>
    </div>

    <!-- Main Table Container -->
    <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-premium border border-slate-50">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[1200px]">
                <thead>
                    <tr class="bg-slate-50/30 border-b border-slate-50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Transaction ID</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Sender No</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Event ID</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Method</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Amount</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date & Time</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($bookings as $booking)
                    <tr class="hover:bg-slate-50/60 transition-all group">
                        <!-- Transaction ID -->
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-primary underline decoration-primary/5 decoration-4 tracking-tight">
                                    {{ $booking->transaction_id ?? 'N/A' }}
                                </span>
                                <span class="text-[8px] text-slate-300 font-bold uppercase mt-1">TK: {{ $booking->booking_id }}</span>
                            </div>
                        </td>
                        
                        <!-- Customer -->
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-dark tracking-tight">{{ $booking->user->name ?? 'Unknown' }}</span>
                                <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest line-clamp-1">{{ $booking->user->email ?? '' }}</span>
                            </div>
                        </td>

                        <!-- Sender No -->
                        <td class="px-6 py-5">
                            <span class="text-xs font-black text-dark tracking-widest">{{ $booking->payment_number ?? 'N/A' }}</span>
                        </td>

                        <!-- Event -->
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                            <span class="text-xs font-black text-dark tracking-wider">{{ $booking->event->event_code ?? $booking->event->id }}</span>
                            <span class="text-[7px] text-slate-300 font-bold uppercase mt-1 tracking-tighter truncate max-w-[100px]">{{ $booking->event->title }}</span>
                        </div>
                        </td>

                        <!-- Method -->
                        <td class="px-6 py-5">
                            <div class="flex justify-center">
                                <span class="px-4 py-1.5 bg-slate-50 border border-slate-100 rounded-full text-[8px] font-black uppercase tracking-widest text-slate-400">
                                    {{ $booking->payment_method_name ?? $booking->payment_method ?? 'Unknown' }}
                                </span>
                            </div>
                        </td>

                        <!-- Amount -->
                        <td class="px-6 py-5">
                            <span class="text-xs font-black text-primary tracking-tight">৳{{ number_format($booking->total_amount) }}</span>
                        </td>

                        <!-- Date & Time -->
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-dark">{{ $booking->created_at->format('d M, Y') }}</span>
                                <span class="text-[9px] font-black text-slate-300 uppercase mt-0.5 tracking-tighter">{{ $booking->created_at->format('h:i:s A') }}</span>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-5">
                            <div class="flex justify-center">
                                @if($booking->status == 'pending')
                                    <div class="flex flex-col gap-1 items-center">
                                        <span class="px-4 py-1.5 bg-amber-500/10 text-amber-500 border border-amber-500/10 rounded-full text-[7px] font-black uppercase tracking-widest">Pending</span>
                                        <span class="text-[6px] text-amber-400 font-bold uppercase tracking-[0.2em]">Verification</span>
                                    </div>
                                @elseif($booking->status == 'confirmed')
                                    <span class="px-5 py-1.5 bg-emerald-500/10 text-emerald-500 border border-emerald-500/10 rounded-full text-[8px] font-black uppercase tracking-widest">Approved</span>
                                @else
                                    <span class="px-5 py-1.5 bg-rose-500/10 text-rose-500 border border-rose-500/10 rounded-full text-[8px] font-black uppercase tracking-widest shadow-sm">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.finance.bookings.show', $booking->id) }}" class="w-9 h-9 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center hover:bg-dark hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-eye text-[10px]"></i>
                                </a>
                                @if($booking->status == 'pending')
                                <button onclick="approveBooking({{ $booking->id }})" class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all shadow-sm border border-emerald-100/50">
                                    <i class="fas fa-check text-[10px]"></i>
                                </button>
                                <button onclick="rejectBooking({{ $booking->id }})" class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-sm border border-rose-100/50">
                                    <i class="fas fa-times text-[10px]"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($bookings->isEmpty())
        <div class="py-24 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-50">
                <i class="fas fa-search text-2xl text-slate-100"></i>
            </div>
            <p class="text-slate-300 text-[10px] font-black uppercase tracking-[0.4em]">No transaction records found</p>
        </div>
        @endif
    </div>

    @if($bookings->hasPages())
    <div class="mt-8 flex justify-end">
        <div class="bg-white px-2 py-2 rounded-2xl shadow-sm border border-slate-50">
            {{ $bookings->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Invisible Forms -->
<form id="approve-form" method="POST" class="hidden">@csrf</form>
<form id="reject-form" method="POST" class="hidden">@csrf</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
            popup: 'font-sans'
        }
    });

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

    @if(session('success'))
        Toast.fire({ icon: 'success', title: "{{ session('success') }}", background: '#10B981', color: '#ffffff' });
    @endif
    @if(session('error'))
        Toast.fire({ icon: 'error', title: "{{ session('error') }}", background: '#F43F5E', color: '#ffffff' });
    @endif
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
