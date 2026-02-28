@extends('layouts.app')

@section('title', 'Join Ticket Kinun - Signup')

@section('content')
<div class="min-h-screen -mt-40 flex items-center justify-center py-20 px-4 bg-[#21032B] relative overflow-hidden">
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
                        <i class="fas fa-ticket-alt text-4xl transform -rotate-12"></i>
                    @endfor
                </div>
            </div>
            
            <div class="relative z-10">
                <a href="/">
                    <img src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Ticket Kinun" class="h-16 brightness-0 invert">
                </a>
                <div class="mt-16 space-y-6">
                    <h2 class="font-outfit text-4xl font-black leading-tight tracking-tight">Unlock the World of <span class="text-primary italic">Live Events.</span></h2>
                    <p class="text-slate-400 font-medium leading-relaxed">Join thousands of fans and get early access to concerts, sports, and exclusive gatherings.</p>
                </div>
            </div>

            <div class="relative z-10 flex items-center gap-4">
                <div class="flex -space-x-3">
                    <img src="https://i.pravatar.cc/100?u=1" class="w-10 h-10 rounded-full border-2 border-[#1A0222]">
                    <img src="https://i.pravatar.cc/100?u=2" class="w-10 h-10 rounded-full border-2 border-[#1A0222]">
                    <img src="https://i.pravatar.cc/100?u=3" class="w-10 h-10 rounded-full border-2 border-[#1A0222]">
                </div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">50k+ Members</span>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="p-8 md:p-12">
            <div class="lg:hidden text-center mb-10">
                <img src="{{ asset('Blue_Simple_Technology_Logo.png') }}" alt="Ticket Kinun" class="mx-auto h-12">
            </div>

            <div class="mb-8">
                <h2 class="font-outfit text-2xl font-black text-dark tracking-tight">Create Account</h2>
                <p class="text-slate-400 text-sm font-medium">It only takes a minute to get started.</p>
            </div>

            <form action="{{ route('signup') }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Full Name</label>
                        <input name="name" type="text" required value="{{ old('name') }}"
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner"
                            placeholder="John Doe">
                        @error('name') <p class="text-[9px] text-red-500 font-bold ml-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Email</label>
                        <input name="email" type="email" required value="{{ old('email') }}"
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner"
                            placeholder="john@example.com">
                        @error('email') <p class="text-[9px] text-red-500 font-bold ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Password</label>
                        <input name="password" type="password" required 
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner"
                            placeholder="••••••••">
                        @error('password') <p class="text-[9px] text-red-500 font-bold ml-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">Confirm</label>
                        <input name="password_confirmation" type="password" required 
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3 px-4 outline-none focus:border-primary/30 focus:bg-white transition-all text-sm font-bold shadow-inner"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-start gap-2 pt-2">
                    <input name="terms" type="checkbox" required
                        class="w-4 h-4 rounded border-slate-200 text-primary focus:ring-primary/20 mt-0.5">
                    <label class="text-[10px] text-slate-500 font-medium">
                        Agree to <a href="#" class="text-primary font-bold hover:underline">Terms</a> & <a href="#" class="text-primary font-bold hover:underline">Privacy</a>
                    </label>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-[#3D0851] text-white py-4 rounded-xl font-black text-xs tracking-widest transition-all shadow-xl shadow-primary/10 active:scale-[0.98] uppercase">
                    Create Account
                </button>

                <div class="relative py-4">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                    <div class="relative flex justify-center text-[9px] uppercase tracking-widest font-black"><span class="px-4 bg-white text-slate-300">Fast sign up</span></div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <a href="#" class="flex items-center justify-center gap-2 py-2.5 border border-slate-100 rounded-xl hover:bg-slate-50 transition-all text-[10px] font-black text-slate-600 uppercase">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" class="w-3 h-3"> Google
                    </a>
                    <a href="#" class="flex items-center justify-center gap-2 py-2.5 border border-slate-100 rounded-xl hover:bg-slate-50 transition-all text-[10px] font-black text-slate-600 uppercase">
                        <i class="fab fa-facebook text-blue-600"></i> Facebook
                    </a>
                </div>

                <p class="text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-6">
                    Have an account? <a href="{{ route('login') }}" class="text-primary hover:underline ml-1">Login</a>
                </p>
            </form>
        </div>
    </div>
</div>

<style>
    body { background-color: #21032B !important; }
    header, footer { display: none !important; } /* Hide navigation for clean auth experience */
</style>
@endsection
