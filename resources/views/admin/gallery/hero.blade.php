@extends('admin.dashboard')

@section('admin_content')
<div>


    <!-- Sidebar Inclusion -->
    

    <!-- Main Content Wrapper -->
    <div class="animate-fadeIn">

        <!-- Header / Topbar -->
        

        <!-- Main Content -->
        <main class="p-8 flex-1">
            <div class="max-w-4xl mx-auto">

                <div class="bg-white rounded-[3rem] shadow-premium border border-slate-50 overflow-hidden animate-fadeInUp">
                    <div class="p-10 border-b border-slate-50 bg-slate-50/30 flex items-center justify-between">
                        <div>
                            <h3 class="font-outfit text-2xl font-black text-dark tracking-tight">Gallery Visual Hub</h3>
                            <p class="text-slate-400 text-sm font-medium mt-2">Craft the narrative for the moments captured in motion.</p>
                        </div>
                        <div class="w-16 h-16 rounded-[1.5rem] bg-primary/5 flex items-center justify-center text-primary text-2xl animate-pulse">
                            <i class="fas fa-images"></i>
                        </div>
                    </div>

                    <form action="{{ route('admin.gallery.hero.update') }}" method="POST" class="p-10 space-y-8">
                        @csrf

                        <!-- Badge -->
                        <div class="space-y-3 text-left">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Badge Headline</label>
                            <div class="relative group">
                                <i class="fas fa-tag absolute left-6 top-1/2 -translate-y-1/2 text-primary/30 group-focus-within:text-primary transition-colors"></i>
                                <input type="text" name="badge_text" value="{{ $hero->badge_text }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 pl-14 pr-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-black text-sm" placeholder="e.g. VISUAL JOURNEY">
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="space-y-3 text-left">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Dramatic Title</label>
                            <div class="relative group">
                                <i class="fas fa-heading absolute left-6 top-1/2 -translate-y-1/2 text-primary/30 group-focus-within:text-primary transition-colors"></i>
                                <input type="text" name="title" value="{{ $hero->title }}" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 pl-14 pr-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-black text-sm" placeholder="e.g. Moments In Motion.">
                            </div>
                            <p class="text-[9px] text-slate-400 ml-4 font-medium">* Tip: Use a period at the end for a punchy, cinematic feel.</p>
                        </div>

                        <!-- Subtitle -->
                        <div class="space-y-3 text-left">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Story Narrative (Subtitle)</label>
                            <div class="relative group">
                                <textarea name="subtitle" rows="5" class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] p-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-medium text-sm leading-relaxed" placeholder="Share the essence of these captured memories...">{{ $hero->subtitle }}</textarea>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-8 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-between gap-6">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Live Sync Ready</p>
                            </div>
                            <button type="submit" class="w-full sm:w-auto bg-primary text-white px-12 py-5 rounded-[1.5rem] font-black text-[11px] tracking-[0.2em] shadow-lg shadow-primary/20 hover:bg-dark hover:-translate-y-1 hover:shadow-2xl hover:shadow-primary/30 transition-all active:scale-95 uppercase flex items-center justify-center gap-3 group">
                                <i class="fas fa-paper-plane text-[10px] group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i> 
                                Update Hero Section
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Interactive Preview -->
                <div class="mt-12 bg-dark rounded-[3.5rem] p-16 text-white relative overflow-hidden group border border-white/5 shadow-2xl">
                    <div class="absolute inset-0 bg-primary/10"></div>
                    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/20 rounded-full blur-[120px] translate-x-1/4 -translate-y-1/4"></div>

                    <div class="max-w-xl relative z-10 text-center mx-auto sm:text-left sm:mx-0">
                        <div class="inline-block px-5 py-2 rounded-full border border-white/10 bg-white/5 mb-8 animate-bounce">
                            <span class="text-accent font-black text-[10px] tracking-[0.3em] uppercase">{{ $hero->badge_text }}</span>
                        </div>
                        <h1 class="font-outfit text-5xl font-black mb-8 tracking-tighter leading-tight">{{ $hero->title }}</h1>
                        <p class="text-slate-400 text-base font-light leading-relaxed max-w-md">{{ $hero->subtitle }}</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="p-8 text-center text-[10px] font-black text-slate-400 tracking-widest uppercase border-t border-slate-100 bg-white">
            Ticket Kinun • Alpha Control System V4.0.2 • © 2026
        </footer>
    </div>

    <!-- Mobile Sidebar Interaction Script -->
    
    <style>
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fadeInUp { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>

</div>
@endsection
