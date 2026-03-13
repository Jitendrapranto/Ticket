<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Settings | Ticket Kinun Admin</title>
    <style>/* FAST LOAD */ html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }</style>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#520C6B', secondary: '#1B2B46', accent: '#2563EB', dark: '#0F172A', 'slate-custom': '#F8FAFC' },
                    fontFamily: { outfit: ['Arial', 'Helvetica', 'sans-serif'], plus: ['Arial', 'Helvetica', 'sans-serif'] },
                    boxShadow: { 'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.25)' }
                }
            }
        }
    </script>
    <script>document.addEventListener('DOMContentLoaded', () => document.documentElement.classList.add('ready')); setTimeout(() => document.documentElement.classList.add('ready'), 100);</script>
</head>
<body class="bg-[#F1F5F9] font-plus"
      x-data="{
          successModal: {{ session('success') ? 'true' : 'false' }},
          showToast: {{ session('success') ? 'true' : 'false' }},
          toastMessage: '{{ session('success') ?? '' }}',
          navLinks: {{ json_encode(old('nav_links', $header->nav_links ?? [['label'=>'HOME','url'=>'/'],['label'=>'EVENTS','url'=>'/events'],['label'=>'GALLERY','url'=>'/gallery'],['label'=>'ABOUT','url'=>'/about'],['label'=>'CONTACT','url'=>'/contact']])) }},
          logoPreview: '{{ $header && $header->logo_path ? (str_starts_with($header->logo_path, 'site/') ? asset('storage/'.$header->logo_path) : asset($header->logo_path)) : asset('Blue_Simple_Technology_Logo.png') }}',
      }"
      x-init="if(showToast) { setTimeout(() => showToast = false, 4000); }">

    @include('admin.sidebar')

    <!-- Toast Notification -->
    <div x-show="showToast" x-cloak
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-6 right-6 z-[9999] flex items-center gap-3 bg-green-500 text-white px-6 py-4 rounded-2xl shadow-2xl shadow-green-500/30">
        <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
            <i class="fas fa-check text-sm"></i>
        </div>
        <span class="text-sm font-bold" x-text="toastMessage"></span>
        <button @click="showToast = false" class="ml-2 text-white/60 hover:text-white"><i class="fas fa-times text-xs"></i></button>
    </div>

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <!-- Header Bar -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Header Settings</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Site Settings — Header Configuration</p>
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

            <form action="{{ route('admin.site.header.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Form -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Logo Section -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <h3 class="font-outfit font-black text-dark text-lg border-b border-slate-100 pb-4">
                                <i class="fas fa-image text-primary mr-2"></i> Logo
                            </h3>
                            <div class="flex items-center gap-6">
                                <div class="w-24 h-24 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden">
                                    <img loading="lazy" :src="logoPreview" class="max-w-full max-h-full object-contain" alt="Logo Preview">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Upload New Logo</label>
                                    <input type="file" name="logo" accept="image/*"
                                           @change="logoPreview = URL.createObjectURL($event.target.files[0])"
                                           class="w-full text-sm file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-primary/10 file:text-primary hover:file:bg-primary/20 file:tracking-widest file:uppercase cursor-pointer">
                                    <p class="text-[10px] text-slate-400 mt-2 font-medium">Recommended: PNG with transparent background. Max 5MB.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Search & Auth Text -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <h3 class="font-outfit font-black text-dark text-lg border-b border-slate-100 pb-4">
                                <i class="fas fa-text-height text-primary mr-2"></i> Header Content
                            </h3>
                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Search Placeholder <span class="text-red-500">*</span></label>
                                <input type="text" name="search_placeholder"
                                       value="{{ old('search_placeholder', $header->search_placeholder ?? 'Search for Movies, Events, Plays, Sports and Activities') }}"
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Login Button Text <span class="text-red-500">*</span></label>
                                    <input type="text" name="login_text"
                                           value="{{ old('login_text', $header->login_text ?? 'Login') }}"
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Signup Button Text <span class="text-red-500">*</span></label>
                                    <input type="text" name="signup_text"
                                           value="{{ old('signup_text', $header->signup_text ?? 'Sign Up') }}"
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                <h3 class="font-outfit font-black text-dark text-lg">
                                    <i class="fas fa-link text-primary mr-2"></i> Navigation Links
                                </h3>
                                <button type="button" @click="navLinks.push({label:'', url:''})"
                                        class="flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-xl text-xs font-black tracking-widest hover:bg-primary/20 transition-all uppercase">
                                    <i class="fas fa-plus"></i> Add Link
                                </button>
                            </div>

                            <template x-for="(link, index) in navLinks" :key="index">
                                <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary text-xs font-black" x-text="index + 1"></div>
                                    <div class="flex-1 grid grid-cols-2 gap-3">
                                        <div>
                                            <input type="text" :name="'nav_links[' + index + '][label]'" x-model="link.label" placeholder="Label (e.g. HOME)"
                                                   class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30">
                                        </div>
                                        <div>
                                            <input type="text" :name="'nav_links[' + index + '][url]'" x-model="link.url" placeholder="URL (e.g. /events)"
                                                   class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30">
                                        </div>
                                    </div>
                                    <button type="button" @click="navLinks.splice(index, 1)"
                                            class="w-9 h-9 bg-red-50 text-red-400 rounded-xl flex items-center justify-center hover:bg-red-100 hover:text-red-600 transition-all">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </template>

                            <div x-show="navLinks.length === 0" class="text-center py-8 text-slate-400">
                                <i class="fas fa-link text-3xl mb-3 block opacity-30"></i>
                                <p class="text-sm font-semibold">No navigation links yet. Click "Add Link" to start.</p>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <button type="submit" class="w-full py-4 bg-primary text-white font-black text-sm tracking-widest uppercase rounded-2xl hover:bg-secondary transition-all shadow-lg shadow-primary/20">
                            <i class="fas fa-save mr-2"></i> Save Header Settings
                        </button>
                    </div>

                    <!-- Live Preview -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-28">
                            <p class="text-xs font-black text-dark uppercase tracking-widest mb-4">Live Preview</p>
                            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                                <!-- Top Row Preview -->
                                <div class="px-4 py-3 flex items-center justify-between border-b border-slate-100">
                                    <img loading="lazy" :src="logoPreview" class="h-8 w-auto object-contain" alt="Logo">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-semibold text-slate-500">Login</span>
                                        <span class="bg-primary text-white text-[9px] font-bold px-3 py-1 rounded-lg">Sign Up</span>
                                    </div>
                                </div>
                                <!-- Nav Preview -->
                                <div class="px-4 py-2 bg-slate-50/80 flex items-center gap-4 overflow-x-auto">
                                    <template x-for="(link, idx) in navLinks" :key="idx">
                                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap" x-text="link.label || 'LINK'"></span>
                                    </template>
                                </div>
                            </div>

                            <div class="mt-4 bg-white rounded-2xl p-4 shadow-sm border border-slate-100">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Nav Links</p>
                                <p class="text-2xl font-black text-primary" x-text="navLinks.length"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
            <h3 class="font-outfit font-black text-dark text-2xl mb-2">Header Updated!</h3>
            <p class="text-slate-400 text-sm font-medium mb-8">The site header has been updated successfully and is now live across all pages.</p>
            <div class="flex gap-3">
                <button @click="successModal = false" class="flex-1 py-3.5 bg-slate-100 text-slate-600 font-black text-xs tracking-widest uppercase rounded-2xl hover:bg-slate-200 transition-all">
                    Close
                </button>
                <a href="/" target="_blank" class="flex-1 py-3.5 bg-primary text-white font-black text-xs tracking-widest uppercase rounded-2xl hover:bg-secondary transition-all text-center">
                    View Site
                </a>
            </div>
        </div>
    </div>
</body>
</html>
