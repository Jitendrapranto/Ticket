@extends('admin.dashboard')

@section('admin_content')
@include('admin.partials.stats')
<!-- Recent Transactions -->
<div class="bg-white rounded-[2.5rem] shadow-premium border border-white overflow-hidden">
    <div class="p-8 border-b border-slate-50 flex flex-col sm:flex-row items-center justify-between gap-4 bg-slate-50/20">
        <div>
            <h3 class="text-2xl font-black text-dark tracking-tight">Recent Transactions</h3>
        </div>
        <a href="{{ route('admin.finance.bookings.index') }}" class="px-8 py-3 bg-white border border-slate-100 rounded-xl text-xs font-black text-primary tracking-widest uppercase hover:bg-primary hover:text-white transition-all shadow-sm">View Audits</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/40 text-xs font-black tracking-widest text-slate-400 uppercase">
                    <th class="px-8 py-5 border-b border-slate-50">Event</th>
                    <th class="px-8 py-5 border-b border-slate-50">Identity</th>
                    <th class="px-8 py-5 border-b border-slate-50">Volume</th>
                    <th class="px-8 py-5 border-b border-slate-50">State</th>
                    <th class="px-8 py-5 border-b border-slate-50 text-right">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-base">
                @forelse($recentTransactions->take(4) as $transaction)
                <tr class="hover:bg-slate-50/80 transition-all duration-300 group cursor-pointer">
                    <td class="px-8 py-5">
                        <span class="text-base font-black text-dark block truncate max-w-[200px]">{{ $transaction->event->title ?? 'N/A' }}</span>
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-500 font-bold truncate max-w-[150px]">{{ $transaction->user->email ?? 'N/A' }}</td>
                    <td class="px-8 py-5">
                        <span class="font-black text-base text-primary">৳{{ number_format($transaction->total_amount, 0) }}</span>
                    </td>
                    <td class="px-8 py-5">
                        @php $st = $transaction->status; $cls = $st == 'confirmed' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : ($st == 'pending' ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-rose-50 text-rose-600 border-rose-100'); @endphp
                        <span class="px-3 py-1.5 {{ $cls }} text-[10px] font-black rounded-lg border uppercase tracking-widest">{{ $st }}</span>
                    </td>
                    <td class="px-8 py-5 text-right relative" x-data="{ open: false }">
                        <div class="flex items-center justify-end gap-3">
                            <span class="text-xs font-black text-dark uppercase tracking-tighter">{{ $transaction->created_at->diffForHumans() }}</span>
                            <button @click="open = !open" @click.away="open = false" 
                                class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white hover:border-primary transition-all duration-300 shadow-sm group/btn"
                                :class="open ? 'bg-primary text-white ring-4 ring-primary/10 border-primary' : ''">
                                <i class="fa-solid fa-ellipsis text-xs transition-transform group-hover/btn:rotate-90"></i>
                            </button>
                            
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                 class="absolute right-8 mt-3 w-64 bg-white rounded-[1.5rem] shadow-premium border border-slate-100 z-[60] overflow-hidden text-left" 
                                 style="display: none;">
                                <div class="p-3 space-y-1">
                                    <div class="px-3 py-2 mb-2 border-b border-slate-50">
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none mb-1">Transaction Actions</p>
                                        <p class="text-[10px] text-slate-300 font-bold italic truncate">#{{ $transaction->transaction_id ?? 'N/A' }}</p>
                                    </div>
                                    <a href="{{ route('admin.finance.bookings.index') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-black text-slate-600 hover:bg-primary/5 hover:text-primary rounded-xl transition-all group/item">
                                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center group-hover/item:bg-white transition-all shadow-sm">
                                            <i class="fas fa-receipt text-[12px]"></i>
                                        </div>
                                        <span>Full Audit View</span>
                                    </a>
                                    <a href="{{ $transaction->event ? route('events.show', $transaction->event->slug) : '#' }}" target="_blank" class="flex items-center gap-3 px-4 py-3 text-xs font-black text-slate-600 hover:bg-accent/5 hover:text-accent rounded-xl transition-all group/item">
                                        <div class="w-8 h-8 rounded-lg bg-accent/5 flex items-center justify-center group-hover/item:bg-white transition-all shadow-sm">
                                            <i class="fas fa-external-link-alt text-[10px]"></i>
                                        </div>
                                        <span>Live Preview</span>
                                    </a>
                                    @if($transaction->user_id)
                                    <div class="pt-1 mt-1 border-t border-slate-50">
                                        <a href="{{ route('admin.customers.show', $transaction->user_id) }}" class="flex items-center gap-3 px-4 py-3 text-xs font-black text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 rounded-xl transition-all group/item">
                                            <div class="w-8 h-8 rounded-lg bg-emerald-50/50 flex items-center justify-center group-hover/item:bg-white transition-all shadow-sm">
                                                <i class="fas fa-user-circle text-[12px]"></i>
                                            </div>
                                            <span>Customer Detail</span>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-14 text-center text-xs font-black text-slate-300 uppercase">System Idle - Waiting for Signal</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .animate-fadeIn { animation: fadeIn 0.6s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
