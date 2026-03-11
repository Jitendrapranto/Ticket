@extends('admin.dashboard')

@section('admin_content')
<div class="px-8 py-8 animate-fadeIn">
    <!-- Header -->
    <div class="flex items-center gap-6 mb-12">
        <a href="{{ route('admin.finance.bookings.index') }}" class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-slate-400 hover:text-primary transition-all border border-slate-100 shadow-sm">
            <i class="fas fa-arrow-left text-xs"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-dark italic tracking-tighter">Transaction <span class="text-primary underline decoration-primary/10 decoration-8 underline-offset-8">Details</span></h1>
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-3">Verifying payment for {{ $booking->booking_id }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Main: Payment Proof -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Screenshot Card -->
            <div class="bg-white border border-white rounded-[3rem] p-10 relative overflow-hidden group shadow-premium">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
                
                <h2 class="text-lg font-black text-dark mb-10 flex items-center gap-4 italic relative z-10">
                    <span class="w-10 h-10 rounded-2xl bg-slate-50 flex items-center justify-center text-primary text-sm">
                        <i class="fas fa-camera"></i>
                    </span>
                    Payment Screenshot
                </h2>

                <div class="rounded-[2rem] overflow-hidden border border-slate-100 bg-slate-50 min-h-[400px] flex items-center justify-center relative z-10">
                    @if($booking->payment_screenshot)
                        <img src="{{ asset('storage/' . $booking->payment_screenshot) }}" class="max-w-full h-auto" alt="Payment Proof">
                    @else
                        <div class="flex flex-col items-center text-slate-200">
                            <i class="fas fa-image text-6xl mb-4"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest">No screenshot uploaded</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Transaction Data Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white border border-white rounded-3xl p-8 flex items-center gap-6 shadow-premium">
                    <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                        <i class="fas fa-hashtag text-xl"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1 italic">Transaction ID</p>
                        <p class="text-lg font-black text-dark tracking-tight italic">{{ $booking->transaction_id ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="bg-white border border-white rounded-3xl p-8 flex items-center gap-6 shadow-premium">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-500">
                        <i class="fas fa-phone text-xl"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1 italic">Sender Mobile</p>
                        <p class="text-lg font-black text-dark tracking-tight italic">{{ $booking->payment_number ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Order & Action -->
        <div class="space-y-10">
            <!-- Customer Info -->
            <div class="bg-white border border-white rounded-[2.5rem] p-10 shadow-premium">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] mb-8 italic">Customer Info</h3>
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center text-primary font-black text-xl italic border border-slate-100 shadow-sm">
                        {{ substr($booking->user->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <h4 class="text-dark font-black italic">{{ $booking->user->name ?? 'Guest' }}</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $booking->user->email ?? '' }}</p>
                    </div>
                </div>
                
                <div class="space-y-4 pt-8 border-t border-slate-50">
                    <div class="flex justify-between items-center text-[10px] font-black italic uppercase">
                        <span class="text-slate-400 tracking-widest">Amount Paid</span>
                        <span class="text-primary underline decoration-primary/10 decoration-4">৳{{ number_format($booking->total_amount) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[10px] font-black italic uppercase">
                        <span class="text-slate-400 tracking-widest">Gateway</span>
                        <span class="text-dark">{{ $booking->payment_method_name ?? $booking->payment_method }}</span>
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div class="bg-secondary border border-white/5 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden group">
                <div class="absolute -left-12 -bottom-12 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-colors"></div>
                
                <h3 class="text-xs font-black text-white/40 uppercase tracking-[0.3em] mb-8 relative z-10 italic">Management</h3>
                
                <div class="relative z-10 space-y-4">
                    @if($booking->status == 'pending')
                    <button onclick="approveBooking({{ $booking->id }})" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-5 rounded-2xl font-black text-[10px] tracking-[0.2em] uppercase transition-all shadow-xl active:scale-95 italic">
                        Approve Payment
                    </button>
                    <button onclick="rejectBooking({{ $booking->id }})" class="w-full bg-white/5 hover:bg-white/10 text-white py-5 rounded-2xl font-black text-[10px] tracking-[0.2em] uppercase transition-all border border-white/10 italic">
                        Reject Booking
                    </button>
                    @else
                    <div class="py-6 px-8 rounded-2xl bg-white/5 border border-white/10 text-center">
                        <span class="text-[10px] font-black uppercase tracking-[0.3em] {{ $booking->status == 'confirmed' ? 'text-emerald-500' : 'text-red-500' }}">
                            Already {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<form id="approve-form" method="POST" class="hidden">@csrf</form>
<form id="reject-form" method="POST" class="hidden">@csrf</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function approveBooking(id) {
        Swal.fire({
            title: 'Confirm Approval?',
            text: "Payment will be verified and ticket will be released.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10B981',
            confirmButtonText: 'Confirm Now',
            background: '#1F0421',
            color: '#ffffff',
            customClass: { popup: 'rounded-[2rem] border border-white/10 shadow-2xl' }
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
            title: 'Reject Recording?',
            text: "This booking will be cancelled and transaction marked as invalid.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            confirmButtonText: 'Yes, Reject',
            background: '#1F0421',
            color: '#ffffff',
            customClass: { popup: 'rounded-[2rem] border border-white/10 shadow-2xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('reject-form');
                form.action = `/admin/finance/bookings/${id}/reject`;
                form.submit();
            }
        })
    }

    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            background: '#10B981',
            color: '#ffffff'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000,
            background: '#EF4444',
            color: '#ffffff'
        });
    @endif
</script>
@endsection
