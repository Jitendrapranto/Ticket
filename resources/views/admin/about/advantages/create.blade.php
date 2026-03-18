@extends('admin.dashboard')

@section('admin_content')
<div>
    <div class="animate-fadeIn">
        <header class="mb-8 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.about.advantages.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white text-dark hover:bg-slate-50 transition-all border border-slate-100 shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Create Advantage</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Add new feature card to about us page</p>
                </div>
            </div>
        </header>

        <main class="max-w-4xl mx-auto">
            <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-50 overflow-hidden text-left">
                <form action="{{ route('admin.about.advantages.store') }}" method="POST" class="p-10 space-y-8">
                    @csrf
                    
                    <div class="space-y-3 text-left">
                        <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="e.g. Speed & Security" required>
                        @error('title')<p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-3 text-left">
                        <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Description</label>
                        <textarea name="description" rows="3" class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] p-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-medium text-sm leading-relaxed" placeholder="Briefly describe this advantage..." required>{{ old('description') }}</textarea>
                        @error('description')<p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3 text-left">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Icon (FontAwesome)</label>
                            <input type="text" name="icon" value="{{ old('icon', 'fas fa-shield-alt') }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-mono text-sm font-bold" placeholder="fas fa-star" required>
                            @error('icon')<p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-3 text-left">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Border Class (Optional)</label>
                            <input type="text" name="border_class" value="{{ old('border_class', 'border-slate-100') }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-mono text-sm font-bold" placeholder="border-primary/20">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t border-slate-50">
                        <div class="space-y-6">
                            <h4 class="text-[11px] font-black text-dark uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-primary"></span>
                                Theme Colors
                            </h4>
                            
                            <div class="grid grid-cols-1 gap-4">
                                <div class="flex items-center gap-4" x-data="{ color: '{{ old('card_bg_color', '#FFFFFF') }}' }">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden shadow-inner border border-slate-100 shrink-0">
                                        <input type="color" name="card_bg_color" x-model="color" class="w-full h-full scale-150 cursor-pointer">
                                    </div>
                                    <input type="text" x-model="color" class="flex-1 bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 text-xs font-mono font-bold uppercase transition-all focus:bg-white">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter w-20">Card BG</span>
                                </div>

                                <div class="flex items-center gap-4" x-data="{ color: '{{ old('icon_bg_color', '#520C6B') }}' }">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden shadow-inner border border-slate-100 shrink-0">
                                        <input type="color" name="icon_bg_color" x-model="color" class="w-full h-full scale-150 cursor-pointer">
                                    </div>
                                    <input type="text" x-model="color" class="flex-1 bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 text-xs font-mono font-bold uppercase transition-all focus:bg-white">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter w-20">Icon BG</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h4 class="text-[11px] font-black text-dark uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-accent"></span>
                                Text Colors
                            </h4>

                            <div class="grid grid-cols-1 gap-4">
                                <div class="flex items-center gap-4" x-data="{ color: '{{ old('title_color', '#1E293B') }}' }">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden shadow-inner border border-slate-100 shrink-0">
                                        <input type="color" name="title_color" x-model="color" class="w-full h-full scale-150 cursor-pointer">
                                    </div>
                                    <input type="text" x-model="color" class="flex-1 bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 text-xs font-mono font-bold uppercase transition-all focus:bg-white">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter w-20">Title</span>
                                </div>

                                <div class="flex items-center gap-4" x-data="{ color: '{{ old('desc_color', '#64748B') }}' }">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden shadow-inner border border-slate-100 shrink-0">
                                        <input type="color" name="desc_color" x-model="color" class="w-full h-full scale-150 cursor-pointer">
                                    </div>
                                    <input type="text" x-model="color" class="flex-1 bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 text-xs font-mono font-bold uppercase transition-all focus:bg-white">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter w-20">Desc</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 text-left">
                        <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm">
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400">Ensure all details are correct before saving.</p>
                        <button type="submit" class="bg-gradient-to-r from-primary to-primary-dark text-white px-12 py-5 rounded-[1.5rem] font-black text-xs tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all active:scale-95 uppercase">
                            Create Advantage
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
