<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery Hero | Ticket Kinun Admin</title>
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#520C6B',
                        'primary-dark': '#21032B',
                        accent: '#FF7D52',
                        dark: '#0F172A',
                        brand: '#520C6B',
                    },
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        plus: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    boxShadow: {
                        'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.15)',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F1F5F9] text-slate-800">

    <!-- Sidebar Inclusion -->
    @include('admin.sidebar')

    <!-- Main Content Wrapper -->
    <div class="lg:ml-72 min-h-screen flex flex-col">

        <!-- Header / Topbar -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40 shadow-sm">
            <div class="flex items-center gap-4">
                <button id="toggle-sidebar" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Gallery Space</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Update Hero Section Content</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ url('/gallery') }}" target="_blank" class="hidden sm:flex items-center gap-2 px-6 py-2.5 bg-slate-50 text-dark rounded-xl text-xs font-black tracking-widest hover:bg-slate-100 transition-all uppercase">
                    <i class="fas fa-external-link-alt text-[10px]"></i> View Gallery
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-8 flex-1">
            <div class="max-w-4xl mx-auto">

                <!-- Success Toast Notification -->
                @if(session('success'))
                <div x-data="{ show: true }"
                     x-init="setTimeout(() => show = false, 5000)"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="translate-x-full opacity-0"
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="translate-x-0 opacity-100"
                     x-transition:leave-end="translate-x-full opacity-0"
                     class="fixed top-8 right-8 z-[150] max-w-sm w-full font-plus">

                    <div class="bg-[#21032B] rounded-[2rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.4)] border border-white/5 p-6 flex items-center gap-6 relative overflow-hidden group text-white">
                        <!-- Left Accent Bar -->
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-primary"></div>

                        <!-- Icon -->
                        <div class="w-12 h-12 bg-white/10 text-white rounded-2xl flex items-center justify-center text-xl shadow-inner">
                            <i class="fas fa-check-circle"></i>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <h4 class="text-sm font-black tracking-tight uppercase">Success!</h4>
                            <p class="text-[11px] text-white/60 font-medium leading-tight mt-1">{{ session('success') }}</p>
                        </div>

                        <!-- Close Button -->
                        <button @click="show = false" class="text-white/30 hover:text-white transition-colors p-2">
                            <i class="fas fa-times text-xs"></i>
                        </button>

                        <!-- Progress Bar -->
                        <div class="absolute bottom-0 left-2 right-0 h-0.5 bg-white/5">
                            <div class="h-full bg-white/20 animate-[progress_5s_linear_forwards]"></div>
                        </div>
                    </div>
                </div>

                <style>
                    @keyframes progress { from { width: 0%; } to { width: 100%; } }
                </style>
                @endif

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
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Badge Headline</label>
                            <div class="relative group">
                                <i class="fas fa-tag absolute left-6 top-1/2 -translate-y-1/2 text-primary/30 group-focus-within:text-primary transition-colors"></i>
                                <input type="text" name="badge_text" value="{{ $hero->badge_text }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 pl-14 pr-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-black text-sm" placeholder="e.g. VISUAL JOURNEY">
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Dramatic Title</label>
                            <div class="relative group">
                                <i class="fas fa-heading absolute left-6 top-1/2 -translate-y-1/2 text-primary/30 group-focus-within:text-primary transition-colors"></i>
                                <input type="text" name="title" value="{{ $hero->title }}" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 pl-14 pr-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-black text-sm" placeholder="e.g. Moments In Motion.">
                            </div>
                            <p class="text-[9px] text-slate-400 ml-4 font-medium">* Tip: Use a period at the end for a punchy, cinematic feel.</p>
                        </div>

                        <!-- Subtitle -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Story Narrative (Subtitle)</label>
                            <div class="relative group">
                                <textarea name="subtitle" rows="5" class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] p-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-medium text-sm leading-relaxed" placeholder="Share the essence of these captured memories...">{{ $hero->subtitle }}</textarea>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none">Live Content Sync Active</p>
                            <button type="submit" class="bg-gradient-to-r from-primary to-primary-dark text-white px-12 py-5 rounded-[1.5rem] font-black text-xs tracking-[0.2em] shadow-premium hover:-translate-y-1 hover:shadow-2xl transition-all active:scale-95 uppercase flex items-center gap-3">
                                <i class="fas fa-paper-plane text-[10px]"></i> Update Hero Section
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Interactive Preview -->
                <div class="mt-12 bg-dark rounded-[3.5rem] p-16 text-white relative overflow-hidden group border border-white/5 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-transparent"></div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('toggle-sidebar');

            function toggleMenu() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                setTimeout(() => {
                    overlay.classList.toggle('opacity-0');
                }, 10);
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', toggleMenu);
            }
            if (overlay) {
                overlay.addEventListener('click', toggleMenu);
            }
        });
    </script>
    <style>
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fadeInUp { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</body>
</html>
