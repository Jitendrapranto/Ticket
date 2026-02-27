<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit About Statistic | Ticket Kinun Admin</title>
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
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Edit Statistic</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><a href="{{ route('admin.about.statistics.index') }}" class="hover:text-primary">About Us Statistics</a> / Edit</p>
            </div>
        </header>

        <main class="p-8 flex-1">
            <div class="max-w-2xl mx-auto bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
                <form action="{{ route('admin.about.statistics.update', $statistic) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Value (e.g. 500+)</label>
                        <input type="text" name="value" value="{{ old('value', $statistic->value) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold" required>
                        @error('value')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Label (e.g. GLOBAL EVENTS)</label>
                        <input type="text" name="label" value="{{ old('label', $statistic->label) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold" required>
                        @error('label')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">FontAwesome Icon (e.g. fas fa-globe)</label>
                        <input type="text" name="icon" value="{{ old('icon', $statistic->icon) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold" required>
                        @error('icon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div x-data="{ color: '{{ old('color', $statistic->color) }}' }">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Accent Color</label>
                        <div class="flex items-center gap-4">
                            <input type="color" name="color" x-model="color" class="h-12 w-20 cursor-pointer rounded-lg border-none">
                            <input type="text" x-model="color" class="flex-1 bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-mono">
                        </div>
                        @error('color')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $statistic->sort_order) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                        @error('sort_order')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="pt-6 flex gap-4">
                        <a href="{{ route('admin.about.statistics.index') }}" class="flex-1 text-center py-4 rounded-xl font-black tracking-widest uppercase hover:bg-slate-100 transition-all text-slate-500">Cancel</a>
                        <button type="submit" class="flex-1 bg-primary text-white py-4 rounded-xl font-black tracking-widest uppercase hover:bg-primary-dark transition-all shadow-lg hover:shadow-primary/20">
                            Update Statistic
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
