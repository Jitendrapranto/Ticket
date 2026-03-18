@extends('admin.dashboard')

@section('admin_content')
<div class="animate-fadeIn" 
     x-data="{
          heading:          '{{ old('heading', $cta->heading ?? 'Your Journey Starts Now.') }}',
          headingHighlight: '{{ old('heading_highlight', $cta->heading_highlight ?? 'Starts Now.') }}',
          description:      '{{ old('description', $cta->description ?? '') }}',
          buttonText:       '{{ old('button_text', $cta->button_text ?? 'Join as a Organizer') }}',
          buttonUrl:        '{{ old('button_url', $cta->button_url ?? '/organizer/register') }}',
          buttonBg:         '{{ old('button_bg_color', $cta->button_bg_color ?? '#FFE700') }}',
          buttonTextColor:  '{{ old('button_text_color', $cta->button_text_color ?? '#1B2B46') }}',
          bgImageUrl:       '{{ old('bg_image_url', $cta->bg_image_url ?? '') }}',
     }">
    
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 shrink-0">
        <div>
            <h1 class="font-outfit text-4xl font-black text-dark tracking-tighter mb-1">CTA <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Section.</span></h1>
            <p class="text-slate-400 font-bold uppercase text-[9px] tracking-[0.4em]">Homepage Configuration • Conversion Hub</p>
        </div>
    </div>



    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-2xl p-5 mb-6 flex items-start gap-4 shadow-sm">
        <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
        <ul class="text-xs text-red-600 font-bold space-y-1">
            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Area -->
        <div class="lg:col-span-2">
            <form action="{{ route('admin.home.cta.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Content Card -->
                <div class="bg-white rounded-[2.5rem] p-10 shadow-premium border border-slate-50 space-y-8">
                    <h3 class="font-outfit font-black text-dark text-xl flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center"><i class="fas fa-edit text-sm"></i></span>
                        Editorial Content
                    </h3>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Main Heading <span class="text-primary">*</span></label>
                            <input type="text" name="heading" x-model="heading"
                                   class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary/20 transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Highlighted Part of Heading</label>
                            <input type="text" name="heading_highlight" x-model="headingHighlight"
                                   placeholder="e.g. Starts Now."
                                   class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary/20 transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Description Context</label>
                            <textarea name="description" x-model="description" rows="4"
                                      class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary/20 transition-all resize-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Background Asset URL</label>
                            <input type="url" name="bg_image_url" x-model="bgImageUrl" placeholder="https://..."
                                   class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary/20 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Action Card -->
                <div class="bg-white rounded-[2.5rem] p-10 shadow-premium border border-slate-50 space-y-8">
                    <h3 class="font-outfit font-black text-dark text-xl flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-accent/5 text-accent flex items-center justify-center"><i class="fas fa-mouse-pointer text-sm"></i></span>
                        Call to Action
                    </h3>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Button Identity <span class="text-primary">*</span></label>
                            <input type="text" name="button_text" x-model="buttonText"
                                   class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary/20 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Target Endpoint <span class="text-primary">*</span></label>
                            <input type="text" name="button_url" x-model="buttonUrl"
                                   class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary/20 transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Atmosphere Color</label>
                            <div class="flex items-center gap-3 p-1 bg-slate-50 border border-slate-100 rounded-2xl">
                                <input type="color" name="button_bg_color" x-model="buttonBg" class="w-14 h-12 rounded-xl border-none cursor-pointer bg-transparent">
                                <input type="text" x-model="buttonBg" class="flex-1 bg-transparent border-none text-sm font-black text-dark uppercase tracking-widest focus:ring-0">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Text Contrast</label>
                            <div class="flex items-center gap-3 p-1 bg-slate-50 border border-slate-100 rounded-2xl">
                                <input type="color" name="button_text_color" x-model="buttonTextColor" class="w-14 h-12 rounded-xl border-none cursor-pointer bg-transparent">
                                <input type="text" x-model="buttonTextColor" class="flex-1 bg-transparent border-none text-sm font-black text-dark uppercase tracking-widest focus:ring-0">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white/50 backdrop-blur-sm rounded-[2rem] p-4 shadow-sm border border-slate-100">
                    <button type="submit" class="w-full py-5 bg-primary text-white font-black text-xs tracking-[0.2em] uppercase rounded-2xl hover:bg-dark transition-all shadow-xl shadow-primary/20 flex items-center justify-center gap-3">
                        <i class="fas fa-save shadow-sm"></i> Synchronize Assets
                    </button>
                </div>
            </form>
        </div>

        <!-- Real-Time Simulator -->
        <div class="lg:col-span-1">
            <div class="sticky top-4">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.4em] mb-4">Signal Simulator</p>
                <div class="rounded-[2.5rem] overflow-hidden relative shadow-2xl min-h-[400px] flex flex-col items-center justify-center"
                     :style="bgImageUrl ? 'background-image: url(' + bgImageUrl + '); background-size: cover; background-position: center;' : 'background-color: #520C6B;'">
                    <div class="absolute inset-0 bg-[#1B2B46]/80 backdrop-blur-[2px]"></div>
                    <div class="relative z-10 p-10 text-center flex flex-col items-center gap-8 w-full">
                        <h2 class="font-outfit text-4xl font-black leading-tight tracking-tighter" style="color: #FFE700;">
                            <template x-if="headingHighlight && heading.includes(headingHighlight)">
                                <span x-html="heading.replace(headingHighlight, '<span style=\'color:#FFE700\'>' + headingHighlight + '</span>').replace(heading.replace(headingHighlight,''), '<span class=\'text-white\'>' + heading.replace(headingHighlight,'') + '</span>')"></span>
                            </template>
                            <template x-if="!headingHighlight || !heading.includes(headingHighlight)">
                                <span class="text-white" x-text="heading || 'Your Journey Starts Now.'"></span>
                            </template>
                        </h2>
                        <p class="text-white/60 text-xs font-bold leading-relaxed tracking-wide" x-text="description || 'CTA description appears here in real-time simulation context...'"></p>
                        <button class="px-10 py-5 rounded-2xl font-black text-xs tracking-widest transition-all shadow-xl uppercase"
                                :style="'background-color:' + buttonBg + '; color:' + buttonTextColor"
                                x-text="buttonText || 'Button Label'"></button>
                    </div>
                </div>
                <div class="mt-6 bg-secondary text-white rounded-3xl p-6 shadow-premium">
                    <p class="text-[8px] font-black text-white/40 uppercase tracking-[0.3em] mb-2">Internal Routing</p>
                    <p class="text-xs font-black tracking-tight" x-text="buttonUrl || '/'"></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
