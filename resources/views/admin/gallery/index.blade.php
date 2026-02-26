<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery Images | Ticket Kinun Admin</title>
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
</head>
<body class="bg-[#F1F5F9] text-slate-800 font-plus" x-data="{ 
    deleteModal: false, 
    deleteUrl: '', 
    imageTitle: '',
    confirmDelete(url, title) {
        this.deleteUrl = url;
        this.imageTitle = title;
        this.deleteModal = true;
    }
}">
    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Gallery Hub</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Manage Visual Assets</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="px-4 py-1.5 bg-primary/5 rounded-lg text-[10px] font-black text-primary tracking-widest uppercase">
                    {{ $images->total() }} Dynamic Assets
                </span>
                <a href="{{ route('admin.gallery.images.create') }}" class="bg-primary text-white px-6 py-2.5 rounded-xl text-xs font-black tracking-widest hover:bg-dark transition-all uppercase shadow-lg shadow-primary/20">
                    <i class="fas fa-upload mr-2"></i> Upload Image
                </a>
            </div>
        </header>

        <main class="p-8 flex-1">
            @if(session('success'))
                <!-- Success Toast -->
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="translate-x-full opacity-0"
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-end="translate-x-full opacity-0"
                     class="fixed top-8 right-8 z-[100] max-w-sm w-full font-plus">
                    <div class="bg-secondary rounded-[2rem] shadow-2xl p-6 flex items-center gap-6 relative overflow-hidden text-white border border-white/5">
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-primary"></div>
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-xl shadow-inner"><i class="fas fa-check-circle"></i></div>
                        <div class="flex-1 text-left">
                            <h4 class="text-sm font-black tracking-tight uppercase">Registry Updated</h4>
                            <p class="text-[11px] text-white/60 mt-0.5 leading-tight">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($images as $image)
                    <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-50 overflow-hidden group hover:-translate-y-2 transition-all duration-500">
                        <div class="aspect-square relative overflow-hidden bg-slate-100">
                            <img src="{{ str_starts_with($image->image_path, 'http') ? $image->image_path : asset('storage/' . $image->image_path) }}" alt="{{ $image->title }}" class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-8">
                                <span class="bg-primary/90 backdrop-blur-md px-4 py-1.5 rounded-lg text-white font-black text-[9px] tracking-widest uppercase">
                                    {{ $image->category->name }}
                                </span>
                            </div>
                        </div>
                        <div class="p-8 flex items-center justify-between">
                            <div class="flex-1 min-w-0 mr-4">
                                <h3 class="font-outfit text-lg font-black text-dark tracking-tight truncate">{{ $image->title }}</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Uploaded {{ $image->created_at->diffForHumans() }}</p>
                            </div>
                            <button @click="confirmDelete('{{ route('admin.gallery.images.destroy', $image) }}', '{{ $image->title }}')" 
                                    class="w-12 h-12 flex items-center justify-center rounded-2xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-32 text-center bg-white rounded-[3rem] shadow-premium border border-slate-50">
                        <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 mx-auto mb-8 animate-pulse">
                            <i class="fas fa-images text-4xl"></i>
                        </div>
                        <h3 class="font-outfit text-2xl font-black text-dark tracking-tight">The Gallery is Quiet</h3>
                        <p class="text-slate-400 text-sm font-medium mt-3">Start by uploading some moments to showcase to the world.</p>
                        <a href="{{ route('admin.gallery.images.create') }}" class="mt-10 inline-flex items-center gap-3 bg-primary text-white px-10 py-4 rounded-2xl font-black text-xs tracking-widest uppercase hover:bg-dark transition-all shadow-xl shadow-primary/20">
                            <i class="fas fa-plus"></i> Begin Exhibition
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $images->links() }}
            </div>
        </main>

        <!-- Delete Confirmation Modal -->
        <div x-show="deleteModal" 
             x-cloak
             class="fixed inset-0 z-[150] flex items-center justify-center px-4 overflow-hidden"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="deleteModal = false"></div>

            <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden">
                <div class="p-10 text-center">
                    <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-8 shadow-inner animate-bounce">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>

                    <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-4">De-register Asset?</h3>
                    <p class="text-slate-400 text-sm font-medium leading-relaxed mb-8">
                        You are about to remove <span class="text-dark font-bold" x-text="imageTitle"></span> from the visual exhibition. This cannot be undone.
                    </p>

                    <div class="flex items-center gap-4">
                        <button @click="deleteModal = false" class="flex-1 py-4 rounded-2xl bg-slate-50 text-slate-500 font-black text-xs tracking-widest hover:bg-slate-100 transition-all uppercase">
                            Cancel
                        </button>
                        <form :action="deleteUrl" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-4 rounded-2xl bg-red-500 text-white font-black text-xs tracking-widest hover:bg-red-600 transition-all uppercase shadow-lg shadow-red-500/20">
                                Yes, Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .pagination { display: flex; justify-content: center; gap: 0.5rem; }
        .page-item .page-link { width: 3rem; height: 3rem; display: flex; align-items: center; justify-content: center; border-radius: 1rem; background: white; color: #64748b; font-weight: 700; font-size: 0.75rem; border: 1px solid #f1f5f9; transition: all 0.3s; }
        .page-item.active .page-link { background: #520C6B; color: white; border-color: #520C6B; box-shadow: 0 10px 20px -5px rgba(82, 12, 107, 0.3); }
        .page-item:hover .page-link { background: #520C6B; color: white; border-color: #520C6B; }
    </style>
</body>
</html>
