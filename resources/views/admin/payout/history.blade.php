@extends('admin.dashboard')

@section('admin_content')
<div class="p-8 animate-fadeIn">
    <!-- Header -->
    <div class="mb-10">
        <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter">Withdraw History</h3>
        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.3em] mt-2">Log of all processed and rejected payout requests.</p>
    </div>

    <!-- History Table -->
    <div class="bg-white rounded-[3rem] shadow-premium border border-white overflow-hidden relative">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
            <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Processed Payouts</h3>
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Master Audit Log</span>
            </div>
        </div>
        <div class="overflow-x-auto text-[11px]">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/20 text-[10px] font-black tracking-widest text-slate-400 uppercase border-b border-slate-50">
                        <th class="px-8 py-5">Organizer</th>
                        <th class="px-8 py-5">Amount</th>
                        <th class="px-8 py-5">Method</th>
                        <th class="px-8 py-5">Tx ID / Admin Notes</th>
                        <th class="px-8 py-5">Status</th>
                        <th class="px-8 py-5">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium">
                    @forelse($requests as $request)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center overflow-hidden">
                                     @if($request->user->avatar)
                                        <img src="{{ asset('storage/' . $request->user->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-user-tie text-[10px] text-slate-300"></i>
                                    @endif
                                </div>
                                <span class="font-black text-dark">{{ $request->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="font-black text-dark">৳{{ number_format($request->amount, 2) }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="font-bold text-dark">{{ $request->method }}</span>
                                <span class="text-[9px] text-slate-400 truncate max-w-[120px]">{{ $request->account_details }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @if($request->status == 'approved')
                                <div class="flex flex-col gap-1">
                                    <div class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded font-mono text-[9px] w-fit border border-emerald-100">{{ $request->transaction_id }}</div>
                                    @if($request->admin_notes)
                                        <span class="text-[9px] text-slate-400 italic">{{ Str::limit($request->admin_notes, 40) }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-red-400 italic text-[10px]">{{ Str::limit($request->admin_notes, 50) }}</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            @if($request->status == 'approved')
                                <span class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-[9px] font-black border border-emerald-100 uppercase tracking-widest">Approved</span>
                            @else
                                <span class="px-4 py-1.5 rounded-full bg-red-50 text-red-600 text-[9px] font-black border border-red-100 uppercase tracking-widest">Rejected</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-slate-500 uppercase font-bold text-[10px]">
                            {{ $request->processed_at ? $request->processed_at->format('M d, Y') : $request->updated_at->format('M d, Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4 opacity-20">
                                <i class="fas fa-history text-6xl text-slate-200"></i>
                                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Audit history is empty.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
        <div class="p-8 border-t border-slate-50">
            {{ $requests->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
