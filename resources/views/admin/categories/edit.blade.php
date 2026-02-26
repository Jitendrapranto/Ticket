<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category | Ticket Kinun Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#520C6B', 'primary-dark': '#21032B', accent: '#FF7D52', dark: '#0F172A' },
                    fontFamily: { outfit: ['Outfit', 'sans-serif'], plus: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    boxShadow: { 'premium': '0 20px 50px -12px rgba(82, 12, 107, 0.15)' }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F1F5F9] text-slate-800 font-plus">
    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark hover:bg-slate-100 transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Edit Category</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Update {{ $category->name }}</p>
                </div>
            </div>
        </header>

        <main class="p-8 flex-1 max-w-4xl mx-auto w-full">
            @if(session('error') || $errors->any())
                <!-- Error Notification -->
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 10000)" x-show="show" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="translate-x-full opacity-0"
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-end="translate-x-full opacity-0"
                     class="fixed top-8 right-8 z-[150] max-w-sm w-full">
                    <div class="bg-red-950 rounded-[2rem] shadow-2xl p-6 flex flex-col gap-4 relative overflow-hidden text-white border border-red-500/20">
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-red-500"></div>
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 bg-red-500/20 rounded-2xl flex items-center justify-center text-xl shadow-inner text-red-500"><i class="fas fa-exclamation-triangle"></i></div>
                            <div class="flex-1 text-left">
                                <h4 class="text-sm font-black italic tracking-tight uppercase tracking-tight">Update Failed</h4>
                                <p class="text-[10px] text-red-200/60 mt-0.5 leading-tight font-bold italic tracking-widest uppercase">Verification needed</p>
                            </div>
                        </div>
                        <div class="space-y-1 bg-black/20 p-4 rounded-xl">
                            @if(session('error'))
                                <p class="text-[11px] text-red-100 font-medium">{{ session('error') }}</p>
                            @endif
                            @foreach ($errors->all() as $error)
                                <p class="text-[10px] text-red-100/80 font-medium flex items-center gap-2">
                                    <span class="w-1 h-1 bg-red-400 rounded-full"></span>
                                    {{ $error }}
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-[3rem] shadow-premium border border-slate-50 overflow-hidden">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-10 space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Category Name</label>
                            <input type="text" name="name" value="{{ $category->name }}" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">FontAwesome Icon</label>
                            <input type="text" name="icon" value="{{ $category->icon }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Description</label>
                        <textarea name="description" rows="5" class="w-full bg-slate-50 border border-slate-100 rounded-[2.5rem] p-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-medium text-sm leading-relaxed">{{ $category->description }}</textarea>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-primary to-primary-dark text-white px-12 py-5 rounded-[1.5rem] font-black text-xs tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all active:scale-95 uppercase">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
