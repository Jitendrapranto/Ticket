@extends('admin.dashboard')

@section('admin_content')
<div class="p-8 animate-fadeIn" x-data="{ 
    showApproveModal: false, 
    showRejectModal: false,
    selectedId: null,
    selectedAmount: 0,
    selectedUser: ''
}">
    <!-- Header -->
    <div class="mb-10">
        <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter">Withdraw Requests</h3>
        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.3em] mt-2">Manage and process organizer payout requests.</p>
    </div>

    <!-- Requests Table -->
    <div class="bg-white rounded-[3rem] shadow-premium border border-white overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
            <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Pending Payouts</h3>
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Awaiting Action</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/20 text-[10px] font-black tracking-widest text-slate-400 uppercase border-b border-slate-50">
                        <th class="px-8 py-5">Organizer</th>
                        <th class="px-8 py-5">Amount</th>
                        <th class="px-8 py-5">Details</th>
                        <th class="px-8 py-5">Request Date</th>
                        <th class="px-8 py-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium text-sm">
                    @if($requests->count() > 0)
                        @foreach($requests as $request)
                        <tr class="hover:bg-primary/5 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center overflow-hidden">
                                        @if($request->user->avatar)
                                            <img loading="lazy" src="{{ asset('storage/' . $request->user->avatar) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-user-tie text-slate-300"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black text-dark leading-none mb-1">{{ $request->user->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $request->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="font-black text-primary text-lg">৳{{ number_format($request->amount, 2) }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-dark">{{ $request->method }}</span>
                                    <span class="text-[10px] text-slate-400 mt-1 max-w-[200px] truncate" title="{{ $request->account_details }}">{{ $request->account_details }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-[11px] font-bold text-slate-500 uppercase tracking-widest">{{ $request->created_at->format('M d, Y • h:i A') }}</td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <button @click="showRejectModal = true; selectedId = {{ $request->id }}; selectedAmount = '{{ $request->amount }}'; selectedUser = '{{ $request->user->name }}'" 
                                            class="px-4 py-2 rounded-xl bg-red-50 text-red-500 text-[10px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all">
                                        Reject
                                    </button>
                                    <button @click="showApproveModal = true; selectedId = {{ $request->id }}; selectedAmount = '{{ $request->amount }}'; selectedUser = '{{ $request->user->name }}'" 
                                            class="px-5 py-2.5 rounded-xl bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20">
                                        Approve & Pay
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4 opacity-30">
                                <i class="fas fa-hand-holding-usd text-6xl text-slate-200"></i>
                                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">No pending requests at the moment.</p>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
        <div class="p-8 border-t border-slate-50">
            {{ $requests->links() }}
        </div>
        @endif
    </div>

    <!-- Approve Modal -->
    <div x-show="showApproveModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-dark/60 backdrop-blur-sm" x-cloak>
        <div class="bg-white rounded-[3rem] w-full max-w-lg overflow-hidden shadow-2xl animate-fadeInUp" @click.away="showApproveModal = false">
            <div class="p-10 border-b border-slate-50 bg-emerald-50/30 flex items-center justify-between">
                <div>
                    <h3 class="font-outfit text-2xl font-black text-emerald-600 tracking-tight">Approve Payout</h3>
                    <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest mt-1">Confirm payment to <span x-text="selectedUser"></span></p>
                </div>
            </div>

            <form :action="'{{ url('admin/payout') }}/' + selectedId + '/approve'" method="POST" class="p-10 space-y-6" id="approveForm">
                @csrf
                <div class="p-6 bg-emerald-50 rounded-2xl border border-emerald-100 mb-6">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Payout Amount</span>
                        <span class="text-2xl font-black text-emerald-700">৳<span x-text="selectedAmount"></span></span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Transaction ID / Reference</label>
                    <input type="text" name="transaction_id" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none focus:border-emerald-500/30 focus:bg-white transition-all text-dark font-black text-sm" placeholder="e.g. TR-88229911">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Admin Notes (Optional)</label>
                    <textarea name="admin_notes" rows="2" class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-6 outline-none focus:border-emerald-500/30 focus:bg-white transition-all text-dark font-medium text-sm" placeholder="Any private or public note for the organizer..."></textarea>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" @click="showApproveModal = false" class="flex-1 px-8 py-5 rounded-2xl bg-slate-100 text-slate-600 font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all">Cancel</button>
                    <button type="button" @click="confirmApprove()" class="flex-[2] bg-emerald-500 text-white px-8 py-5 rounded-2xl font-black text-[10px] tracking-widest uppercase hover:bg-emerald-600 transition-all shadow-xl shadow-emerald-500/20">Confirm Payout</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reject Modal -->
    <div x-show="showRejectModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-dark/60 backdrop-blur-sm" x-cloak>
        <div class="bg-white rounded-[3rem] w-full max-w-lg overflow-hidden shadow-2xl animate-fadeInUp" @click.away="showRejectModal = false">
            <div class="p-10 border-b border-slate-50 bg-red-50/30 flex items-center justify-between">
                <div>
                    <h3 class="font-outfit text-2xl font-black text-red-600 tracking-tight">Reject Request</h3>
                    <p class="text-[10px] text-red-500 font-bold uppercase tracking-widest mt-1">Declining payout for <span x-text="selectedUser"></span></p>
                </div>
            </div>

            <form :action="'{{ url('admin/payout') }}/' + selectedId + '/reject'" method="POST" class="p-10 space-y-6" id="rejectForm">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Reason for Rejection</label>
                    <textarea name="admin_notes" required rows="4" class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-6 outline-none focus:border-red-500/30 focus:bg-white transition-all text-dark font-medium text-sm" placeholder="Please explain why the request is being rejected..."></textarea>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" @click="showRejectModal = false" class="flex-1 px-8 py-5 rounded-2xl bg-slate-100 text-slate-600 font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all">Cancel</button>
                    <button type="submit" class="flex-[2] bg-red-500 text-white px-8 py-5 rounded-2xl font-black text-[10px] tracking-widest uppercase hover:bg-red-600 transition-all shadow-xl shadow-red-500/20">Confirm Rejection</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmApprove() {
        Swal.fire({
            title: 'Confirm Payment?',
            text: "Are you sure you have transferred the funds to the organizer?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#10B981',
            cancelButtonColor: '#64748B',
            confirmButtonText: 'Yes, Paid!',
            cancelButtonText: 'Not Yet',
            borderRadius: '2rem',
            customClass: {
                popup: 'rounded-[2rem] font-bold',
                title: 'font-black tracking-tight',
                confirmButton: 'rounded-xl font-black uppercase text-xs tracking-widest',
                cancelButton: 'rounded-xl font-black uppercase text-xs tracking-widest'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('approveForm').submit();
            }
        });
    }

    @if(session('success'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        Toast.fire({
            icon: 'success',
            title: "{{ session('success') }}"
        });
    @endif

    @if(session('error'))
        const ToastErr = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        ToastErr.fire({
            icon: 'error',
            title: "{{ session('error') }}"
        });
    @endif
</script>
@endpush
@endsection
