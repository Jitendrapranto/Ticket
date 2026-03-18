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
            <button @click="showModal = true" class="bg-primary text-white px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-secondary transition-all shadow-xl shadow-primary/20 active:scale-95">
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
        
        <div class="bg-white rounded-[3rem] w-full max-w-md overflow-hidden shadow-2xl"
             @click.away="showModal = false"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-90 translate-y-10"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            
            <div class="p-6 border-b border-slate-100 bg-white flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-[1rem] bg-primary/5 text-primary flex items-center justify-center text-lg shadow-inner border border-primary/10">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                    <div>
                        <h3 class="font-outfit text-2xl font-black text-dark tracking-tighter">New Withdrawal</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Submit your payout details below.</p>
                    </div>
                </div>
                <button @click="showModal = false" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-400 hover:text-red-500 hover:bg-red-50 hover:border-red-100 transition-all shadow-sm">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('organizer.payout.requests.store') }}" method="POST" class="p-6 bg-slate-50/30">
                @csrf
                
                <div class="bg-indigo-50/50 border border-indigo-100 rounded-2xl p-4 mb-5 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-500 flex items-center justify-center text-[10px]">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <span class="text-[11px] font-black text-indigo-900 tracking-wide uppercase">Available Balance</span>
                    </div>
                    <span class="font-black text-indigo-700 text-lg tracking-tight">৳{{ number_format($availableBalance, 2) }}</span>
                </div>

                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2">Withdraw Amount</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center text-primary font-black text-sm border border-slate-200">৳</span>
                            </div>
                            <input type="number" name="amount" required step="0.01" max="{{ $availableBalance }}"
                                   class="w-full bg-white border border-slate-200 rounded-2xl py-3 pl-14 pr-5 outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-dark font-black text-base shadow-sm placeholder:text-slate-300 placeholder:font-medium"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2">Payment Method</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                <i class="fas fa-building-columns text-slate-400"></i>
                            </div>
                            <select name="method" required class="w-full bg-white border border-slate-200 rounded-2xl py-3 pl-12 pr-10 outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-dark font-bold text-sm appearance-none cursor-pointer shadow-sm">
                                <option value="" disabled selected>Select a method...</option>
                                @foreach($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod->name }}">{{ $paymentMethod->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2">Account Details</label>
                        <div class="relative">
                            <div class="absolute top-4 left-6 pointer-events-none">
                                <i class="fas fa-file-invoice text-slate-400"></i>
                            </div>
                            <textarea name="account_details" rows="2" required
                                      class="w-full bg-white border border-slate-200 rounded-2xl py-3 pl-14 pr-6 outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-dark font-medium text-sm shadow-sm placeholder:text-slate-300 leading-relaxed"
                                      placeholder="e.g. Dutch Bangla Bank, AC: 102.XXXX.XXXX"></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-slate-100">
                    <button type="submit" class="w-full relative overflow-hidden group bg-dark text-white py-3 rounded-2xl font-black text-xs tracking-[0.2em] uppercase hover:bg-primary transition-all shadow-xl shadow-dark/20 active:scale-95">
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            <i class="fas fa-paper-plane group-hover:-translate-y-1 transition-transform"></i>
                            Submit Withdraw Request
                        </span>
                        <div class="absolute inset-0 h-full w-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                    </button>
                    <p class="text-center text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-4 flex items-center justify-center gap-2">
                        <i class="fas fa-shield-alt text-emerald-500"></i> Securely encrypted & processed within 48h.
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
