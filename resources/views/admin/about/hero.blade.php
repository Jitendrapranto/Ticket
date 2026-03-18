@extends('admin.dashboard')

@section('admin_content')
<div x-data="{
          titleMain:   '{{ old('title_main', $hero->title_main) }}',
          titleAccent: '{{ old('title_accent', $hero->title_accent) }}',
          subtitle:    `{{ old('subtitle', $hero->subtitle) }}`,
      }">

    

    <div class="animate-fadeIn">
        <!-- Header -->
        <header class="mb-8 flex items-center justify-between shrink-0">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">About Hero Section</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">About Page / Edit Hero</p>
            </div>
            
        </header>

        <main class="p-8 flex-1">
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-2xl p-5 mb-6 flex items-start gap-4">
                <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                <ul class="text-sm text-red-600 font-semibold space-y-1">
                    @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Form -->
                <div class="lg:col-span-2">
                    <form action="{{ route('admin.about.hero.update') }}" method="POST" class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                        @csrf
                        @method('PUT')

                        <div class="p-10 space-y-8">
                            <h3 class="font-outfit text-lg font-black text-dark border-b border-slate-100 pb-4">
                                <i class="fas fa-image mr-2 text-primary"></i> Hero Content
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="text-left">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title — White Part</label>
                                    <input type="text" name="title_main" x-model="titleMain"
                                           class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                                </div>
                                <div class="text-left">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title — Accent Part</label>
                                    <input type="text" name="title_accent" x-model="titleAccent"
                                           class="w-full bg-slate-50 border border-slate-200 text-primary rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-black">
                                    <p class="text-[10px] text-slate-400 mt-1.5 font-medium text-left">Displayed in the accent colour (#FF7D52)</p>
                                </div>
                            </div>

                            <div class="text-left">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Subtitle / Description</label>
                                <textarea name="subtitle" rows="4" x-model="subtitle"
                                          class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-medium text-sm resize-none"></textarea>
                            </div>
                        </div>

                        <div class="bg-slate-50 p-8 border-t border-slate-100 flex justify-end">
                            <button type="submit" class="bg-primary text-white px-8 py-4 rounded-xl font-black tracking-widest uppercase hover:bg-secondary transition-all shadow-lg hover:shadow-primary/20">
                                <i class="fas fa-save mr-2"></i> Update Hero Section
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Live Preview -->
                <div class="lg:col-span-1">
                    <div class="sticky top-28">
                        <p class="text-xs font-black text-dark uppercase tracking-widest mb-4">Live Preview</p>
                        <div class="rounded-3xl overflow-hidden relative bg-gradient-to-r from-[#520C6B] to-[#1B2B46] min-h-[260px] flex items-center justify-center p-8">
                            <!-- Glows -->
                            <div class="absolute top-0 right-0 w-40 h-40 bg-primary/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-[#FF7D52]/10 rounded-full blur-2xl translate-y-1/2 -translate-x-1/4"></div>

                            <div class="relative z-10 text-center">
                                <h1 class="font-outfit font-black text-white text-2xl leading-tight tracking-tighter mb-3">
                                    <span x-text="titleMain || 'The Story'"></span><br>
                                    <span class="text-[#FF7D52]" x-text="titleAccent || 'Behind Kinun.'"></span>
                                </h1>
                                <p class="text-slate-400 text-xs font-light leading-relaxed max-w-xs" x-text="subtitle || 'Subtitle appears here...'"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>


</div>
@endsection
