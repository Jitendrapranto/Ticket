<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Gallery Asset | Ticket Kinun Admin</title>
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
                    boxShadow: { 'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.15)' }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F1F5F9] text-slate-800 font-plus">
    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <form action="{{ route('admin.gallery.images.store') }}" method="POST" enctype="multipart/form-data" 
              x-data="{ 
                  preview: null, 
                  handleFile(e) {
                      const file = e.target.files[0];
                      if (!file) return;
                      const reader = new FileReader();
                      reader.onload = (event) => { this.preview = event.target.result; };
                      reader.readAsDataURL(file);
                  }
              }">
            @csrf
            
            <header class="h-24 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-12 sticky top-0 z-40">
                <div class="flex items-center gap-6">
                    <a href="{{ route('admin.gallery.images.index') }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 text-dark hover:bg-white transition-all border border-slate-100 shadow-sm">
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                    <div>
                        <h2 class="font-outfit text-2xl font-black text-dark tracking-tight">Enroll New Visual</h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Adding to the visual exhibition</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <a href="{{ route('admin.gallery.images.index') }}" class="text-xs font-black text-slate-400 hover:text-dark transition-colors uppercase tracking-[0.2em] mr-4">Discard</a>
                    <button type="submit" class="bg-primary text-white px-10 py-4 rounded-2xl text-xs font-black tracking-widest hover:bg-primary-dark transition-all uppercase shadow-xl shadow-primary/20 flex items-center gap-4">
                        <i class="fas fa-paper-plane text-[10px]"></i> Commit to Gallery
                    </button>
                </div>
            </header>

            <main class="p-12 max-w-5xl mx-auto space-y-12">
                @if($errors->any())
                    <div class="bg-red-50/50 border border-red-100 rounded-[2rem] p-8">
                        <div class="flex items-center gap-4 mb-4 text-red-500">
                            <i class="fas fa-exclamation-circle text-xl"></i>
                            <h4 class="font-black text-sm uppercase tracking-widest">Registration Incomplete</h4>
                        </div>
                        <ul class="space-y-2">
                            @foreach ($errors->all() as $error)
                                <li class="text-[11px] text-red-400 font-bold flex items-center gap-3">
                                    <span class="w-1 h-1 bg-red-400 rounded-full"></span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Form Controls -->
                    <div class="space-y-10">
                        <div class="bg-white rounded-[3rem] p-10 shadow-premium border border-slate-50 space-y-8">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <h3 class="font-outfit text-lg font-black text-dark tracking-tight uppercase">Asset Identity</h3>
                            </div>

                            <div class="space-y-10">
                                <!-- Exhibition Title -->
                                <div class="space-y-3 px-2">
                                    <label class="text-[10px] font-black text-slate-400 tracking-[0.25em] uppercase ml-1 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-primary/40"></span>
                                        Exhibition Title
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-primary/30 group-focus-within:text-primary transition-all duration-300">
                                            <i class="fas fa-quote-left text-xs"></i>
                                        </div>
                                        <input type="text" 
                                               name="title" 
                                               value="{{ old('title') }}" 
                                               required 
                                               class="w-full bg-white border border-slate-200/60 rounded-[1.5rem] py-5 pl-14 pr-8 outline-none focus:border-primary/40 focus:ring-4 focus:ring-primary/5 focus:bg-white transition-all text-dark font-bold text-sm shadow-sm hover:border-slate-300" 
                                               placeholder="e.g. Neon Nights Symphony">
                                    </div>
                                </div>

                                <!-- Category Selection -->
                                <div class="space-y-3 px-2">
                                    <label class="text-[10px] font-black text-slate-400 tracking-[0.25em] uppercase ml-1 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-primary/40"></span>
                                        Gallery Category
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-primary/30 group-focus-within:text-primary transition-all duration-300 pointer-events-none z-10">
                                            <i class="fas fa-tags text-xs"></i>
                                        </div>
                                        <select name="category_id" 
                                                required 
                                                class="w-full bg-white border border-slate-200/60 rounded-[1.5rem] py-5 pl-14 pr-12 outline-none focus:border-primary/40 focus:ring-4 focus:ring-primary/5 focus:bg-white transition-all text-dark font-bold text-sm appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23520C6B%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C/polyline%3E%3C/svg%3E')] bg-[length:1rem] bg-[right_1.75rem_center] bg-no-repeat relative z-0 shadow-sm hover:border-slate-300">
                                            <option value="" disabled selected>Select categorization</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-dark rounded-[3rem] p-10 text-white relative overflow-hidden group border border-white/5 shadow-2xl">
                            <i class="fas fa-quote-left text-6xl text-white/5 absolute -top-4 -left-4"></i>
                            <h4 class="font-outfit text-xl font-bold mb-4 relative z-10">Curator's Note</h4>
                            <p class="text-white/40 text-sm font-light leading-relaxed relative z-10">Selected visuals should reflect the high-energy and exclusive nature of the Ticket Kinun platform.</p>
                        </div>
                    </div>

                    <!-- Image Upload Hub -->
                    <div class="bg-white rounded-[3rem] p-10 shadow-premium border border-slate-50 flex flex-col items-center justify-center text-center space-y-8 min-h-[500px]">
                        <!-- Single Hidden File Input -->
                        <input type="file" id="imageInput" name="image" required class="hidden" accept="image/*" @change="handleFile($event)">

                        <div x-show="!preview" class="space-y-6 flex flex-col items-center">
                            <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 text-4xl shadow-inner animate-pulse">
                                <i class="fas fa-camera"></i>
                            </div>
                            <div>
                                <h3 class="font-outfit text-xl font-black text-dark tracking-tight uppercase">Capture the Essence</h3>
                                <p class="text-slate-400 text-sm font-medium mt-2">Recommended: 16:9 Aspect • Max 5MB</p>
                            </div>
                            <button type="button" @click="document.getElementById('imageInput').click()" class="bg-primary-dark text-white px-10 py-5 rounded-2xl font-black text-xs tracking-widest uppercase cursor-pointer hover:bg-black transition-all shadow-xl shadow-primary/10">
                                <i class="fas fa-folder-open mr-3"></i> Browse Assets
                            </button>
                        </div>

                        <div x-show="preview" x-cloak class="w-full h-full relative group rounded-[2rem] overflow-hidden bg-slate-50 shadow-inner">
                            <img :src="preview" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" @click="document.getElementById('imageInput').click()" class="bg-white text-dark px-8 py-4 rounded-xl font-black text-xs tracking-widest uppercase cursor-pointer hover:bg-primary hover:text-white transition-all">
                                    <i class="fas fa-sync mr-2"></i> Change Asset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </form>
    </div>
</body>
</html>
