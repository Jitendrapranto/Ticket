<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Contact Card | Ticket Kinun Admin</title>
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
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Create Contact Card</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><a href="{{ route('admin.contact.cards.index') }}" class="hover:text-primary">Contact Cards</a> / Create</p>
            </div>
        </header>

        <main class="p-8 flex-1">
            <div class="max-w-2xl mx-auto bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
                <form action="{{ route('admin.contact.cards.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Email Support" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                        @error('title') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Description</label>
                        <textarea name="description" rows="3" required placeholder="Brief description text..." class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-medium text-sm">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Action Text (Link Title)</label>
                            <input type="text" name="action_text" value="{{ old('action_text') }}" placeholder="e.g. support@ticketkinun.com" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none transition-all font-bold text-sm">
                            @error('action_text') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Action URL / Link</label>
                            <input type="text" name="action_url" value="{{ old('action_url') }}" placeholder="mailto:support@ticketkinun.com" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none font-mono text-sm">
                            @error('action_url') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">FontAwesome Icon Class</label>
                            <input type="text" name="icon" value="{{ old('icon', 'fas fa-envelope') }}" required class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none font-mono text-sm">
                            @error('icon') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Sort Order</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none font-mono text-sm">
                        </div>
                    </div>

                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 flex flex-col gap-6 mt-6">
                        <h4 class="font-outfit text-sm font-black text-slate-800 uppercase tracking-tight border-b border-slate-200 pb-2"><i class="fas fa-palette text-primary mr-2"></i> Design & Colors</h4>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div x-data="{ color: '{{ old('bg_color', '#fffbf0') }}' }">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Card Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" x-model="color" @input="$refs.bgInput.value = color" class="h-10 w-12 cursor-pointer rounded overflow-hidden border-none outline-none">
                                    <input type="text" name="bg_color" x-ref="bgInput" x-model="color" class="flex-1 bg-white border border-slate-200 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none font-mono text-xs">
                                </div>
                            </div>
                            
                            <div x-data="{ color: '{{ old('theme_color', '#f59e0b') }}' }">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Theme (Icon/Border/Link)</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" x-model="color" @input="$refs.themeInput.value = color" class="h-10 w-12 cursor-pointer rounded overflow-hidden border-none outline-none">
                                    <input type="text" name="theme_color" x-ref="themeInput" x-model="color" class="flex-1 bg-white border border-slate-200 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none font-mono text-xs">
                                </div>
                            </div>

                            <div x-data="{ color: '{{ old('title_color', '#92400e') }}' }">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" x-model="color" @input="$refs.titleInput.value = color" class="h-10 w-12 cursor-pointer rounded overflow-hidden border-none outline-none">
                                    <input type="text" name="title_color" x-ref="titleInput" x-model="color" class="flex-1 bg-white border border-slate-200 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none font-mono text-xs">
                                </div>
                            </div>

                            <div x-data="{ color: '{{ old('desc_color', '#b45309') }}' }">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Description Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" x-model="color" @input="$refs.descInput.value = color" class="h-10 w-12 cursor-pointer rounded overflow-hidden border-none outline-none">
                                    <input type="text" name="desc_color" x-ref="descInput" x-model="color" class="flex-1 bg-white border border-slate-200 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none font-mono text-xs">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex gap-4">
                        <a href="{{ route('admin.contact.cards.index') }}" class="flex-1 text-center py-4 rounded-xl font-black tracking-widest uppercase hover:bg-slate-100 transition-all text-slate-500">Cancel</a>
                        <button type="submit" class="flex-1 bg-primary text-white py-4 rounded-xl font-black tracking-widest uppercase hover:bg-primary-dark transition-all shadow-lg hover:shadow-primary/20">
                            Create Card
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
