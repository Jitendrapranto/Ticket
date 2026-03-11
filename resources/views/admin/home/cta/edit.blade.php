<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home CTA Section | Ticket Kinun Admin</title>
    <style>html { visibility: hidden; opacity: 0; } html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }</style>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#520C6B', secondary: '#1B2B46', accent: '#FF7D52', dark: '#0F172A' },
                    fontFamily: { outfit: ['Arial', 'Helvetica', 'sans-serif'], plus: ['Arial', 'Helvetica', 'sans-serif'] },
                }
            }
        }
    </script>
    <script>document.addEventListener('DOMContentLoaded', () => document.documentElement.classList.add('ready')); setTimeout(() => document.documentElement.classList.add('ready'), 100);</script>
</head>
<body class="bg-[#F1F5F9] font-plus"
      x-data="{
          heading:          '{{ old('heading', $cta->heading ?? 'Your Journey Starts Now.') }}',
          headingHighlight: '{{ old('heading_highlight', $cta->heading_highlight ?? 'Starts Now.') }}',
          description:      '{{ old('description', $cta->description ?? '') }}',
          buttonText:       '{{ old('button_text', $cta->button_text ?? 'Join as a Organizer') }}',
          buttonUrl:        '{{ old('button_url', $cta->button_url ?? '/organizer/register') }}',
          buttonBg:         '{{ old('button_bg_color', $cta->button_bg_color ?? '#FFE700') }}',
          buttonTextColor:  '{{ old('button_text_color', $cta->button_text_color ?? '#1B2B46') }}',
          bgImageUrl:       '{{ old('bg_image_url', $cta->bg_image_url ?? '') }}',
          successModal: {{ session('success') ? 'true' : 'false' }},
      }">

    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <!-- Header -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">CTA Section</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Homepage — Final Call-to-Action</p>
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
                    <form action="{{ route('admin.home.cta.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Content -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <h3 class="font-outfit font-black text-dark text-lg border-b border-slate-100 pb-4">Content</h3>

                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Main Heading <span class="text-red-500">*</span></label>
                                <input type="text" name="heading" x-model="heading"
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>

                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Highlighted Part of Heading</label>
                                <input type="text" name="heading_highlight" x-model="headingHighlight"
                                       placeholder="e.g. Starts Now."
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                <p class="text-[10px] text-slate-400 mt-1.5 font-medium">This part of the heading will be displayed in the yellow accent colour.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Description</label>
                                <textarea name="description" x-model="description" rows="3"
                                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none"></textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Background Image URL</label>
                                <input type="url" name="bg_image_url" x-model="bgImageUrl" placeholder="https://..."
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <h3 class="font-outfit font-black text-dark text-lg border-b border-slate-100 pb-4">Button</h3>

                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Button Label <span class="text-red-500">*</span></label>
                                    <input type="text" name="button_text" x-model="buttonText"
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Button URL <span class="text-red-500">*</span></label>
                                    <input type="text" name="button_url" x-model="buttonUrl"
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Button Background</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" name="button_bg_color" x-model="buttonBg" class="w-12 h-10 rounded-lg border border-slate-200 cursor-pointer">
                                        <input type="text" x-model="buttonBg" class="flex-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary/30">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Button Text Color</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" name="button_text_color" x-model="buttonTextColor" class="w-12 h-10 rounded-lg border border-slate-200 cursor-pointer">
                                        <input type="text" x-model="buttonTextColor" class="flex-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary/30">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 bg-primary text-white font-black text-sm tracking-widest uppercase rounded-2xl hover:bg-secondary transition-all shadow-lg shadow-primary/20">
                            <i class="fas fa-save mr-2"></i> Save CTA Section
                        </button>
                    </form>
                </div>

                <!-- Live Preview -->
                <div class="lg:col-span-1">
                    <div class="sticky top-28">
                        <p class="text-xs font-black text-dark uppercase tracking-widest mb-4">Live Preview</p>
                        <div class="rounded-3xl overflow-hidden relative"
                             :style="bgImageUrl ? 'background-image: url(' + bgImageUrl + '); background-size: cover; background-position: center;' : 'background-color: #4F0B67;'">
                            <div class="absolute inset-0 bg-[#4F0B67]/80"></div>
                            <div class="relative z-10 py-12 px-6 text-center flex flex-col items-center gap-6">
                                <h2 class="font-outfit text-3xl font-black leading-tight tracking-tighter" style="color: #FFE700;">
                                    <template x-if="headingHighlight && heading.includes(headingHighlight)">
                                        <span x-html="heading.replace(headingHighlight, '<span style=\'color:#FFE700\'>' + headingHighlight + '</span>').replace(heading.replace(headingHighlight,''), '<span class=\'text-white\'>' + heading.replace(headingHighlight,'') + '</span>')"></span>
                                    </template>
                                    <template x-if="!headingHighlight || !heading.includes(headingHighlight)">
                                        <span class="text-white" x-text="heading || 'Your Journey Starts Now.'"></span>
                                    </template>
                                </h2>
                                <p class="text-white/70 text-sm font-medium leading-relaxed" x-text="description || 'CTA description appears here...'"></p>
                                <button class="px-8 py-3 rounded-2xl font-black text-sm transition-all"
                                        :style="'background-color:' + buttonBg + '; color:' + buttonTextColor"
                                        x-text="buttonText || 'Button Label'"></button>
                            </div>
                        </div>
                        <div class="mt-4 bg-white rounded-2xl p-4 shadow-sm border border-slate-100">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Button URL</p>
                            <p class="text-xs font-semibold text-primary truncate" x-text="buttonUrl || '/'"></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Success Popup Modal -->
    <div x-show="successModal" x-cloak
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="successModal = false"></div>
        <div class="relative bg-white rounded-3xl p-10 max-w-sm w-full shadow-2xl text-center"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="w-20 h-20 bg-green-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check-circle text-green-500 text-4xl"></i>
            </div>
            <h3 class="font-outfit font-black text-dark text-2xl mb-2">Updated!</h3>
            <p class="text-slate-400 text-sm font-medium mb-8">The CTA section has been updated and is now live on the homepage.</p>
            <div class="flex gap-3">
                <button @click="successModal = false" class="flex-1 py-3.5 bg-slate-100 text-slate-600 font-black text-xs tracking-widest uppercase rounded-2xl hover:bg-slate-200 transition-all">
                    Close
                </button>
                <a href="/" target="_blank" class="flex-1 py-3.5 bg-primary text-white font-black text-xs tracking-widest uppercase rounded-2xl hover:bg-secondary transition-all text-center">
                    View Page
                </a>
            </div>
        </div>
    </div>
</body>
</html>
