@extends('admin.dashboard')

@section('admin_content')
<div>
    <div class="animate-fadeIn">
        <header class="mb-8 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.about.statistics.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white text-dark hover:bg-slate-50 transition-all border border-slate-100 shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Create Statistic</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Add new data-point to about us section</p>
                </div>
            </div>
        </header>

        <main class="max-w-4xl mx-auto">
            <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-50 overflow-hidden text-left">
                <form action="{{ route('admin.about.statistics.store') }}" method="POST" class="p-10 space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3 text-left">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Value (e.g. 400+)</label>
                            <input type="text" name="value" value="{{ old('value') }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="400+" required>
                            @error('value')<p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-3 text-left">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Label (e.g. PARTNERS)</label>
                            <input type="text" name="label" value="{{ old('label') }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="GLOBAL PARTNERS" required>
                            @error('label')<p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3 text-left">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">FontAwesome Icon</label>
                            <div class="relative group">
                                <i class="fas fa-icons absolute left-6 top-1/2 -translate-y-1/2 text-primary/30"></i>
                                <input type="text" name="icon" value="{{ old('icon', 'fas fa-chart-line') }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 pl-14 pr-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="fas fa-star" required>
                            </div>
                            @error('icon')<p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-3 text-left" x-data="{ color: '{{ old('color', '#520C6B') }}' }">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Accent Color</label>
                            <div class="flex items-center gap-3">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden border border-slate-100 shadow-sm shrink-0">
                                    <input type="color" name="color" x-model="color" class="w-full h-full cursor-pointer scale-150 border-none">
                                </div>
                                <input type="text" x-model="color" class="flex-1 bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-mono text-xs font-bold uppercase">
                            </div>
                            @error('color')<p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="space-y-3 text-left">
                        <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm">
                        @error('sort_order')<p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p>@enderror
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400">Fields marked with required must be filled.</p>
                        <button type="submit" class="bg-gradient-to-r from-primary to-primary-dark text-white px-12 py-5 rounded-[1.5rem] font-black text-xs tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all active:scale-95 uppercase">
                            Save Statistic
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
