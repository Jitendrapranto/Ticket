@extends('layouts.organizer')

@section('title', 'Withdraw Request')
@section('header_title', 'Withdraw Request')

@section('content')
<div class="p-8 animate-fadeInUp" x-data="{ showModal: false }">
    <!-- Financial Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
        <div class="bg-white rounded-[2.5rem] p-8 shadow-premium border border-slate-50 flex items-center justify-between group">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 rounded-2xl bg-primary/5 text-primary flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-wallet"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Available Balance</p>
                    <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter">৳{{ number_format($availableBalance, 2) }}</h3>
                </div>
            </div>
            <button @click="showModal = true" class="bg-primary text-white px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-primary-dark transition-all shadow-xl shadow-primary/20 active:scale-95">
                New Request
            </button>
        </div>

        <div class="bg-white rounded-[2.5rem] p-8 shadow-premium border border-slate-50 flex items-center group">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Net Earnings</p>
                    <h3 class="font-outfit text-3xl font-black text-dark tracking-tighter">৳{{ number_format($totalNetEarnings, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Requests List -->
    <div class="bg-white rounded-[3rem] shadow-premium border border-white overflow-hidden relative">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
            <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Active Withdraw Requests</h3>
            <span class="px-4 py-1.5 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest">{{ $requests->count() }} Pending</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/20 text-[10px] font-black tracking-widest text-slate-400 uppercase border-b border-slate-50">
                        <th class="px-8 py-5">Request ID</th>
                        <th class="px-8 py-5">Amount</th>
                        <th class="px-8 py-5">Method</th>
                        <th class="px-8 py-5">Status</th>
                        <th class="px-8 py-5">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium text-sm">
                    @forelse($requests as $request)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6 font-bold text-dark uppercase tracking-tighter">#WR-{{ $request->id }}</td>
                        <td class="px-8 py-6">
                            <span class="font-black text-primary">৳{{ number_format($request->amount, 2) }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-dark">{{ $request->method }}</span>
                                <span class="text-[9px] text-slate-400 truncate max-w-[150px]">{{ $request->account_details }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-4 py-1.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-black border border-amber-100 uppercase tracking-widest">{{ $request->status }}</span>
                        </td>
                        <td class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $request->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-200 text-2xl">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">No active requests found.</p>
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

    <!-- Request Modal -->
    <div x-show="showModal" 
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-dark/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak>
        
        <div class="bg-white rounded-[3rem] w-full max-w-lg overflow-hidden shadow-2xl"
             @click.away="showModal = false"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-90 translate-y-10"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            
            <div class="p-10 border-b border-slate-50 bg-slate-50/30 flex items-center justify-between">
                <div>
                    <h3 class="font-outfit text-2xl font-black text-dark tracking-tight">Request Widthdraw</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Submit your payout details below.</p>
                </div>
                <button @click="showModal = false" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-red-500 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('organizer.payout.requests.store') }}" method="POST" class="p-10 space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Withdraw Amount</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-primary font-black text-sm">৳</span>
                        <input type="number" name="amount" required step="0.01" max="{{ $availableBalance }}"
                               class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 pl-10 pr-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-black text-sm"
                               placeholder="0.00">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Payment Method</label>
                    <select name="method" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm appearance-none cursor-pointer">
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="bKash">bKash</option>
                        <option value="Nagad">Nagad</option>
                        <option value="Rocket">Rocket</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Account Details</label>
                    <textarea name="account_details" rows="3" required
                              class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-medium text-sm"
                              placeholder="Enter bank name, AC number, or mobile wallet number..."></textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-dark text-white py-5 rounded-2xl font-black text-xs tracking-[0.3em] uppercase hover:bg-primary transition-all shadow-xl active:scale-95">
                        Submit Request
                    </button>
                    <p class="text-center text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-6">Admin will process your request within 48 hours.</p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
