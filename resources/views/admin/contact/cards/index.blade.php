<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contact Cards | Ticket Kinun Admin</title>
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
<body class="bg-[#F1F5F9] text-slate-800 font-plus" x-data="{ 
    deleteModal: false, 
    deleteUrl: '', 
    itemName: '',
    confirmDelete(url, name) {
        this.deleteUrl = url;
        this.itemName = name;
        this.deleteModal = true;
    }
}">
    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Contact Info Cards</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Manage Contact Display Cards</p>
            </div>
            <a href="{{ route('admin.contact.cards.create') }}" class="bg-accent text-white px-6 py-2.5 rounded-xl text-xs font-black tracking-widest hover:bg-dark transition-all uppercase shadow-lg shadow-accent/20">
                <i class="fas fa-plus mr-2"></i> Add Contact Card
            </a>
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($cards as $card)
                    <div class="rounded-[2rem] p-10 shadow-sm border hover:shadow-md transition-all relative group" style="background: {{ $card->bg_color }}; border-top: 4px solid {{ $card->theme_color }};">
                        
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white mb-8 shadow-sm transition-transform group-hover:-translate-y-2" style="background: {{ $card->theme_color }}">
                            <i class="{{ $card->icon }}"></i>
                        </div>
                        
                        <h3 class="font-bold text-xl mb-3 tracking-tight" style="color: {{ $card->title_color }}">{{ $card->title }}</h3>
                        <p class="text-sm leading-relaxed font-medium mb-4" style="color: {{ $card->desc_color }}">
                            {{ Str::limit($card->description, 100) }}
                        </p>
                        
                        @if($card->action_text)
                            <p class="text-xs font-black tracking-widest uppercase" style="color: {{ $card->theme_color }}">{{ $card->action_text }}</p>
                        @endif

                        <p class="text-[10px] text-gray-400 mt-4 font-mono">Order: {{ $card->sort_order }}</p>

                        <!-- Actions -->
                        <div class="absolute top-4 right-4 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.contact.cards.edit', $card) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/50 backdrop-blur text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm border border-white/40">
                                <i class="fas fa-edit text-[10px]"></i>
                            </a>
                            <button @click="confirmDelete('{{ route('admin.contact.cards.destroy', $card) }}', '{{ $card->title }}')" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/50 backdrop-blur text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm border border-white/40">
                                <i class="fas fa-trash-alt text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-400 font-bold bg-white rounded-3xl border border-dashed border-slate-200">
                        No contact cards configured yet. Click "Add Contact Card" to get started!
                    </div>
                @endforelse
            </div>
        </main>

        <!-- Professional Delete Modal -->
        <div x-show="deleteModal" 
             x-cloak
             class="fixed inset-0 z-[150] flex items-center justify-center px-4 overflow-hidden"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            
            <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="deleteModal = false"></div>

            <div class="bg-white w-full max-w-[440px] rounded-[3rem] shadow-2xl relative z-10 overflow-hidden"
                 x-transition:enter="transition ease-out duration-300 translate-y-4"
                 x-transition:enter-start="translate-y-8 scale-95"
                 x-transition:enter-end="translate-y-0 scale-100">
                
                <div class="p-12 text-center">
                    <div class="w-24 h-24 bg-red-50 text-red-500 rounded-[2rem] flex items-center justify-center text-4xl mx-auto mb-10 shadow-inner">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>

                    <h3 class="font-outfit text-3xl font-black text-dark tracking-tight mb-4">Are you sure?</h3>
                    <p class="text-slate-400 text-[15px] font-medium leading-relaxed mb-10 px-4">
                        You are about to delete the "<span class="text-dark font-black" x-text="itemName"></span>" card. <br>This action cannot be undone.
                    </p>

                    <div class="flex items-center gap-5">
                        <button @click="deleteModal = false" class="flex-1 py-5 rounded-[1.5rem] bg-[#F8FAFC] text-slate-500 font-black text-[11px] tracking-widest hover:bg-slate-100 transition-all uppercase">
                            Cancel
                        </button>
                        <form :action="deleteUrl" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-5 rounded-[1.5rem] bg-[#EF4444] text-white font-black text-[11px] tracking-widest hover:bg-red-600 transition-all uppercase shadow-xl shadow-red-500/20">
                                Yes, Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
