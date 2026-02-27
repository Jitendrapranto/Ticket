<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact Hero | Ticket Kinun Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#520C6B', 'primary-dark': '#21032B', secondary: '#21032B', accent: '#FF7D52', dark: '#0F172A' },
                    fontFamily: { outfit: ['Outfit', 'sans-serif'], plus: ['"Plus Jakarta Sans"', 'sans-serif'] },
                }
            }
        }
    </script>
</head>
<body class="bg-[#F1F5F9] text-slate-800 font-plus">
    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Contact Hero Section</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><a href="#" class="hover:text-primary">Contact Page</a> / Edit Hero</p>
            </div>
        </header>

        <main class="p-8 flex-1">
            @if(session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="translate-x-full opacity-0"
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-end="translate-x-full opacity-0"
                     class="fixed top-8 right-8 z-[100] max-w-sm w-full">
                    <div class="bg-secondary rounded-[2rem] shadow-2xl p-6 flex items-center gap-6 relative overflow-hidden text-white border border-white/5">
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-primary"></div>
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-xl shadow-inner"><i class="fas fa-check-circle"></i></div>
                        <div class="flex-1 text-left">
                            <h4 class="text-sm font-black tracking-tight">Operation Successful</h4>
                            <p class="text-[11px] text-white/60 mt-0.5 leading-tight">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.contact.hero.update') }}" method="POST" class="max-w-3xl mx-auto bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                @csrf
                @method('PUT')
                
                <div class="p-10 space-y-8">
                    
                    <div>
                        <h3 class="font-outfit text-lg font-black text-[#1e293b] mb-6 border-b border-slate-100 pb-2"><i class="fas fa-image mr-2 text-primary"></i> Hero Content</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Badge Text</label>
                                <input type="text" name="badge_text" value="{{ old('badge_text', $hero->badge_text) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                                @error('badge_text') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title (White Part)</label>
                                    <input type="text" name="title_main" value="{{ old('title_main', $hero->title_main) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                                    @error('title_main') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title (Highlighted Part)</label>
                                    <input type="text" name="title_accent" value="{{ old('title_accent', $hero->title_accent) }}" class="w-full bg-slate-50 border border-slate-200 text-primary rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-black">
                                    @error('title_accent') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Subtitle / Description</label>
                                <textarea name="subtitle" rows="4" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-medium text-sm">{{ old('subtitle', $hero->subtitle) }}</textarea>
                                @error('subtitle') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="bg-slate-50 p-8 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="bg-primary text-white px-8 py-4 rounded-xl font-black tracking-widest uppercase hover:bg-primary-dark transition-all shadow-lg hover:shadow-primary/20">
                        Update Hero Section
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
