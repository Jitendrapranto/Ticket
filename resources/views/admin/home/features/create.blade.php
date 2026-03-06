<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Platform Feature | Ticket Kinun Admin</title>
    <style>html { visibility: hidden; opacity: 0; } html.ready { visibility: visible; opacity: 1; transition: opacity 0.15s ease-in; }</style>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#520C6B', secondary: '#21032B', accent: '#FF7D52', dark: '#0F172A' },
                    fontFamily: { outfit: ['Arial', 'Helvetica', 'sans-serif'], plus: ['Arial', 'Helvetica', 'sans-serif'] },
                }
            }
        }
    </script>
    <script>document.addEventListener('DOMContentLoaded', () => document.documentElement.classList.add('ready')); setTimeout(() => document.documentElement.classList.add('ready'), 100);</script>
</head>
<body class="bg-[#F1F5F9] font-plus"
      x-data="{
          icon: 'fas fa-star',
          title: '',
          description: '',
          actionLabel: 'Learn More',
          cardBg: '#F3EEFF',
          iconBg: '#520C6B',
          accentColor: '#520C6B',
          borderColor: '#E9D5FF'
      }">
    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Add Feature Card</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">New Homepage Feature</p>
            </div>
            <a href="{{ route('admin.home.features.index') }}" class="flex items-center gap-2 bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-xs font-black tracking-widest hover:bg-slate-200 transition-all uppercase">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </header>

        <main class="p-8 flex-1">
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-2xl p-5 mb-8 flex items-start gap-4">
                <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                <ul class="text-sm text-red-600 font-semibold space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Form -->
                <div class="lg:col-span-2">
                    <form action="{{ route('admin.home.features.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <h3 class="font-outfit font-black text-dark text-lg border-b border-slate-100 pb-4">Content</h3>

                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">FontAwesome Icon Class <span class="text-red-500">*</span></label>
                                <div class="flex gap-3">
                                    <input type="text" name="icon" x-model="icon" value="{{ old('icon', 'fas fa-star') }}"
                                           placeholder="e.g. fas fa-ticket-alt"
                                           class="flex-1 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-md shrink-0" :style="'background-color:' + iconBg">
                                        <i :class="icon + ' text-xl'"></i>
                                    </div>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1.5 font-medium">Browse icons at <a href="https://fontawesome.com/icons" target="_blank" class="text-primary font-black underline">fontawesome.com/icons</a></p>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Title <span class="text-red-500">*</span></label>
                                <input type="text" name="title" x-model="title" value="{{ old('title') }}" placeholder="e.g. Smart Ticketing"
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>

                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Description <span class="text-red-500">*</span></label>
                                <textarea name="description" x-model="description" rows="3" placeholder="Short description for this feature..."
                                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none">{{ old('description') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Action Label <span class="text-red-500">*</span></label>
                                <input type="text" name="action_label" x-model="actionLabel" value="{{ old('action_label', 'Learn More') }}"
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <h3 class="font-outfit font-black text-dark text-lg border-b border-slate-100 pb-4">Colors</h3>

                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Card Background</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" name="card_bg" x-model="cardBg" value="{{ old('card_bg', '#F3EEFF') }}" class="w-12 h-10 rounded-lg border border-slate-200 cursor-pointer">
                                        <input type="text" :value="cardBg" x-model="cardBg" class="flex-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary/30">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Icon Background</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" name="icon_bg" x-model="iconBg" value="{{ old('icon_bg', '#520C6B') }}" class="w-12 h-10 rounded-lg border border-slate-200 cursor-pointer">
                                        <input type="text" :value="iconBg" x-model="iconBg" class="flex-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary/30">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Accent / Link Color</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" name="accent_color" x-model="accentColor" value="{{ old('accent_color', '#520C6B') }}" class="w-12 h-10 rounded-lg border border-slate-200 cursor-pointer">
                                        <input type="text" :value="accentColor" x-model="accentColor" class="flex-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary/30">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Border Color</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" name="border_color" x-model="borderColor" value="{{ old('border_color', '#E9D5FF') }}" class="w-12 h-10 rounded-lg border border-slate-200 cursor-pointer">
                                        <input type="text" :value="borderColor" x-model="borderColor" class="flex-1 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary/30">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                            <h3 class="font-outfit font-black text-dark text-lg border-b border-slate-100 pb-4">Settings</h3>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-black text-dark text-sm">Active / Visible</p>
                                    <p class="text-[11px] text-slate-400 font-medium mt-0.5">Show this card on the homepage</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                                    <div class="w-12 h-6 bg-slate-200 peer-focus:ring-2 peer-focus:ring-primary/30 rounded-full peer peer-checked:after:translate-x-6 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                </label>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-dark uppercase tracking-widest mb-2">Sort Order</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 bg-primary text-white font-black text-sm tracking-widest uppercase rounded-2xl hover:bg-secondary transition-all shadow-lg shadow-primary/20">
                            <i class="fas fa-plus mr-2"></i> Create Feature Card
                        </button>
                    </form>
                </div>

                <!-- Live Preview -->
                <div class="lg:col-span-1">
                    <div class="sticky top-28">
                        <p class="text-xs font-black text-dark uppercase tracking-widest mb-4">Live Preview</p>
                        <div class="rounded-3xl p-8 flex flex-col gap-5 border transition-all"
                             :style="'background-color:' + cardBg + '; border-color:' + borderColor">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-md" :style="'background-color:' + iconBg">
                                <i :class="icon + ' text-white text-xl'"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-dark text-xl mb-2" x-text="title || 'Feature Title'"></h3>
                                <p class="text-slate-500 text-sm leading-relaxed" x-text="description || 'Feature description text appears here...'"></p>
                            </div>
                            <span class="font-black text-[10px] tracking-[0.2em] uppercase mt-auto" :style="'color:' + accentColor" x-text="(actionLabel || 'Learn More') + ' →'"></span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
