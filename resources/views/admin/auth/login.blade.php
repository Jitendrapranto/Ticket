@extends('admin.dashboard')

@section('admin_content')
<div class="flex flex-col items-center justify-center w-full relative">
    <!-- Background Accents -->
    <div class="absolute top-0 left-0 w-full h-full opacity-30 pointer-events-none">
        <div class="absolute -top-48 -left-48 w-[100%] h-[100%] bg-primary/20 rounded-full blur-[150px]"></div>
        <div class="absolute -bottom-48 -right-48 w-[100%] h-[100%] bg-secondary/10 rounded-full blur-[150px]"></div>
    </div>

    <div class="max-w-md w-full relative z-10 px-6">
        <div class="text-center mb-10">
            <img loading="lazy" src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Ticket Kinun Logo" class="h-20 mx-auto mb-6">
            <h1 class="text-3xl font-black text-primary tracking-tight">Super Admin Portal</h1>
            <p class="text-slate-500 mt-2 font-medium">Securely access your management dashboard</p>
        </div>

        <div class="bg-white rounded-[2.5rem] p-10 shadow-premium overflow-hidden relative group border border-white">
            <!-- Form Header Decor -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary via-primary-dark to-secondary"></div>

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Admin Email</label>
                    <div class="relative group">
                        <i class="fas fa-user-shield absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                        <input type="email" name="email" required autofocus
                            oninput="this.value = this.value.toLowerCase()"
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 pl-12 pr-6 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner"
                            placeholder="admin@ticketkinun.com">
                    </div>
                </div>

                <div class="space-y-2" x-data="{ showPassword: false }">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Security Key</label>
                    <div class="relative group">
                        <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 pl-12 pr-14 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner"
                            placeholder="••••••••">
                        <button type="button" @click="showPassword = !showPassword" 
                                class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 hover:text-primary transition-colors focus:outline-none">
                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                @if($errors->any())
                    <div class="bg-red-50 p-4 rounded-xl border border-red-100 text-red-500 text-[10px] font-black uppercase tracking-widest">
                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ $errors->first() }}
                    </div>
                @endif



                <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white py-5 rounded-2xl font-black text-xs tracking-[0.2em] transition-all shadow-[0_10px_30px_-10px_rgba(82,12,107,0.4)] active:scale-[0.98] uppercase flex items-center justify-center gap-3">
                    <i class="fas fa-shield-alt"></i> Access Dashboard
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-slate-50 text-center">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest flex items-center justify-center gap-2">
                    <i class="fas fa-lock text-[8px]"></i> Authorized Personnel Only
                </p>
            </div>
        </div>

        <div class="mt-10 text-center">
            <a href="/" class="text-slate-500 hover:text-primary transition-all text-[11px] font-black uppercase tracking-widest flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Live Site
            </a>
        </div>
    </div>
</div>
@endsection
