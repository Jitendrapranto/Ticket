<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Our Story | Ticket Kinun Admin</title>
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
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Our Story Section</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><a href="#" class="hover:text-primary">About Page</a> / Edit Section</p>
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

            <form action="{{ route('admin.about.story.update') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl mx-auto bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                @csrf
                @method('PUT')
                
                <div class="p-10 space-y-8">
                    
                    <!-- General Content section -->
                    <div>
                        <h3 class="font-outfit text-lg font-black text-[#1e293b] mb-6 border-b border-slate-100 pb-2"><i class="fas fa-heading mr-2 text-primary"></i> Main Content</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Badge Text</label>
                                <input type="text" name="badge_text" value="{{ old('badge_text', $story->badge_text) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Image URL (or upload below)</label>
                                <input type="text" name="image" value="{{ old('image', $story->image) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-mono text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Main Title Normal</label>
                                <input type="text" name="title_main" value="{{ old('title_main', $story->title_main) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title Highlighted (Gray)</label>
                                <input type="text" name="title_highlight" value="{{ old('title_highlight', $story->title_highlight) }}" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-bold">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Upload Image</label>
                            <input type="file" name="image_file" class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:tracking-widest file:uppercase file:bg-slate-50 file:text-primary hover:file:bg-slate-100 transition-all">
                            @if($story->image)
                                <img src="{{ $story->image }}" class="w-32 h-20 object-cover mt-4 rounded-xl border border-slate-200">
                            @endif
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Paragraph 1</label>
                                <textarea name="paragraph_1" rows="3" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-medium text-sm">{{ old('paragraph_1', $story->paragraph_1) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Paragraph 2</label>
                                <textarea name="paragraph_2" rows="3" class="w-full bg-slate-50 border border-slate-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all font-medium text-sm">{{ old('paragraph_2', $story->paragraph_2) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-4 border-t border-slate-100">
                        <!-- Mini Card 1 -->
                        <div class="bg-blue-50/30 p-6 rounded-2xl border flex border-blue-50 flex-col gap-4">
                            <h4 class="font-outfit text-sm font-black text-blue-900 mb-2 uppercase tracking-tight"><i class="fas fa-layer-group text-blue-400 mr-2"></i> Mini Card 1</h4>
                            
                            <div>
                                <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2">Title</label>
                                <input type="text" name="card_1_title" value="{{ old('card_1_title', $story->card_1_title) }}" class="w-full bg-white border border-blue-100 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2">Description</label>
                                <textarea name="card_1_description" rows="2" class="w-full bg-white border border-blue-100 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 font-medium">{{ old('card_1_description', $story->card_1_description) }}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2">Icon</label>
                                    <input type="text" name="card_1_icon" value="{{ old('card_1_icon', $story->card_1_icon) }}" class="w-full bg-white border border-blue-100 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none font-mono">
                                </div>
                                <div x-data="{ color: '{{ old('card_1_bg_color', $story->card_1_bg_color) }}' }">
                                    <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2">BG Hex</label>
                                    <div class="flex items-center gap-2">
                                        <input type="color" name="card_1_bg_color" x-model="color" class="h-9 w-12 cursor-pointer rounded border-none">
                                        <input type="text" x-model="color" class="flex-1 bg-white border border-blue-100 text-dark rounded-xl px-2 py-2 text-xs focus:outline-none font-mono">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2">Icon Color Class</label>
                                    <input type="text" name="card_1_icon_color" value="{{ old('card_1_icon_color', $story->card_1_icon_color) }}" class="w-full bg-white border border-blue-100 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none font-mono placeholder:text-gray-300" placeholder="e.g. bg-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Mini Card 2 -->
                        <div class="bg-rose-50/30 p-6 rounded-2xl border flex border-rose-50 flex-col gap-4">
                            <h4 class="font-outfit text-sm font-black text-rose-900 mb-2 uppercase tracking-tight"><i class="fas fa-layer-group text-rose-400 mr-2"></i> Mini Card 2</h4>
                            
                            <div>
                                <label class="block text-[10px] font-black text-rose-400 uppercase tracking-widest mb-2">Title</label>
                                <input type="text" name="card_2_title" value="{{ old('card_2_title', $story->card_2_title) }}" class="w-full bg-white border border-rose-100 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-rose-400 uppercase tracking-widest mb-2">Description</label>
                                <textarea name="card_2_description" rows="2" class="w-full bg-white border border-rose-100 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 font-medium">{{ old('card_2_description', $story->card_2_description) }}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-rose-400 uppercase tracking-widest mb-2">Icon</label>
                                    <input type="text" name="card_2_icon" value="{{ old('card_2_icon', $story->card_2_icon) }}" class="w-full bg-white border border-rose-100 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none font-mono">
                                </div>
                                <div x-data="{ color: '{{ old('card_2_bg_color', $story->card_2_bg_color) }}' }">
                                    <label class="block text-[10px] font-black text-rose-400 uppercase tracking-widest mb-2">BG Hex</label>
                                    <div class="flex items-center gap-2">
                                        <input type="color" name="card_2_bg_color" x-model="color" class="h-9 w-12 cursor-pointer rounded border-none">
                                        <input type="text" x-model="color" class="flex-1 bg-white border border-rose-100 text-dark rounded-xl px-2 py-2 text-xs focus:outline-none font-mono">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-rose-400 uppercase tracking-widest mb-2">Icon Color Class</label>
                                    <input type="text" name="card_2_icon_color" value="{{ old('card_2_icon_color', $story->card_2_icon_color) }}" class="w-full bg-white border border-rose-100 text-dark rounded-xl px-3 py-2 text-sm focus:outline-none font-mono placeholder:text-gray-300" placeholder="e.g. bg-rose-500">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="bg-slate-50 p-8 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="bg-primary text-white px-8 py-4 rounded-xl font-black tracking-widest uppercase hover:bg-primary-dark transition-all shadow-lg hover:shadow-primary/20">
                        Update Core Section
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
