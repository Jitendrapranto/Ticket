@extends('admin.dashboard')

@section('admin_content')
<div x-data="{
    badgeText: '{{ old('badge_text', $hero->badge_text) }}',
    title: '{{ old('title', $hero->title) }}',
    subtitle: `{{ old('subtitle', $hero->subtitle) }}`,
    searchPlaceholder: '{{ old('search_placeholder', $hero->search_placeholder) }}'
}">
    
    <div class="animate-fadeIn">
        <main class="max-w-4xl mx-auto space-y-8 pb-10">
            <!-- Form Area -->
            <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-50 overflow-hidden">
                <div class="p-10 border-b border-slate-50 bg-slate-50/30 flex items-center justify-between">
                    <div>
                        <h3 class="font-outfit text-2xl font-black text-dark tracking-tight">Customize Events Hero</h3>
                        <p class="text-slate-400 text-sm font-medium mt-2">Modify the visual identity and messaging of the events discovery center.</p>
                    </div>
                    <a href="{{ route('events') }}" target="_blank" class="px-6 py-3 bg-white border border-slate-100 rounded-xl text-[10px] font-black text-primary tracking-widest uppercase hover:bg-primary hover:text-white transition-all shadow-sm flex items-center gap-2">
                        <i class="fas fa-external-link-alt text-[10px]"></i> Live Site
                    </a>
                </div>

                <form action="{{ route('admin.events.hero.update') }}" method="POST" class="p-10 space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Badge Text</label>
                            <div class="relative group">
                                <i class="fas fa-award absolute left-6 top-1/2 -translate-y-1/2 text-primary/30 group-focus-within:text-primary transition-colors"></i>
                                <input type="text" name="badge_text" x-model="badgeText" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 pl-14 pr-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm">
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Main Title</label>
                            <div class="relative group">
                                <i class="fas fa-font absolute left-6 top-1/2 -translate-y-1/2 text-primary/30 group-focus-within:text-primary transition-colors"></i>
                                <input type="text" name="title" x-model="title" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 pl-14 pr-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Subtitle / Description</label>
                        <div class="relative group">
                            <textarea name="subtitle" rows="4" x-model="subtitle" class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] p-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-medium text-sm leading-relaxed"></textarea>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Search Placeholder</label>
                        <div class="relative group">
                            <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-primary/30 group-focus-within:text-primary transition-colors"></i>
                            <input type="text" name="search_placeholder" x-model="searchPlaceholder" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 pl-14 pr-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400">Last updated: {{ $hero->updated_at ? $hero->updated_at->diffForHumans() : 'Never' }}</p>
                        <button type="submit" class="bg-gradient-to-r from-primary to-secondary text-white px-12 py-5 rounded-[1.5rem] font-black text-xs tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all uppercase">
                            Update Hero Section
                        </button>
                    </div>
                </form>
            </div>

            <!-- Preview Area -->
            <div class="bg-[#1B2B46] rounded-[3rem] p-12 text-white relative overflow-hidden border border-white/5 shadow-2xl">
                <span class="text-primary font-black tracking-[0.3em] text-[10px] uppercase mb-8 block opacity-40">Live Preview</span>
                <div class="max-w-xl relative z-10">
                    <div class="inline-block px-4 py-1.5 rounded-full border border-white/10 bg-white/5 mb-6">
                        <span class="text-primary font-black text-[10px] tracking-[0.2em] uppercase" x-text="badgeText || 'Discover'"></span>
                    </div>
                    <h1 class="font-outfit text-4xl font-black mb-4 tracking-tighter" x-text="title || 'Events Discovery'"></h1>
                    <p class="text-white/40 text-sm font-light leading-relaxed" x-text="subtitle"></p>
                    
                    <div class="mt-8 relative max-w-md">
                        <div class="bg-white/10 border border-white/10 rounded-2xl py-4 px-6 flex items-center gap-4">
                            <i class="fas fa-search text-white/20"></i>
                            <span class="text-white/20 text-xs font-medium" x-text="searchPlaceholder"></span>
                        </div>
                    </div>
                </div>
                <!-- Decorative element -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-primary/20 rounded-full blur-[100px] pointer-events-none"></div>
            </div>
        </main>
    </div>

</div>
@endsection
