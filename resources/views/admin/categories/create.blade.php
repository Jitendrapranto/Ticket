@extends('admin.dashboard')

@section('admin_content')
<div>

    

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

        <header class="mb-8 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-dark hover:bg-slate-100 transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-outfit text-xl font-black text-dark tracking-tight">Create Category</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">New Event Category</p>
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
                                <h4 class="text-sm font-black tracking-tight uppercase tracking-tight">System Alert</h4>
                                <p class="text-[10px] text-red-200/60 mt-0.5 leading-tight font-bold tracking-widest uppercase">Data validation failed</p>
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
                <form action="{{ route('admin.categories.store') }}" method="POST" class="p-10 space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Category Name</label>
                            <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="e.g. Music, Sports">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">FontAwesome Icon</label>
                            <input type="text" name="icon" class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-5 px-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-bold text-sm" placeholder="e.g. fas fa-music">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 tracking-[0.2em] uppercase ml-4">Description</label>
                        <textarea name="description" rows="5" class="w-full bg-slate-50 border border-slate-100 rounded-[2.5rem] p-8 outline-none focus:border-primary/30 focus:bg-white transition-all text-dark font-medium text-sm leading-relaxed" placeholder="Tell us about this category..."></textarea>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-primary to-primary-dark text-white px-12 py-5 rounded-[1.5rem] font-black text-xs tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all active:scale-95 uppercase">
                            Register Category
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

</div>
@endsection
