<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Advantage | Ticket Kinun Admin</title>
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
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Edit Advantage</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><a href="{{ route('admin.about.advantages.index') }}" class="hover:text-primary">Advantages Section</a> / Edit</p>
            </div>
        </header>

        <main class="p-8 flex-1">
            <div class="max-w-2xl mx-auto bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
                <form action="{{ route('admin.about.advantages.update', $advantage) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title', $advantage->title) }}" required class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                        @error('title') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Description</label>
                        <textarea name="description" rows="3" required class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-medium text-sm">{{ old('description', $advantage->description) }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">FontAwesome Icon Class</label>
                            <input type="text" name="icon" value="{{ old('icon', $advantage->icon) }}" placeholder="fas fa-bolt text-xl" required class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none font-mono text-sm">
                            @error('icon') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tailwind Border Class (Optional)</label>
                            <input type="text" name="border_class" value="{{ old('border_class', $advantage->border_class) }}" placeholder="border-orange-50/50" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none font-mono text-sm">
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Sort Order</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $advantage->sort_order) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none font-mono text-sm">
                        </div>
                    </div>

                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 flex flex-col gap-6 mt-6">
                        <h4 class="font-outfit text-sm font-black text-slate-800 uppercase tracking-tight border-b border-slate-200 pb-2"><i class="fas fa-palette text-primary mr-2"></i> Theme Colors</h4>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div x-data="{ color: '{{ old('card_bg_color', $advantage->card_bg_color) }}' }">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Card Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" name="card_bg_color" x-model="color" class="h-10 w-12 cursor-pointer rounded overflow-hidden border-none outline-none">
                                    <input type="text" x-model="color" class="flex-1 bg-white border border-slate-200 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none font-mono">
                                </div>
                            </div>
                            
                            <div x-data="{ color: '{{ old('icon_bg_color', $advantage->icon_bg_color) }}' }">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Icon Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" name="icon_bg_color" x-model="color" class="h-10 w-12 cursor-pointer rounded overflow-hidden border-none outline-none">
                                    <input type="text" x-model="color" class="flex-1 bg-white border border-slate-200 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none font-mono">
                                </div>
                            </div>

                            <div x-data="{ color: '{{ old('title_color', $advantage->title_color) }}' }">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" name="title_color" x-model="color" class="h-10 w-12 cursor-pointer rounded overflow-hidden border-none outline-none">
                                    <input type="text" x-model="color" class="flex-1 bg-white border border-slate-200 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none font-mono">
                                </div>
                            </div>

                            <div x-data="{ color: '{{ old('desc_color', $advantage->desc_color) }}' }">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Description Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" name="desc_color" x-model="color" class="h-10 w-12 cursor-pointer rounded overflow-hidden border-none outline-none">
                                    <input type="text" x-model="color" class="flex-1 bg-white border border-slate-200 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none font-mono">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex gap-4">
                        <a href="{{ route('admin.about.advantages.index') }}" class="flex-1 text-center py-4 rounded-xl font-black tracking-widest uppercase hover:bg-slate-100 transition-all text-slate-500">Cancel</a>
                        <button type="submit" class="flex-1 bg-primary text-white py-4 rounded-xl font-black tracking-widest uppercase hover:bg-primary-dark transition-all shadow-lg hover:shadow-primary/20">
                            Update Advantage
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
