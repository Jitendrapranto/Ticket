<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit About Hero | Ticket Kinun Admin</title>
    <style>html { visibility: hidden; opacity: 0; } html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }</style>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#520C6B', 'primary-dark': '#1B2B46', secondary: '#1B2B46', accent: '#FF7D52', dark: '#0F172A' },
                    fontFamily: { outfit: ['Arial', 'Helvetica', 'sans-serif'], plus: ['Arial', 'Helvetica', 'sans-serif'] },
                }
            }
        }
    </script>
    <script>document.addEventListener('DOMContentLoaded', () => document.documentElement.classList.add('ready')); setTimeout(() => document.documentElement.classList.add('ready'), 100);</script>
</head>
<body class="bg-[#F1F5F9] text-slate-800 font-plus"
      x-data="{
          badgeText:   '{{ old('badge_text', $hero->badge_text) }}',
          titleMain:   '{{ old('title_main', $hero->title_main) }}',
          titleAccent: '{{ old('title_accent', $hero->title_accent) }}',
          subtitle:    `{{ old('subtitle', $hero->subtitle) }}`,
          successModal: {{ session('success') ? 'true' : 'false' }},
      }">

    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <!-- Header -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">About Hero Section</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">About Page / Edit Hero</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-xs font-black tracking-widest hover:bg-slate-200 transition-all uppercase">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
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
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title — White Part</label>
                                    <input type="text" name="title_main" x-model="titleMain"
                                           class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title — Accent Part</label>
                                    <input type="text" name="title_accent" x-model="titleAccent"
                                           class="w-full bg-slate-50 border border-slate-200 text-primary rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-black">
                                    <p class="text-[10px] text-slate-400 mt-1.5 font-medium">Displayed in the accent colour (#FF7D52)</p>
                                </div>
                            </div>

                            <div>
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
                                <div class="inline-block px-3 py-1 rounded-full bg-white/10 border border-white/10 mb-4">
                                    <span class="text-[#FF7D52] font-black text-[9px] tracking-[0.2em] uppercase" x-text="badgeText || 'ABOUT US'"></span>
                                </div>
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

    <!-- Success Modal -->
    <div x-show="successModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="successModal = false"></div>
        <div class="relative bg-white rounded-3xl p-10 max-w-sm w-full shadow-2xl text-center"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
            <div class="w-20 h-20 bg-green-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check-circle text-green-500 text-4xl"></i>
            </div>
            <h3 class="font-outfit font-black text-dark text-2xl mb-2">Updated!</h3>
            <p class="text-slate-400 text-sm font-medium mb-8">The About Hero section is now live on the about page.</p>
            <div class="flex gap-3">
                <button @click="successModal = false" class="flex-1 py-3.5 bg-slate-100 text-slate-600 font-black text-xs tracking-widest uppercase rounded-2xl hover:bg-slate-200 transition-all">Close</button>
                <a href="{{ route('about') }}" target="_blank" class="flex-1 py-3.5 bg-primary text-white font-black text-xs tracking-widest uppercase rounded-2xl hover:bg-secondary transition-all text-center">View Page</a>
            </div>
        </div>
    </div>
</body>
</html>
