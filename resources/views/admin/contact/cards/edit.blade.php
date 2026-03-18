@extends('admin.dashboard')

@section('admin_content')
<div>
    <div class="animate-fadeIn">
        <header class="mb-8 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.contact.cards.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white text-dark hover:bg-slate-50 transition-all border border-slate-100 shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Edit Contact Card</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Update card: {{ $card->title }}</p>
                </div>
            </div>
        </header>

        <main class="max-w-4xl mx-auto">
            <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-50 overflow-hidden text-left">
                <form action="{{ route('admin.contact.cards.update', $card) }}" method="POST" class="p-10 space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-3 text-left">
                        <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Title</label>
                        <input type="text" name="title" value="{{ old('title', $card->title) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="e.g. Email Support" required>
                        @error('title')<p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-3 text-left">
                        <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Description</label>
                        <textarea name="description" rows="3" class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] p-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-medium text-sm leading-relaxed" placeholder="Tell users how you can help..." required>{{ old('description', $card->description) }}</textarea>
                        @error('description')<p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
                        <div class="space-y-3 text-left">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Action Label (Link Text)</label>
                            <input type="text" name="action_text" value="{{ old('action_text', $card->action_text) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="e.g. support@ticketkinun.com">
                            @error('action_text')<p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-3 text-left">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Action Link (URL)</label>
                            <input type="text" name="action_url" value="{{ old('action_url', $card->action_url) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-blue-600 font-mono text-sm" placeholder="mailto:support@ticketkinun.com">
                            @error('action_url')<p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
                        <div class="space-y-3 text-left">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Icon (FontAwesome)</label>
                            <input type="text" name="icon" value="{{ old('icon', $card->icon) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-mono text-sm font-bold" required>
                            @error('icon')<p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-3 text-left">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Sort Order</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $card->sort_order) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm">
                        </div>
                    </div>

                    <div class="pt-8 border-t border-slate-50">
                        <h4 class="text-[11px] font-black text-dark uppercase tracking-widest flex items-center gap-2 mb-8 ml-4">
                            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                            Design & Brand Colors
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                            <div class="flex items-center gap-4" x-data="{ color: '{{ old('bg_color', $card->bg_color) }}' }">
                                <div class="w-14 h-14 rounded-xl overflow-hidden shadow-inner border border-slate-100 shrink-0">
                                    <input type="color" x-model="color" @input="$refs.bgInput.value = color" class="w-full h-full scale-150 cursor-pointer">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-1">Card Background</label>
                                    <input type="text" name="bg_color" x-ref="bgInput" x-model="color" class="w-full bg-slate-50 border border-slate-100 rounded-xl py-2.5 px-4 text-xs font-mono font-bold uppercase transition-all focus:bg-white">
                                </div>
                            </div>

                            <div class="flex items-center gap-4" x-data="{ color: '{{ old('theme_color', $card->theme_color) }}' }">
                                <div class="w-14 h-14 rounded-xl overflow-hidden shadow-inner border border-slate-100 shrink-0">
                                    <input type="color" x-model="color" @input="$refs.themeInput.value = color" class="w-full h-full scale-150 cursor-pointer">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-1">Theme (Icon/Link)</label>
                                    <input type="text" name="theme_color" x-ref="themeInput" x-model="color" class="w-full bg-slate-50 border border-slate-100 rounded-xl py-2.5 px-4 text-xs font-mono font-bold uppercase transition-all focus:bg-white">
                                </div>
                            </div>

                            <div class="flex items-center gap-4" x-data="{ color: '{{ old('title_color', $card->title_color) }}' }">
                                <div class="w-14 h-14 rounded-xl overflow-hidden shadow-inner border border-slate-100 shrink-0">
                                    <input type="color" x-model="color" @input="$refs.titleInput.value = color" class="w-full h-full scale-150 cursor-pointer">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-1">Title Color</label>
                                    <input type="text" name="title_color" x-ref="titleInput" x-model="color" class="w-full bg-slate-50 border border-slate-100 rounded-xl py-2.5 px-4 text-xs font-mono font-bold uppercase transition-all focus:bg-white">
                                </div>
                            </div>

                            <div class="flex items-center gap-4" x-data="{ color: '{{ old('desc_color', $card->desc_color) }}' }">
                                <div class="w-14 h-14 rounded-xl overflow-hidden shadow-inner border border-slate-100 shrink-0">
                                    <input type="color" x-model="color" @input="$refs.descInput.value = color" class="w-full h-full scale-150 cursor-pointer">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-1">Description Color</label>
                                    <input type="text" name="desc_color" x-ref="descInput" x-model="color" class="w-full bg-slate-50 border border-slate-100 rounded-xl py-2.5 px-4 text-xs font-mono font-bold uppercase transition-all focus:bg-white">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-10 flex items-center justify-between">
                        <a href="{{ route('admin.contact.cards.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-dark transition-all">Cancel Update</a>
                        <button type="submit" class="bg-gradient-to-r from-primary to-primary-dark text-white px-12 py-5 rounded-[1.5rem] font-black text-xs tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all active:scale-95 uppercase">
                            Update Contact Card
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
