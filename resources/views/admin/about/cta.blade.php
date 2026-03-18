@extends('admin.dashboard')

@section('admin_content')
<div>
    <div class="animate-fadeIn">
        <header class="mb-8 flex items-center justify-between shrink-0">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Call To Action Section</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">About Page / Edit CTA</p>
            </div>
        </header>

        <main class="max-w-4xl mx-auto">
            <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-50 overflow-hidden text-left">
                <form action="{{ route('admin.about.cta.update') }}" method="POST" class="p-10 space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <h3 class="font-outfit text-lg font-black text-dark border-b border-slate-100 pb-4 text-left">
                            <i class="fas fa-bullhorn mr-2 text-primary"></i> Core Content
                        </h3>

                        <div class="space-y-5 text-left">
                            <div class="text-left">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Section Title</label>
                                <input type="text" name="title" value="{{ old('title', $cta->title) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="Ready to partner?" required>
                                @error('title') <p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p> @enderror
                            </div>

                            <div class="text-left">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Subtitle / Narrative</label>
                                <textarea name="subtitle" rows="3" class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] p-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-medium text-sm leading-relaxed" placeholder="Join our global network..." required>{{ old('subtitle', $cta->subtitle) }}</textarea>
                                @error('subtitle') <p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6 pt-6 border-t border-slate-50">
                        <h3 class="font-outfit text-lg font-black text-dark border-b border-slate-100 pb-4 text-left">
                            <i class="fas fa-link mr-2 text-accent"></i> Interaction configuration
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
                            <div class="text-left">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Button Label</label>
                                <input type="text" name="button_text" value="{{ old('button_text', $cta->button_text) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-black tracking-widest text-xs uppercase" placeholder="CONTACT US" required>
                                @error('button_text') <p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p> @enderror
                            </div>
                            <div class="text-left">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Button Destination (URL)</label>
                                <input type="text" name="button_url" value="{{ old('button_url', $cta->button_url) }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-blue-600 font-mono text-sm" placeholder="/contact" required>
                                @error('button_url') <p class="text-red-500 text-[10px] font-bold mt-1 ml-4">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400">Updates reflect instantly on the Live About Page.</p>
                        <button type="submit" class="bg-gradient-to-r from-primary to-primary-dark text-white px-12 py-5 rounded-[1.5rem] font-black text-xs tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all active:scale-95 uppercase">
                            Update CTA Section
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
