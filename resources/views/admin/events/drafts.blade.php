@extends('admin.dashboard')

@section('admin_content')
<div x-data="{
    deleteModal: false,
    deleteUrl: '',
    eventName: '',
    confirmDelete(url, name) {
        this.deleteUrl = url;
        this.eventName = name;
        this.deleteModal = true;
    }
}">
    <div class="animate-fadeIn">
            <!-- Success Toast Notification -->
            @if(session('success'))
            <div x-data="{ show: true }"
                 x-init="setTimeout(() => show = false, 5000)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="translate-x-full opacity-0"
                 x-transition:enter-end="translate-x-0 opacity-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="translate-x-0 opacity-100"
                 x-transition:leave-end="translate-x-full opacity-0"
                 class="fixed top-8 right-8 z-[150] max-w-sm w-full font-plus">

                <div class="bg-[#1B2B46] rounded-[2rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.4)] border border-white/5 p-6 flex items-center gap-6 relative overflow-hidden group text-white text-left">
                    <!-- Left Accent Bar -->
                    <div class="absolute left-0 top-0 bottom-0 w-2 bg-primary"></div>

                    <!-- Icon -->
                    <div class="w-12 h-12 bg-white/10 text-white rounded-2xl flex items-center justify-center text-xl shadow-inner">
                        <i class="fas fa-check-circle"></i>
                    </div>

                    <!-- Content -->
                    <div class="flex-1">
                        <h4 class="text-sm font-black tracking-tight uppercase">Success!</h4>
                        <p class="text-[11px] text-white/60 font-medium leading-tight mt-1">{{ session('success') }}</p>
                    </div>

                    <!-- Close Button -->
                    <button @click="show = false" class="text-white/30 hover:text-white transition-colors p-2">
                        <i class="fas fa-times text-xs"></i>
                    </button>

                    <!-- Progress Bar -->
                    <div class="absolute bottom-0 left-2 right-0 h-0.5 bg-white/5">
                        <div class="h-full bg-white/20 animate-[progress_5s_linear_forwards]"></div>
                    </div>
                </div>
            </div>

            <style>
                @keyframes progress { from { width: 0%; } to { width: 100%; } }
            </style>
            @endif

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 shrink-0">
            <div>
                <h1 class="font-outfit text-4xl font-black text-dark tracking-tighter mb-1">Event <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Draft Queue.</span></h1>
                <p class="text-slate-400 font-bold uppercase text-[9px] tracking-[0.4em]">Operations Hub • Pending Launch</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.events.create') }}" class="bg-primary text-white px-8 py-3 rounded-2xl text-[10px] font-black tracking-widest hover:bg-dark transition-all uppercase shadow-lg shadow-primary/20">
                    <i class="fas fa-plus mr-2"></i> New Draft
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 text-[10px] font-black tracking-widest text-slate-400 uppercase border-b border-slate-100">
                            <th class="px-8 py-6">Draft Details</th>
                            <th class="px-8 py-6">Category</th>
                            <th class="px-8 py-6">Status</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($events as $event)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <p class="font-black text-dark tracking-tight group-hover:text-primary transition-colors">{{ $event->title }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Draft ID: #{{ $event->id }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <span class="font-bold text-slate-400 text-sm whitespace-nowrap">{{ $event->category->name }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></div>
                                    <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Awaiting Publication</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-3 items-center">
                                    <form action="{{ route('admin.events.publish', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 text-white text-[10px] font-black tracking-widest hover:bg-dark transition-all uppercase shadow-md shadow-blue-600/10">
                                            <i class="fas fa-paper-plane"></i> Publish
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.events.edit', $event) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-primary/5 text-primary hover:bg-primary hover:text-white transition-all">
                                        <i class="fas fa-edit text-xs"></i>
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
                            <td colspan="4" class="px-8 py-24 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200 mx-auto mb-6 shadow-inner">
                                    <i class="fas fa-layer-group text-3xl"></i>
                                </div>
                                <h3 class="font-outfit text-xl font-black text-dark tracking-tight">Empty Draft Queue</h3>
                                <p class="text-slate-400 text-sm font-medium mt-2">All events are currently live in the system.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($events->hasPages())
            <div class="px-8 py-6 bg-slate-50/30 border-t border-slate-100">
                {{ $events->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Delete Modal Overlay -->
    <div x-show="deleteModal" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" @click="deleteModal = false"></div>
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl relative z-10 p-10 text-center animate-fadeInUp">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-8 animate-bounce">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="font-outfit text-2xl font-black text-dark mb-4">Confirm Deletion</h3>
            <p class="text-slate-400 text-sm mb-8">Are you sure you want to remove <span class="font-bold text-dark" x-text="eventName"></span>?</p>
            <div class="flex gap-4">
                <button @click="deleteModal = false" class="flex-1 py-4 rounded-2xl bg-slate-50 text-slate-500 font-black uppercase tracking-widest text-[10px]">Cancel</button>
                <form :action="deleteUrl" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-4 rounded-2xl bg-red-500 text-white font-black uppercase tracking-widest text-[10px]">Yes, Remove</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
