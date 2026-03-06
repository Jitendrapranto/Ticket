@extends('layouts.app')

@section('title', 'Welcome Back - Organizer Login')

@section('content')
<div class="min-h-screen flex items-center justify-center py-20 px-4 bg-[#21032B] relative overflow-hidden h-screen" style="margin-top: -100px;">
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-full h-full opacity-20 pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-accent rounded-full blur-[120px]"></div>
    </div>

    <div class="max-w-4xl w-full grid grid-cols-1 lg:grid-cols-2 bg-white rounded-[2.5rem] overflow-hidden shadow-2xl relative z-10 animate-fadeInUp">
        
        <!-- Left Side: Branding -->
        <div class="hidden lg:flex flex-col justify-between p-12 bg-[#1A0222] text-white relative">
            <div class="absolute inset-0 opacity-10">
                <div class="flex flex-wrap gap-4 p-4">
                    @for($i = 0; $i < 20; $i++)
                        <i class="fas fa-lock text-4xl transform -rotate-12"></i>
                    @endfor
                </div>
            </div>
            
            <div class="relative z-10">
                <a href="/">
                    <img src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Ticket Kinun" class="h-16 brightness-0 invert">
                </a>
                <div class="mt-16 space-y-6">
                    <h2 class="font-outfit text-4xl font-black leading-tight tracking-tight">Access Your <span class="text-primary">Organizer</span> Access.</h2>
                    <p class="text-slate-400 font-medium leading-relaxed">Log in to manage your events, review past events, and update your preferences.</p>
                </div>
            </div>

            <div class="relative z-10 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-primary/20 flex items-center justify-center">
                    <i class="fas fa-shield-alt text-primary"></i>
                </div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Secure Bank-Level Encryption</span>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="p-8 md:p-12">
            <div class="lg:hidden text-center mb-10">
                <img src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Ticket Kinun" class="mx-auto h-12">
            </div>

            <div class="mb-10">
                <h2 class="font-outfit text-2xl font-black text-dark tracking-tight">Organizer Login</h2>
                <p class="text-slate-400 text-sm font-medium">Please enter your details to login.</p>
            </div>

            <form action="{{ route('organizer.login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Email Address</label>
                    <input name="email" type="email" required value="{{ old('email') }}"
                        class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3.5 px-4 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner"
                        placeholder="john@example.com">
                    @error('email') <p class="text-[9px] text-red-500 font-bold ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <div class="flex justify-between items-center ml-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Password</label>
                        <a href="#" class="text-[9px] font-black text-primary uppercase tracking-widest hover:underline">Forgot?</a>
                    </div>
                    <input name="password" type="password" required 
                        class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3.5 px-4 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="w-4 h-4 rounded border-slate-200 text-primary focus:ring-primary/20">
                    <label for="remember" class="ml-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Keep me logged in</label>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-[#3D0851] text-white py-4 rounded-xl font-black text-xs tracking-widest transition-all shadow-xl shadow-primary/10 active:scale-[0.98] uppercase">
                    Secure Login
                </button>

                <p class="text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-8">
                    Don't have an account? <a href="{{ route('organizer.register') }}" class="text-primary hover:underline ml-1">Register as Organizer</a>
                </p>
            </form>
        </div>
    </div>
</div>

<style>
    body { background-color: #21032B !important; }
    header, footer { display: none !important; }
</style>
@endsection
