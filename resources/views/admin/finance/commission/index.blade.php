@extends('admin.dashboard')

@section('admin_content')
<div class="animate-fadeIn">
    <!-- Page Header -->
    <div class="mb-10 flex justify-between items-end">
        <div>
            <h1 class="font-outfit text-3xl font-black text-dark tracking-tight mb-2">Commission <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Settings.</span></h1>
            <p class="text-slate-400 font-medium text-sm">Configure how much commission you earn per ticket sale.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-8 p-6 bg-emerald-50 border border-emerald-100 rounded-[1.5rem] flex items-center gap-4 text-emerald-700">
        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-lg">
            <i class="fas fa-check"></i>
        </div>
        <div>
            <h4 class="font-black text-sm uppercase">Success</h4>
            <p class="text-xs font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.finance.commission.update') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-8">
                <div class="bg-white rounded-[2rem] p-8 shadow-premium border border-slate-50">
                    <h3 class="font-outfit text-xl font-black text-dark tracking-tight mb-6 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center text-sm"><i class="fas fa-percentage"></i></span>
                        Commission Model
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 mb-2 block uppercase tracking-widest">Revenue Model</label>
                            <select name="revenue_model" class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm">
                                <option value="percentage" {{ ($setting->revenue_model ?? 'percentage') == 'percentage' ? 'selected' : '' }}>Percentage of Ticket Price (%)</option>
                                <option value="fixed" {{ ($setting->revenue_model ?? 'percentage') == 'fixed' ? 'selected' : '' }}>Fixed Amount per Ticket (৳)</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-bold text-slate-500 mb-2 block uppercase tracking-widest">Percentage (%)</label>
                                <input type="number" step="0.01" name="default_percentage" value="{{ $setting->default_percentage ?? '10.00' }}" class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-black text-xl text-center placeholder:text-slate-300">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 mb-2 block uppercase tracking-widest">Fixed Amount (৳)</label>
                                <input type="number" step="0.01" name="fixed_amount" value="{{ $setting->fixed_amount ?? '0.00' }}" class="w-full bg-slate-50 border border-slate-100 rounded-xl py-4 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-black text-xl text-center placeholder:text-slate-300">
                            </div>
                        </div>
                        <div class="pt-4 border-t border-slate-100">
                            <label class="flex items-center gap-4 cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" name="is_active" class="sr-only peer" {{ ($setting->is_active ?? true) ? 'checked' : '' }}>
                                    <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary"></div>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-dark group-hover:text-primary transition-colors uppercase tracking-tight">Apply Commission</p>
                                    <p class="text-[10px] font-bold text-slate-400 mt-0.5">If disabled, the platform will earn 0% from organizers.</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="bg-white/50 backdrop-blur-sm rounded-[2rem] p-4 shadow-sm border border-slate-100">
                    <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl text-xs font-black tracking-widest hover:bg-dark hover:-translate-y-1 transition-all uppercase shadow-xl shadow-primary/20 flex justify-center items-center gap-2">
                        Save System Configuration <i class="fas fa-save shadow-sm"></i>
                    </button>
                </div>
            </div>
            
            <!-- Side Info Card -->
            <div class="hidden lg:block">
                 <div class="bg-secondary text-white rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
                     <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                     <div class="relative z-10">
                         <h3 class="text-2xl font-black mb-6">Revenue <span class="text-primary italic">Intelligence</span></h3>
                         <div class="space-y-6">
                             <div class="flex gap-4">
                                 <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0"><i class="fas fa-shield-halved"></i></div>
                                 <p class="text-[11px] text-white/60 font-medium leading-relaxed">System-wide commission settings apply to all organizers unless a custom agreement is set via individual contracts.</p>
                             </div>
                             <div class="flex gap-4">
                                 <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0"><i class="fas fa-bolt"></i></div>
                                 <p class="text-[11px] text-white/60 font-medium leading-relaxed">Changes reflected instantly in the checkout process for all new bookings.</p>
                             </div>
                         </div>
                     </div>
                 </div>
            </div>
        </div>
    </form>
</div>
@endsection
