<!-- Global Success Toast -->
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
     class="fixed top-8 right-8 z-[200] max-w-sm w-full font-plus pointer-events-none">

    <div class="bg-[#1B2B46] rounded-[2rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.4)] border border-white/5 p-6 flex items-center gap-6 relative overflow-hidden pointer-events-auto group text-white text-left">
        <!-- Left Accent Bar -->
        <div class="absolute left-0 top-0 bottom-0 w-2 bg-[#520C6B]"></div>

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
            <div class="h-full bg-white/20 animate-[toast-progress_5s_linear_forwards]"></div>
        </div>
    </div>
</div>

<style>
    @keyframes toast-progress { from { width: 0%; } to { width: 100%; } }
</style>
@endif

<!-- Global Error Toast -->
@if(session('error'))
<div x-data="{ show: true }"
     x-init="setTimeout(() => show = false, 5000)"
     x-show="show"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="translate-x-full opacity-0"
     x-transition:enter-end="translate-x-0 opacity-100"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="translate-x-0 opacity-100"
     x-transition:leave-end="translate-x-full opacity-0"
     class="fixed top-8 right-8 z-[200] max-w-sm w-full font-plus pointer-events-none">

    <div class="bg-[#1B2B46] rounded-[2rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.4)] border border-white/5 p-6 flex items-center gap-6 relative overflow-hidden pointer-events-auto group text-white text-left">
        <!-- Left Accent Bar -->
        <div class="absolute left-0 top-0 bottom-0 w-2 bg-brand-red"></div>

        <!-- Icon -->
        <div class="w-12 h-12 bg-white/10 text-white rounded-2xl flex items-center justify-center text-xl shadow-inner">
            <i class="fas fa-exclamation-circle text-brand-red"></i>
        </div>

        <!-- Content -->
        <div class="flex-1">
            <h4 class="text-sm font-black tracking-tight uppercase">Warning</h4>
            <p class="text-[11px] text-white/60 font-medium leading-tight mt-1">{{ session('error') }}</p>
        </div>

        <!-- Close Button -->
        <button @click="show = false" class="text-white/30 hover:text-white transition-colors p-2">
            <i class="fas fa-times text-xs"></i>
        </button>

        <!-- Progress Bar -->
        <div class="absolute bottom-0 left-2 right-0 h-0.5 bg-white/5">
            <div class="h-full bg-brand-red/30 animate-[toast-progress_5s_linear_forwards]"></div>
        </div>
    </div>
</div>
@endif
