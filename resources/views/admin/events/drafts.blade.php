<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draft Events | Ticket Kinun Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#520C6B', 'primary-dark': '#21032B', accent: '#FF7D52', dark: '#0F172A', secondary: '#21032B' },
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
    eventName: '',
    confirmDelete(url, name) {
        this.deleteUrl = url;
        this.eventName = name;
        this.deleteModal = true;
    }
}">
    @include('admin.sidebar')

    <div class="lg:ml-72 min-h-screen flex flex-col">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Draft Queue</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Unpublished Event Prep</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="px-4 py-1.5 bg-primary/5 rounded-lg text-[10px] font-black text-primary tracking-widest uppercase">
                    {{ $events->total() }} Pending Drafts
                </span>
                <a href="{{ route('admin.events.create') }}" class="bg-primary text-white px-6 py-2.5 rounded-xl text-xs font-black tracking-widest hover:bg-dark transition-all uppercase shadow-lg shadow-primary/20">
                    <i class="fas fa-plus mr-2"></i> New Draft
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
                     class="fixed top-8 right-8 z-[100] max-w-sm w-full">
                    <div class="bg-secondary rounded-[2rem] shadow-2xl p-6 flex items-center gap-6 relative overflow-hidden text-white border border-white/5">
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-primary"></div>
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-xl shadow-inner"><i class="fas fa-check-circle"></i></div>
                        <div class="flex-1 text-left">
                            <h4 class="text-sm font-black italic tracking-tight">Operation Successful</h4>
                            <p class="text-[11px] text-white/60 mt-0.5 leading-tight">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 text-[10px] font-black tracking-widest text-slate-400 uppercase">
                                <th class="px-8 py-6">Draft Details</th>
                                <th class="px-8 py-6">Category</th>
                                <th class="px-8 py-6">Setup Progress</th>
                                <th class="px-8 py-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($events as $event)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-6">
                                    <p class="font-black text-dark tracking-tight italic group-hover:text-primary transition-colors">{{ $event->title }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Draft ID: #{{ $event->id }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="font-bold text-slate-400 italic text-sm">{{ $event->category->name }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden max-w-[100px]">
                                            <div class="h-full bg-primary" style="width: 70%"></div>
                                        </div>
                                        <span class="text-[10px] font-black text-primary uppercase">Ready to Publish</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-3 items-center">
                                        <form action="{{ route('admin.events.publish', $event) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-[10px] font-black tracking-widest hover:bg-dark transition-all uppercase shadow-md shadow-blue-600/10">
                                                <i class="fas fa-paper-plane"></i> Quick Launch
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.events.edit', $event) }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-primary text-white text-[10px] font-black tracking-widest hover:bg-dark transition-all uppercase shadow-md shadow-primary/10">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button @click="confirmDelete('{{ route('admin.events.destroy', $event) }}', '{{ $event->title }}')" 
                                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200 mx-auto mb-6">
                                        <i class="fas fa-layer-group text-3xl"></i>
                                    </div>
                                    <h3 class="font-outfit text-xl font-black text-dark tracking-tight">No Drafts Found</h3>
                                    <p class="text-slate-400 text-sm font-medium mt-2">All events are currently published or none have been created yet.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                @if($events->hasPages())
                <div class="px-8 py-6 bg-slate-50/30 border-t border-slate-50 flex items-center justify-between">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        Showing {{ $events->firstItem() }}-{{ $events->lastItem() }} of {{ $events->total() }} Drafts
                    </p>
                    <div class="flex items-center gap-2">
                        @if ($events->onFirstPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-100 text-slate-300 cursor-not-allowed italic">
                                <i class="fas fa-chevron-left text-[10px]"></i>
                            </span>
                        @else
                            <a href="{{ $events->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-100 text-slate-600 hover:bg-primary hover:text-white transition-all shadow-sm">
                                <i class="fas fa-chevron-left text-[10px]"></i>
                            </a>
                        @endif

                        <div class="flex items-center gap-1">
                            @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                                @if ($page == $events->currentPage())
                                    <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white font-black text-[10px] shadow-lg shadow-primary/20">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 font-bold text-[10px] hover:bg-white hover:text-primary transition-all">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        @if ($events->hasMorePages())
                            <a href="{{ $events->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-100 text-slate-600 hover:bg-primary hover:text-white transition-all shadow-sm">
                                <i class="fas fa-chevron-right text-[10px]"></i>
                            </a>
                        @else
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-100 text-slate-300 cursor-not-allowed italic">
                                <i class="fas fa-chevron-right text-[10px]"></i>
                            </span>
                        @endif
                    </div>
                </div>
                @endif
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
             x-transition:leave-end="opacity-0">
            
            <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="deleteModal = false"></div>

            <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden">
                <div class="p-10 text-center">
                    <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-8 shadow-inner animate-bounce">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>

                    <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-4">Discard Draft?</h3>
                    <p class="text-slate-400 text-sm font-medium leading-relaxed mb-8">
                        You are about to discard the draft <span class="text-dark font-bold italic" x-text="eventName"></span>. This action will permanently remove all progress for this event.
                    </p>

                    <div class="flex items-center gap-4">
                        <button @click="deleteModal = false" class="flex-1 py-4 rounded-2xl bg-slate-50 text-slate-500 font-black text-xs tracking-widest hover:bg-slate-100 transition-all uppercase">
                            Cancel
                        </button>
                        <form :action="deleteUrl" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-4 rounded-2xl bg-red-500 text-white font-black text-xs tracking-widest hover:bg-red-600 transition-all uppercase shadow-lg shadow-red-500/20">
                                Yes, Discard
                            </button>
                        </form>
                    </div>
                </div>
                <div class="h-1.5 bg-red-500 w-full opacity-20"></div>
            </div>
        </div>
    </div>
</body>
</html>
