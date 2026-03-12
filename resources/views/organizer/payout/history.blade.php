@extends('layouts.organizer')

@section('title', 'Withdraw History')
@section('header_title', 'Withdraw History')

@section('content')
<div class="p-8 animate-fadeInUp">
    <!-- History List -->
    <div class="bg-white rounded-[3rem] shadow-premium border border-white overflow-hidden relative">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
            <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Processed History</h3>
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Past Payouts</span>
            </div>
        </div>
        <div class="overflow-x-auto text-[11px]">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/20 text-[10px] font-black tracking-widest text-slate-400 uppercase border-b border-slate-50">
                        <th class="px-8 py-5">Request ID</th>
                        <th class="px-8 py-5">Amount</th>
                        <th class="px-8 py-5">Method</th>
                        <th class="px-8 py-5">Tx ID / Notes</th>
                        <th class="px-8 py-5">Status</th>
                        <th class="px-8 py-5">Processed Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium">
                    @forelse($requests as $request)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6 font-bold text-dark uppercase tracking-tighter">#WR-{{ $request->id }}</td>
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
                            @if($request->transaction_id)
                                <div class="px-3 py-1 bg-slate-100 rounded text-slate-600 font-mono text-[9px]">{{ $request->transaction_id }}</div>
                            @elseif($request->admin_notes)
                                <span class="text-slate-400 italic text-[10px]">{{ Str::limit($request->admin_notes, 30) }}</span>
                            @else
                                <span class="text-slate-300">---</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            @if($request->status == 'approved')
                                <span class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-[9px] font-black border border-emerald-100 uppercase tracking-widest">Completed</span>
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
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-200 text-2xl">
                                    <i class="fas fa-history"></i>
                                </div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Your history is currently empty.</p>
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
