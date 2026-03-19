@extends('admin.dashboard')

@section('admin_content')
<div x-data="{
    deleteModal: false,
    deleteUrl: '',
    itemName: '',
    confirmDelete(url, name) { this.deleteUrl = url; this.itemName = name; this.deleteModal = true; }
}">
    <div class="animate-fadeIn">
        <header class="mb-8 flex items-center justify-between shrink-0">
            <div>
                <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Platform Features</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Homepage Feature Cards</p>
            </div>
            <a href="{{ route('admin.home.features.create') }}" class="flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-xl text-xs font-black tracking-widest hover:bg-secondary transition-all uppercase shadow-lg shadow-primary/20">
                <i class="fas fa-plus mr-2"></i> Add Feature
            </a>
        </header>

        <main class="p-8 flex-1">
            <!-- Toast -->
            @if(session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                 x-transition:enter="transition ease-out duration-500" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-end="translate-x-full opacity-0"
                 class="fixed top-8 right-8 z-[100] max-w-sm w-full">
                <div class="bg-secondary rounded-[2rem] shadow-2xl p-6 flex items-center gap-6 relative overflow-hidden text-white border border-white/5">
                    <div class="absolute left-0 top-0 bottom-0 w-2 bg-primary rounded-l-full"></div>
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-xl"><i class="fas fa-check-circle"></i></div>
                    <div class="flex-1">
                        <h4 class="text-sm font-black tracking-tight">Operation Successful</h4>
                        <p class="text-[11px] text-white/60 mt-0.5">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-white/40 hover:text-white transition-colors"><i class="fas fa-times text-xs"></i></button>
                </div>
            </div>
            @endif

            <!-- Info Banner -->
            <div class="bg-primary/5 border border-primary/10 rounded-2xl px-6 py-4 mb-8 flex items-center gap-4">
                <i class="fas fa-info-circle text-primary text-lg"></i>
                <p class="text-sm font-semibold text-slate-600">These cards are displayed on the homepage under <span class="font-black text-dark">"Everything Optimized For Your Experience"</span>. Changes reflect live immediately.</p>
            </div>

            <!-- Feature Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($features as $feature)
                <div class="rounded-3xl p-8 flex flex-col gap-5 border group relative hover:shadow-xl transition-all duration-300"
                     style="background-color: {{ $feature->card_bg }}; border-color: {{ $feature->border_color }};">
                    <!-- Preview Icon -->
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-md" style="background-color: {{ $feature->icon_bg }};">
                        <i class="{{ $feature->icon }} text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-dark text-lg mb-1">{{ $feature->title }}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-3">{{ $feature->description }}</p>
                    </div>
                    <span class="font-black text-[10px] tracking-[0.2em] uppercase mt-auto" style="color: {{ $feature->accent_color }};">{{ $feature->action_label }} →</span>

                    <!-- Status Badge -->
                    <div class="absolute top-4 left-4">
                        <span class="text-[9px] font-black px-2 py-1 rounded-full {{ $feature->is_active ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                            {{ $feature->is_active ? 'Active' : 'Hidden' }}
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.home.features.edit', $feature) }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm border border-blue-100">
                            <i class="fas fa-edit text-[10px]"></i>
                        </a>
                        <button @click="confirmDelete('{{ route('admin.home.features.destroy', $feature) }}', '{{ addslashes($feature->title) }}')"
                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm border border-red-100">
                            <i class="fas fa-trash-alt text-[10px]"></i>
                        </button>
                    </div>

                    <!-- Sort Order -->
                    <span class="absolute bottom-4 right-4 text-[9px] font-bold text-slate-400">Order: {{ $feature->sort_order }}</span>
                </div>
                @empty
                <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                    <i class="fas fa-layer-group text-4xl text-slate-200 mb-4 block"></i>
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-sm">No feature cards yet.</p>
                    <a href="{{ route('admin.home.features.create') }}" class="mt-4 inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-xl text-xs font-black tracking-widest hover:bg-secondary transition-all">
                        <i class="fas fa-plus"></i> Add First Feature
                    </a>
                </div>
                @endforelse
            </div>
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="deleteModal" x-cloak
         class="fixed inset-0 z-[150] flex items-center justify-center px-4"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         style="display:none;">
        <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="deleteModal = false"></div>
        <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl relative z-10 overflow-hidden"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-8 scale-95" x-transition:enter-end="translate-y-0 scale-100">
            <div class="p-10 text-center">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-8 shadow-inner">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="font-outfit text-2xl font-black text-dark tracking-tight mb-3">Delete Feature?</h3>
                <p class="text-slate-400 text-sm font-medium leading-relaxed mb-8">
                    You are about to delete <span class="text-dark font-black" x-text="'&quot;' + itemName + '&quot;'"></span>. This action cannot be undone and will remove it from the homepage.
                </p>
                <div class="flex gap-4">
                    <button @click="deleteModal = false" class="flex-1 py-4 rounded-2xl bg-slate-50 text-slate-500 font-black text-xs tracking-widest hover:bg-slate-100 transition-all uppercase">
                        Cancel
                    </button>
                    <form :action="deleteUrl" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-4 rounded-2xl bg-red-500 text-white font-black text-xs tracking-widest hover:bg-red-600 transition-all uppercase shadow-lg shadow-red-500/20">
                            Yes, Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="h-1.5 bg-red-500 w-full opacity-20"></div>
        </div>
    </div>

</div>
@endsection
